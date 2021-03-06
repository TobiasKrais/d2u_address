<?php
/**
 * Offers helper functions for language issues
 */
class d2u_address_lang_helper extends \D2U_Helper\ALangHelper {
	/**
	 * @var string[] Array with englisch replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_english = [
		'd2u_address_contact' => 'Contact',
		'd2u_address_email' => 'E-mail',
		'd2u_address_failure_country' => 'Please enter your country.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'Your local Service partner',
		'd2u_address_mobile' => 'Mobile',
		'd2u_address_nearby' => 'Close to you',
		'd2u_address_other_countries' => 'Other Countries',
		'd2u_address_phone' => 'Phone',
		'd2u_address_specialists' => 'Our specialists worldwide are available by telephone to offer advice and support.',
		'd2u_address_zip_code' => 'Postal Code'
	];

	/**
	 * @var string[] Array with german replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_german = [
		'd2u_address_contact' => 'Kontakt',
		'd2u_address_email' => 'E-Mail',
		'd2u_address_failure_country' => 'Bitte geben Sie Ihr Land ein.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'Ihr lokaler Ansprechpartner',
		'd2u_address_mobile' => 'Mobil',
		'd2u_address_nearby' => 'In Ihrer Nähe',
		'd2u_address_other_countries' => 'Weitere Länder',
		'd2u_address_phone' => 'Telefon',
		'd2u_address_specialists' => 'Unsere Spezialisten sind weltweit telefonisch für Sie erreichbar und beraten Sie gerne bezüglich Ihrer individuellen Anliegen.',
		'd2u_address_zip_code' => 'PLZ'
	];

	/**
	 * @var string[] Array with french replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_french = [
		'd2u_address_contact' => 'Contact',
		'd2u_address_email' => 'E-mail',
		'd2u_address_failure_country' => 'Veuillez indiquer votre pays.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'Votre interlocuteur local',
		'd2u_address_mobile' => 'Mobile',
		'd2u_address_nearby' => 'A proximité',
		'd2u_address_other_countries' => 'Autres pays',
		'd2u_address_phone' => 'Téléphone',
		'd2u_address_specialists' => 'Nos spécialistes sont joignable téléphoniquement pour vous à travers le monde entier et ils vous conseilleront volontiers sur vos propres demandes.',
		'd2u_address_zip_code' => 'Code postal'
	];

	/**
	 * @var string[] Array with spanish replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_spanish = [
		'd2u_address_contact' => 'Contacto',
		'd2u_address_email' => 'E-mail',
		'd2u_address_failure_country' => 'Por favor, introduzca su país.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'Su interlocutor local',
		'd2u_address_mobile' => 'Móvil',
		'd2u_address_nearby' => 'Cerca de usted',
		'd2u_address_other_countries' => 'Otros países',
		'd2u_address_phone' => 'Teléfono',
		'd2u_address_specialists' => 'Nuestros especialistas están disponibles en todo el mundo por teléfono y estarán encantados de asesorarle en sus necesidades individuales.',
		'd2u_address_zip_code' => 'Código Postal'
	];

	/**
	 * @var string[] Array with italian replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_italian = [
		'd2u_address_contact' => 'Contatto',
		'd2u_address_email' => 'E-mail',
		'd2u_address_failure_country' => 'La si prega di digitare il Suo paese.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'Il Vostro interlocutore locale',
		'd2u_address_mobile' => 'Mobile',
		'd2u_address_nearby' => 'Vicino a te',
		'd2u_address_other_countries' => 'Altri paesi',
		'd2u_address_phone' => 'Telefono',
		'd2u_address_specialists' => 'I nostri specialisti sono disponibili a livello mondiale per telefono e saranno lieti di consigliarvi sulle tue esigenze individuali.',
		'd2u_address_zip_code' => 'CAP'
	];

	/**
	 * @var string[] Array with polish replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_polish = [
		'd2u_address_contact' => 'Kontakt',
		'd2u_address_email' => 'E-mail',
		'd2u_address_failure_country' => 'Prosimy o wybranie swojego kraju.',
		'd2u_address_fax' => 'Faks',
		'd2u_address_local_servicepartner' => 'Osoba do kontaktów z Państwem na miejscu ',
		'd2u_address_mobile' => 'Mobilny',
		'd2u_address_nearby' => 'Blisko ciebie',
		'd2u_address_other_countries' => 'Inne kraje',
		'd2u_address_phone' => 'Telefon',
		'd2u_address_specialists' => 'Nasi specjaliści są dostępni na całym świecie przez telefon i chętnie doradzą Ci indywidualnie.',
		'd2u_address_zip_code' => 'Kod pocztowy'
	];
	
	/**
	 * @var string[] Array with dutch replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_dutch = [
		'd2u_address_contact' => 'Contact',
		'd2u_address_email' => 'E-mail',
		'd2u_address_failure_country' => 'Voer uw land.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'Uw plaatselijke contactpersoon',
		'd2u_address_mobile' => 'Mobiel',
		'd2u_address_nearby' => 'Dicht bij jou',
		'd2u_address_other_countries' => 'Andere landen',
		'd2u_address_phone' => 'Telefoon',
		'd2u_address_specialists' => 'Onze specialisten zijn wereldwijd telefonisch verkrijgbaar en adviseren u graag op uw individuele wensen.',
		'd2u_address_zip_code' => 'Postcode'
	];

	/**
	 * @var string[] Array with czech replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_czech = [
		'd2u_address_contact' => 'Kontakt',
		'd2u_address_email' => 'E-Mail',
		'd2u_address_failure_country' => 'Prosím zvolte zemi.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'Vaše kontaktní osoba',
		'd2u_address_mobile' => 'Mobilní',
		'd2u_address_nearby' => 'Vám blízké',
		'd2u_address_other_countries' => 'Jiné země',
		'd2u_address_phone' => 'Telefon',
		'd2u_address_specialists' => 'Naši odborníci po celém světě jsou k dispozici na telefonu a jsou ochotni Vám poradit.',
		'd2u_address_zip_code' => 'PSČ',
	];

	/**
	 * @var string[] Array with russian replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_russian = [
		'd2u_address_contact' => 'контакт',
		'd2u_address_email' => 'Электронная почта',
		'd2u_address_failure_country' => 'Пожалуйста, введите название страны.',
		'd2u_address_fax' => 'факс',
		'd2u_address_local_servicepartner' => 'Ваш региональный сервисный партнер',
		'd2u_address_mobile' => 'Mобильный',
		'd2u_address_nearby' => 'Ближайший сервисный центр',
		'd2u_address_other_countries' => 'Другие страны',
		'd2u_address_phone' => 'Телефон',
		'd2u_address_specialists' => 'Наши специалисты доступны по всему миру по телефону и всегда готовы проконсультировать Вас по техническим вопросам.',
		'd2u_address_zip_code' => 'Почтовый код'
	];

	/**
	 * @var string[] Array with portuguese replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_portuguese = [
		'd2u_address_contact' => 'Contato',
		'd2u_address_email' => 'E-mail',
		'd2u_address_failure_country' => 'Introduza o seu país.',
		'd2u_address_fax' => 'Fax',
		'd2u_address_local_servicepartner' => 'O seu parceiro de contacto local',
		'd2u_address_mobile' => 'Móvel',
		'd2u_address_nearby' => 'Perto de você',
		'd2u_address_other_countries' => 'Outros países',
		'd2u_address_phone' => 'Telefone',
		'd2u_address_specialists' => 'Nossos especialistas estão disponíveis em todo o mundo por telefone e ficarão satisfeitos em informá-lo sobre seus requisitos individuais.',
		'd2u_address_zip_code' => 'Código Postal'
	];

	/**
	 * @var string[] Array with chinese replacements. Key is the wildcard,
	 * value the replacement. 
	 */
	protected $replacements_chinese = [
		'd2u_address_contact' => '联系方式',
		'd2u_address_email' => '电子邮件',
		'd2u_address_failure_country' => '请输入您所在的国家。',
		'd2u_address_fax' => '传真',
		'd2u_address_local_servicepartner' => '您的当地联系人',
		'd2u_address_mobile' => '移动',
		'd2u_address_nearby' => '您的附近',
		'd2u_address_other_countries' => '其他国家',
		'd2u_address_phone' => '电话',
		'd2u_address_specialists' => '您可以在全球范围内致电我们的客服专员，就您个人感兴趣的话题进行咨询。',
		'd2u_address_zip_code' => '邮编'
	];
	
