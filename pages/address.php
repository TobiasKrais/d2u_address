<?php
$func = rex_request('func', 'string');
$entry_id = rex_request('entry_id', 'int');
$message = rex_get('message', 'string');

// Print comments
if($message != "") {
	print rex_view::success(rex_i18n::msg($message));
}

// save settings
if (filter_input(INPUT_POST, "btn_save") == 1 || filter_input(INPUT_POST, "btn_apply") == 1) {
	$form = (array) rex_post('form', 'array', []);

	// Linkmap Link and media needs special treatment
	$link_ids = filter_input_array(INPUT_POST, array('REX_INPUT_LINK'=> array('filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY)));
	$input_media = (array) rex_post('REX_INPUT_MEDIA', 'array', array());

	$address = new D2U_Address\Address($form['address_id'], rex_config::get('d2u_helper', 'default_lang'));
	$address->company = $form['company'];
	$address->company_appendix = $form['company_appendix'];
	$address->contact_name = $form['contact_name'];
	$address->street = $form['street'];
	$address->additional_address = $form['additional_address'];
	$address->zip_code = $form['zip_code'];
	$address->city = $form['city'];
	$address->country = new D2U_Address\Country($form['country_id'], rex_config::get('d2u_helper', 'default_lang'));
	$address->latitude = $form['latitude'];
	$address->longitude = $form['longitude'];
	$address->email = $form['email'];
	$address->url = $form['url'];
	$address->phone = $form['phone'];
	$address->mobile = $form['mobile'];
	$address->fax = $form['fax'];
	$address->picture = $input_media[1];
	$address->address_type_ids = isset($form['address_type_ids']) ? $form['address_type_ids'] : [];
	$address->article_id = $link_ids["REX_INPUT_LINK"][1];
	$address->priority = $form['priority'];
	$address->online_status = array_key_exists('online_status', $form) ? "online" : "offline";
	$address->country_ids = isset($form['country_ids']) ? $form['country_ids'] : [];

	// message output
	$message = 'form_save_error';
	if($address->save() == 0) {
		$message = 'form_saved';
	}
	
	// Redirect to make reload and thus double save impossible
	if(filter_input(INPUT_POST, "btn_apply") == 1 && $address !== FALSE) {
		header("Location: ". rex_url::currentBackendPage(["entry_id"=>$address->address_id, "func"=>'edit', "message"=>$message], FALSE));
	}
	else {
		header("Location: ". rex_url::currentBackendPage(["message"=>$message], FALSE));
	}
	exit;
}
// Delete
else if(filter_input(INPUT_POST, "btn_delete") == 1 || $func == 'delete') {
	$address_id = $entry_id;
	if($address_id == 0) {
		$form = (array) rex_post('form', 'array', []);
		$address_id = $form['address_id'];
	}
	$address = new D2U_Address\Address($address_id, rex_config::get('d2u_helper', 'default_lang'));
	
	// Check if object is used
	$address_types = $address->getReferringAddressTypes();
	$countries = $address->getReferringCountries();
	$zip_codes = $address->getReferringZipCodes();
	
	// If not used, delete
	if(count($address_types) == 0 && count($countries) == 0 && count($zip_codes) == 0) {
		$address = new D2U_Address\Address($address_id, rex_config::get('d2u_helper', 'default_lang'));
		$address->delete();
	}
	else {
		$message = '<ul>';
		foreach($address_types as $address_type) {
			$message .= '<li><a href="index.php?page=d2u_address/address_type&func=edit&entry_id='. $address_type->address_type_id .'">'. $address_type->name .'</a></li>';
		}
		foreach($countries as $country) {
			$message .= '<li><a href="index.php?page=d2u_address/country&func=edit&entry_id='. $country->country_id .'">'. $country->name .'</a></li>';
		}
		foreach($zip_codes as $zip_code) {
			$message .= '<li><a href="index.php?page=d2u_address/address_type&func=edit&entry_id='. $zip_code->zipcode_id .'">'. $zip_code->range_from .' - '. $zip_code->range_to .'</a></li>';
		}
		$message .= '</ul>';

		print rex_view::error(rex_i18n::msg('d2u_helper_could_not_delete') . $message);
	}
	
	$func = '';
}
// Change online status of machine
else if($func == 'changestatus') {
	$address = new D2U_Address\Address($entry_id, rex_config::get("d2u_helper", "default_lang"));
	$address->changeStatus();
	
	header("Location: ". rex_url::currentBackendPage());
	exit;
}

// Eingabeformular
if ($func == 'edit' || $func == 'clone'|| $func == 'add') {
?>
	<form action="<?php print rex_url::currentBackendPage(); ?>" method="post">
		<div class="panel panel-edit">
			<header class="panel-heading"><div class="panel-title"><?php print rex_i18n::msg('d2u_address_address'); ?></div></header>
			<div class="panel-body">
				<input type="hidden" name="form[address_id]" value="<?php echo ($func == 'edit' ? $entry_id : 0); ?>">
				<fieldset>
					<legend><?php echo rex_i18n::msg('d2u_address_address_type'); ?></legend>
					<div class="panel-body-wrapper slide">
						<?php
							$address = new D2U_Address\Address($entry_id, rex_config::get('d2u_helper', 'default_lang'));
							$readonly = TRUE;
							if(\rex::getUser()->isAdmin() || \rex::getUser()->hasPerm('d2u_address[edit_data]')) {
								$readonly = FALSE;
							}
							
							d2u_addon_backend_helper::form_input('d2u_address_company', 'form[company]', $address->company, TRUE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_company_appendix', 'form[company_appendix]', $address->company_appendix, FALSE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_contact_name', 'form[contact_name]', $address->contact_name, FALSE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_street', 'form[street]', $address->street, TRUE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_additional_address', 'form[additional_address]', $address->additional_address, FALSE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_zip_codes', 'form[zip_code]', $address->zip_code, FALSE, $readonly, 'number');
							d2u_addon_backend_helper::form_input('d2u_address_city', 'form[city]', $address->city, TRUE, $readonly);
							$countries = D2U_Address\Country::getAll(rex_config::get('d2u_helper', 'default_lang'));
							$options_countries = [];
							foreach ($countries as $country) {
								$options_countries[$country->country_id] = $country->name;
							}
							d2u_addon_backend_helper::form_select('d2u_address_country', 'form[country_id]', $options_countries, [isset($address->country) ? $address->country->country_id : ''], 1, FALSE, $readonly);
							
							$d2u_helper = rex_addon::get("d2u_helper");
							$api_key = "";
							if($d2u_helper->hasConfig("maps_key")) {
								$api_key = '?key='. $d2u_helper->getConfig("maps_key");

						?>
								<script src="https://maps.googleapis.com/maps/api/js<?php echo $api_key; ?>"></script>
								<script>
									function geocode() {
										if($("input[name='form[street]']").val() === "" || $("input[name='form[city]']").val() === "") {
											alert("<?php echo rex_i18n::msg('d2u_helper_geocode_fields'); ?>");
											return;
										}

										// Geocode
										var geocoder = new google.maps.Geocoder();
										geocoder.geocode({'address': $("input[name='form[street]']").val() + ", " + $("input[name='form[zip_code]']").val() + " " + $("input[name='form[city]']").val()}, function(results, status) {
											if (status === google.maps.GeocoderStatus.OK) {
												$("input[name='form[latitude]']").val(results[0].geometry.location.lat);
												$("input[name='form[longitude]']").val(results[0].geometry.location.lng);
												// Show check geolocation button and set link to button
												$("#check_geocode").attr('href', "https://maps.google.com/?q=" + $("input[name='form[latitude]']").val() + "," + $("input[name='form[longitude]']").val() + "&z=17");
												$("#check_geocode").parent().show();
											}
											else {
												alert("<?php echo rex_i18n::msg('d2u_helper_geocode_failure'); ?>");
											}
										});
									}
								</script>
						<?php
								print '<dl class="rex-form-group form-group" id="geocode">';
								print '<dt><label></label></dt>';
								print '<dd><input type="submit" value="'. rex_i18n::msg('d2u_helper_geocode') .'" onclick="geocode(); return false;" class="btn btn-save">'
									. ' <div class="btn btn-abort"><a href="https://maps.google.com/?q='. $address->latitude .','. $address->longitude .'&z=17" id="check_geocode" target="_blank">'. rex_i18n::msg('d2u_helper_geocode_check') .'</a></div>'
									. '</dd>';
								print '</dl>';
								if($address->latitude == 0 && $address->longitude == 0) {
									print '<script>jQuery(document).ready(function($) { $("#check_geocode").parent().hide(); });</script>';
								}
							}
							d2u_addon_backend_helper::form_infotext('d2u_helper_geocode_hint', 'hint_geocoding');
							d2u_addon_backend_helper::form_input('d2u_address_latitude', 'form[latitude]', ($address->latitude <> 0 ? $address->latitude : ''), TRUE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_longitude', 'form[longitude]', ($address->longitude <> 0 ? $address->longitude : ''), TRUE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_email', 'form[email]', $address->email, FALSE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_url', 'form[url]', $address->url, FALSE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_phone', 'form[phone]', $address->phone, FALSE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_mobile', 'form[mobile]', $address->mobile, FALSE, $readonly);
							d2u_addon_backend_helper::form_input('d2u_address_fax', 'form[fax]', $address->fax, FALSE, $readonly);
							d2u_addon_backend_helper::form_mediafield('d2u_helper_picture', '1', $address->picture, $readonly);
							$adress_types = D2U_Address\AddressType::getAll(rex_config::get('d2u_helper', 'default_lang'));
							$options_address_types = [];
							foreach ($adress_types as $adress_type) {
								$options_address_types[$adress_type->address_type_id] = $adress_type->name;
							}
							d2u_addon_backend_helper::form_select('d2u_address_address_types', 'form[address_type_ids][]', $options_address_types, $address->address_type_ids, 4, TRUE, $readonly);
							d2u_addon_backend_helper::form_linkfield('d2u_helper_article_id', '1', $address->article_id, rex_config::get("d2u_helper", "default_lang"));
							d2u_addon_backend_helper::form_input('d2u_address_priority', 'form[priority]', $address->priority, TRUE, $readonly, 'number');
							$options_status = ['online' => rex_i18n::msg('clang_online'),
								'offline' => rex_i18n::msg('clang_offline')];
							d2u_addon_backend_helper::form_checkbox('d2u_helper_online_status', 'form[online_status]', 'online', $address->online_status == "online", $readonly);
							d2u_addon_backend_helper::form_select('d2u_address_countries_assigned', 'form[country_ids][]', $options_countries, $address->country_ids, 15, TRUE, $readonly);
						?>
					</div>
				</fieldset>
			</div>
			<footer class="panel-footer">
				<div class="rex-form-panel-footer">
					<div class="btn-toolbar">
						<button class="btn btn-save rex-form-aligned" type="submit" name="btn_save" value="1"><?php echo rex_i18n::msg('form_save'); ?></button>
						<button class="btn btn-apply" type="submit" name="btn_apply" value="1"><?php echo rex_i18n::msg('form_apply'); ?></button>
						<button class="btn btn-abort" type="submit" name="btn_abort" formnovalidate="formnovalidate" value="1"><?php echo rex_i18n::msg('form_abort'); ?></button>
						<?php
							if(\rex::getUser()->isAdmin() || \rex::getUser()->hasPerm('d2u_address[edit_data]')) {
								print '<button class="btn btn-delete" type="submit" name="btn_delete" formnovalidate="formnovalidate" data-confirm="'. rex_i18n::msg('form_delete') .'?" value="1">'. rex_i18n::msg('form_delete') .'</button>';
							}
						?>
					</div>
				</div>
			</footer>
		</div>
	</form>
	<br>
	<script>
		jQuery(document).ready(function($) {
			$('legend').each(function() {
				$(this).addClass('open');
				$(this).next('.panel-body-wrapper.slide').slideToggle();
			});
		});
	</script>
	<?php
		print d2u_addon_backend_helper::getCSS();
//		print d2u_addon_backend_helper::getJS();
}

if ($func == '') {
	$query = 'SELECT address_id, company, contact_name, city, priority, online_status '
		. 'FROM '. \rex::getTablePrefix() .'d2u_address_address '
		. 'ORDER BY priority';
    $list = rex_list::factory($query, 1000);

    $list->addTableAttribute('class', 'table-striped table-hover');

    $tdIcon = '<i class="rex-icon fa-address-card"></i>';
    $thIcon = '<a href="' . $list->getUrl(['func' => 'add']) . '" title="' . rex_i18n::msg('add') . '"><i class="rex-icon rex-icon-add-module"></i></a>';
    $list->addColumn($thIcon, $tdIcon, 0, ['<th class="rex-table-icon">###VALUE###</th>', '<td class="rex-table-icon">###VALUE###</td>']);
    $list->setColumnParams($thIcon, ['func' => 'edit', 'entry_id' => '###address_id###']);

    $list->setColumnLabel('address_id', rex_i18n::msg('id'));
    $list->setColumnLayout('address_id', ['<th class="rex-table-id">###VALUE###</th>', '<td class="rex-table-id">###VALUE###</td>']);

    $list->setColumnLabel('company', rex_i18n::msg('d2u_address_company'));
    $list->setColumnParams('company', ['func' => 'edit', 'entry_id' => '###address_id###']);

    $list->setColumnLabel('contact_name', rex_i18n::msg('d2u_address_contact_name'));

    $list->setColumnLabel('city', rex_i18n::msg('d2u_address_city'));

	$list->setColumnLabel('priority', rex_i18n::msg('header_priority'));

    $list->addColumn(rex_i18n::msg('module_functions'), '<i class="rex-icon rex-icon-edit"></i> ' . rex_i18n::msg('edit'));
    $list->setColumnLayout(rex_i18n::msg('module_functions'), ['<th class="rex-table-action" colspan="2">###VALUE###</th>', '<td class="rex-table-action">###VALUE###</td>']);
    $list->setColumnParams(rex_i18n::msg('module_functions'), ['func' => 'edit', 'entry_id' => '###address_id###']);

	$list->removeColumn('online_status');
	if(\rex::getUser()->isAdmin() || \rex::getUser()->hasPerm('d2u_address[edit_data]')) {
		$list->addColumn(rex_i18n::msg('status_online'), '<a class="rex-###online_status###" href="' . rex_url::currentBackendPage(['func' => 'changestatus']) . '&entry_id=###address_id###"><i class="rex-icon rex-icon-###online_status###"></i> ###online_status###</a>');
		$list->setColumnLayout(rex_i18n::msg('status_online'), ['', '<td class="rex-table-action">###VALUE###</td>']);

		$list->addColumn(rex_i18n::msg('d2u_helper_clone'), '<i class="rex-icon fa-copy"></i> ' . rex_i18n::msg('d2u_helper_clone'));
		$list->setColumnLayout(rex_i18n::msg('d2u_helper_clone'), ['', '<td class="rex-table-action">###VALUE###</td>']);
		$list->setColumnParams(rex_i18n::msg('d2u_helper_clone'), ['func' => 'clone', 'entry_id' => '###address_id###']);

		$list->addColumn(rex_i18n::msg('delete_module'), '<i class="rex-icon rex-icon-delete"></i> ' . rex_i18n::msg('delete'));
		$list->setColumnLayout(rex_i18n::msg('delete_module'), ['', '<td class="rex-table-action">###VALUE###</td>']);
		$list->setColumnParams(rex_i18n::msg('delete_module'), ['func' => 'delete', 'entry_id' => '###address_id###']);
		$list->addLinkAttribute(rex_i18n::msg('delete_module'), 'data-confirm', rex_i18n::msg('d2u_helper_confirm_delete'));
	}
	
    $list->setNoRowsMessage(rex_i18n::msg('d2u_address_no_address_found'));

    $fragment = new rex_fragment();
    $fragment->setVar('title', rex_i18n::msg('d2u_address_address_types'), false);
    $fragment->setVar('content', $list->get(), false);
    echo $fragment->parse('core/page/section.php');
}