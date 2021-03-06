<?php
namespace D2U_Address;

/**
 * Zip code object
 */
class ZipCode {
	/**
	 * @var int Database ID
	 */
	var $zipcode_id = 0;
	
	/**
	 * @var int Redaxo language ID
	 */
	var $clang_id = 0;
	
	/**
	 * @var int Start range
	 */
	var $range_from = 0;
	
	/**
	 * @var int End range
	 */
	var $range_to = 0;
	
	/**
	 * @var Country Country
	 */
	var $country;
	
	/**
	 * @var int[] adress_ids
	 */
	var $address_ids = [];
	
	/**
	 * Constructor
	 * @param int $zipcode_id ID.
	 * @param int $clang_id Redaxo language ID.
	 */
	 public function __construct($zipcode_id, $clang_id) {
		$this->clang_id = $clang_id;
		$query = "SELECT * FROM ". \rex::getTablePrefix() ."d2u_address_zipcodes "
				."WHERE zipcode_id = ". $zipcode_id;
		$result = \rex_sql::factory();
		$result->setQuery($query);

		if ($result->getRows() > 0) {
			$this->zipcode_id = $result->getValue("zipcode_id");
			$this->address_ids = preg_grep('/^\s*$/s', explode("|", $result->getValue("address_ids")), PREG_GREP_INVERT);
			$this->range_from = $result->getValue("range_from");
			$this->range_to = $result->getValue("range_to");
			$this->country = new Country($result->getValue("country_id"), $clang_id);
		}
	}

	
	/**
	 * Deletes the object.
	 */
	public function delete() {
		$query = "DELETE FROM ". \rex::getTablePrefix() ."d2u_address_zipcodes "
			."WHERE zipcode_id = ". $this->zipcode_id;
		$result = \rex_sql::factory();
		$result->setQuery($query);
	}

	/**
	 * Get all zip codes
	 * @param Country $country Country
	 * @param int $zip_code Zipcode
	 * @return ZipCode[] Array with all zip codes for a country
	 */
	public static function get($country, $zip_code) {
		$query = 'SELECT zipcode_id FROM '. \rex::getTablePrefix() .'d2u_address_zipcodes '
			.'WHERE range_from <= '. $zip_code .' AND range_to >= '. $zip_code .' AND country_id = '. $country->country_id;
		$result = \rex_sql::factory();
		$result->setQuery($query);

		if($result->getRows() > 0) {
			$zipcode = new ZipCode($result->getValue("zipcode_id"), $country->clang_id);
			return $zipcode;
		}
		return FALSE;
    }
	
	/**
	 * Get all zip codes
	 * @param int $country_id Country ID
	 * @return ZipCode[] Array with all zip codes for a country
	 */
	public static function getAll($country_id) {
		$query = 'SELECT zipcode_id FROM '. \rex::getTablePrefix() .'d2u_address_zipcodes '
			.'WHERE country_id  = '. $country_id;
		$result = \rex_sql::factory();
		$result->setQuery($query);

		$zip_codes = [];
		for($i = 0; $i < $result->getRows(); $i++) {
			$zip_codes[] = new ZipCode($result->getValue("zipcode_id"), $this->clang_id);
			$result->next();
		}
		
		return $zip_codes;
    }

	/**
	 * Returns addresses for zip code
	 * @param boolean $online_only TRUE to get only online addresses
	 * @return Address[] Found addresses.
	 */
	public function getAdresses($online_only = TRUE) {
		$addresses = [];
		foreach ($this->address_ids as $address_id) {
			$address = new Address($address_id, $this->clang_id);
			if($online_only === FALSE || ($online_only && $address->online_status == "online")) {
				$addresses[$address->priority] = new Address($address_id, $this->clang_id);
			}
		}
		ksort($addresses);
		
		return $addresses;
	}

	/**
	 * Proves whether the object has addresses and in case it has, are these online?
	 * @return boolean TRUE if there are online addresses for the object.
	 */
	public function isOnline() {
		foreach ($this->address_ids as $address_id) {
			$address = new Address($address_id, $this->clang_id);
			if($address->online_status == 'online') {
				return TRUE;
			}
		}

		return FALSE;
    }
	
	/**
	 * Updates or inserts the object into database.
	 * @return boolean TRUE if error occured
	 */
	public function save() {
		$query = \rex::getTablePrefix() ."d2u_address_zipcodes SET "
				."address_ids = '|". implode('|', $this->address_ids) ."|', "
				."range_from = '". $this->range_from ."', "
				."range_to = '". $this->range_to ."', "
				."country_id = ". $this->country->country_id ." ";
		if($this->zipcode_id == 0) {
			$query = "INSERT INTO ". $query;
		}
		else {
			$query = "UPDATE ". $query ." WHERE zipcode_id = ". $this->zipcode_id;
		}

		$result = \rex_sql::factory();
		$result->setQuery($query);
		if($this->zipcode_id == 0) {
			$this->zipcode_id = $result->getLastId();
		}

		return $result->hasError();
	}
}