<?php
// use path relative to __DIR__ to get correct path in update temp dir
$this->includeFile(__DIR__.'/install.php');

// Update database to 1.1.0
$sql = rex_sql::factory();
$sql->setQuery("SHOW COLUMNS FROM ". \rex::getTablePrefix() ."d2u_address_countries LIKE 'address_ids';");
if($sql->getRows() == 1) {
	$sql->setQuery("SELECT country_id, address_ids FROM `". \rex::getTablePrefix() ."d2u_address_countries` WHERE address_ids != '';");
	for($i = 0; $i < $sql->getRows(); $i++) {
		$address_ids = preg_grep('/^\s*$/s', explode("|", $sql->getValue("address_ids")), PREG_GREP_INVERT);
		$sql_update_adresses = rex_sql::factory();
		foreach($address_ids as $address_id) {
			$sql_update_adresses->setQuery("INSERT INTO ". \rex::getTablePrefix() ."d2u_address_2_countries SET country_id = ". $sql->getValue("country_id") .", address_id = ". $address_id);
		}
		$sql->next();
	}
    $sql->setQuery('ALTER TABLE `' . rex::getTablePrefix() . 'd2u_address_countries` DROP `address_ids`;');
}