	/**
	 * Factory method.
	 * @return d2u_address_lang_helper Object
	 */
	public static function factory() {
		return new self();
	}
	
	/**
	 * Installs the replacement table for this addon.
	 */
	public function install() {
		foreach($this->replacements_english as $key => $value) {
			foreach (rex_clang::getAllIds() as $clang_id) {
				$lang_replacement = rex_config::get('d2u_address', 'lang_replacement_'. $clang_id, '');

				// Load values for input
				if($lang_replacement === 'chinese' && isset($this->replacements_chinese) && isset($this->replacements_chinese[$key])) {
					$value = $this->replacements_chinese[$key];
				}
				else if($lang_replacement === 'czech' && isset($this->replacements_czech) && isset($this->replacements_czech[$key])) {
					$value = $this->replacements_czech[$key];
				}
				else if($lang_replacement === 'dutch' && isset($this->replacements_dutch) && isset($this->replacements_dutch[$key])) {
					$value = $this->replacements_dutch[$key];
				}
				else if($lang_replacement === 'french' && isset($this->replacements_french) && isset($this->replacements_french[$key])) {
					$value = $this->replacements_french[$key];
				}
				else if($lang_replacement === 'german' && isset($this->replacements_german) && isset($this->replacements_german[$key])) {
					$value = $this->replacements_german[$key];
				}
				else if($lang_replacement === 'italian' && isset($this->replacements_italian) && isset($this->replacements_italian[$key])) {
					$value = $this->replacements_italian[$key];
				}
				else if($lang_replacement === 'polish' && isset($this->replacements_polish) && isset($this->replacements_polish[$key])) {
					$value = $this->replacements_polish[$key];
				}
				else if($lang_replacement === 'portuguese' && isset($this->replacements_portuguese) && isset($this->replacements_portuguese[$key])) {
					$value = $this->replacements_portuguese[$key];
				}
				else if($lang_replacement === 'russian' && isset($this->replacements_russian) && isset($this->replacements_russian[$key])) {
					$value = $this->replacements_russian[$key];
				}
				else if($lang_replacement === 'spanish' && isset($this->replacements_spanish) && isset($this->replacements_spanish[$key])) {
					$value = $this->replacements_spanish[$key];
				}
				else { 
					$value = $this->replacements_english[$key];
				}
				
				$overwrite = rex_config::get('d2u_address', 'lang_wildcard_overwrite', FALSE) === "true" ? TRUE : FALSE;
				parent::saveValue($key, $value, $clang_id, $overwrite);
			}
		}
	}
}