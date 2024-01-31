<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

$table = $wpdb->prefix . 'wpg_bans';

if (isset($_POST['ban-country'])) {
    
    $country = sanitize_text_field($_POST['country']);
    $date    = date_i18n(get_option('date_format'));
    $time    = date_i18n(get_option('time_format'));
    $reason  = '';
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'country', $country));
    if ($validator > 0) {
        echo '<br />
			<div class="callout callout-info">
					<p><i class="fas fa-info-circle"></i> This <strong>Country</strong> is already added.</p>
			</div>';
    } else {
        add_ban("country", $country, $date, $time, $reason);
    }
}
?>
<div class="row">
                    
				<div class="col-md-9">
<?php
if (isset($_GET['editcountry-id'])) {
    $id = (int) $_GET["editcountry-id"];
    
    $row      = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d AND type = %s LIMIT 1", $id, 'country'));
    $countrys = $row->value;
    $result   = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'country', $countrys));
    
    if (empty($id) || $result == 0) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-bans&a=2">';
        exit();
    }
    
    if (isset($_POST['edit-ban'])) {
        $country = sanitize_text_field($_POST['country']);
        $reason  = '';
        
        update_ban($id, $country, $reason);
        
    }
?>         
<form class="form-horizontal" action="" method="post">
                    <div class="card col-md-12 card-dark">
						<div class="card-header" >
							<h3 class="card-title"><?php
    echo esc_html__("Edit - Country Ban", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
										<div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("Country:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12" width="100%">
<select class="form-control select2" width="100%" name="country" required> 
<option value="<?php
    echo esc_html($row->value);
?>" selected><?php
    echo esc_html($row->value);
?></option>
<option value="Afganistan"><?php
    echo esc_html__("Afghanistan", "ezy_sc-text");
?></option>
<option value="Albania"><?php
    echo esc_html__("Albania", "ezy_sc-text");
?></option>
<option value="Algeria"><?php
    echo esc_html__("Algeria", "ezy_sc-text");
?></option>
<option value="American Samoa"><?php
    echo esc_html__("American Samoa", "ezy_sc-text");
?></option>
<option value="Andorra"><?php
    echo esc_html__("Andorra", "ezy_sc-text");
?></option>
<option value="Angola"><?php
    echo esc_html__("Angola", "ezy_sc-text");
?></option>
<option value="Anguilla"><?php
    echo esc_html__("Anguilla", "ezy_sc-text");
?></option>
<option value="Antigua &amp; Barbuda"><?php
    echo esc_html__("Antigua &amp; Barbuda", "ezy_sc-text");
?></option>
<option value="Argentina"><?php
    echo esc_html__("Argentina", "ezy_sc-text");
?></option>
<option value="Armenia"><?php
    echo esc_html__("Armenia", "ezy_sc-text");
?></option>
<option value="Aruba"><?php
    echo esc_html__("Aruba", "ezy_sc-text");
?></option>
<option value="Australia"><?php
    echo esc_html__("Australia", "ezy_sc-text");
?></option>
<option value="Austria"><?php
    echo esc_html__("Austria", "ezy_sc-text");
?></option>
<option value="Azerbaijan"><?php
    echo esc_html__("Azerbaijan", "ezy_sc-text");
?></option>
<option value="Bahamas"><?php
    echo esc_html__("Bahamas", "ezy_sc-text");
?></option>
<option value="Bahrain"><?php
    echo esc_html__("Bahrain", "ezy_sc-text");
?></option>
<option value="Bangladesh"><?php
    echo esc_html__("Bangladesh", "ezy_sc-text");
?></option>
<option value="Barbados"><?php
    echo esc_html__("Barbados", "ezy_sc-text");
?></option>
<option value="Belarus"><?php
    echo esc_html__("Belarus", "ezy_sc-text");
?></option>
<option value="Belgium"><?php
    echo esc_html__("Belgium", "ezy_sc-text");
?></option>
<option value="Belize"><?php
    echo esc_html__("Belize", "ezy_sc-text");
?></option>
<option value="Benin"><?php
    echo esc_html__("Benin", "ezy_sc-text");
?></option>
<option value="Bermuda"><?php
    echo esc_html__("Bermuda", "ezy_sc-text");
?></option>
<option value="Bhutan"><?php
    echo esc_html__("Bhutan", "ezy_sc-text");
?></option>
<option value="Bolivia"><?php
    echo esc_html__("Bolivia", "ezy_sc-text");
?></option>
<option value="Bonaire"><?php
    echo esc_html__("Bonaire", "ezy_sc-text");
?></option>
<option value="Bosnia &amp; Herzegovina"><?php
    echo esc_html__("Bosnia &amp; Herzegovina", "ezy_sc-text");
?></option>
<option value="Botswana"><?php
    echo esc_html__("Botswana", "ezy_sc-text");
?></option>
<option value="Brazil"><?php
    echo esc_html__("Brazil", "ezy_sc-text");
?></option>
<option value="British Indian Ocean Ter"><?php
    echo esc_html__("British Indian Ocean Ter", "ezy_sc-text");
?></option>
<option value="Brunei"><?php
    echo esc_html__("Brunei", "ezy_sc-text");
?></option>
<option value="Bulgaria"><?php
    echo esc_html__("Bulgaria", "ezy_sc-text");
?></option>
<option value="Burkina Faso"><?php
    echo esc_html__("Burkina Faso", "ezy_sc-text");
?></option>
<option value="Burundi"><?php
    echo esc_html__("Burundi", "ezy_sc-text");
?></option>
<option value="Cambodia"><?php
    echo esc_html__("Cambodia", "ezy_sc-text");
?></option>
<option value="Cameroon"><?php
    echo esc_html__("Cameroon", "ezy_sc-text");
?></option>
<option value="Canada"><?php
    echo esc_html__("Canada", "ezy_sc-text");
?></option>
<option value="Canary Islands"><?php
    echo esc_html__("Canary Islands", "ezy_sc-text");
?></option>
<option value="Cape Verde"><?php
    echo esc_html__("Cape Verde", "ezy_sc-text");
?></option>
<option value="Cayman Islands"><?php
    echo esc_html__("Cayman Islands", "ezy_sc-text");
?></option>
<option value="Central African Republic"><?php
    echo esc_html__("Central African Republic", "ezy_sc-text");
?></option>
<option value="Chad"><?php
    echo esc_html__("Chad", "ezy_sc-text");
?></option>
<option value="Channel Islands"><?php
    echo esc_html__("Channel Islands", "ezy_sc-text");
?></option>
<option value="Chile"><?php
    echo esc_html__("Chile", "ezy_sc-text");
?></option>
<option value="China"><?php
    echo esc_html__("China", "ezy_sc-text");
?></option>
<option value="Christmas Island"><?php
    echo esc_html__("Christmas Island", "ezy_sc-text");
?></option>
<option value="Cocos Island"><?php
    echo esc_html__("Cocos Island", "ezy_sc-text");
?></option>
<option value="Colombia"><?php
    echo esc_html__("Colombia", "ezy_sc-text");
?></option>
<option value="Comoros"><?php
    echo esc_html__("Comoros", "ezy_sc-text");
?></option>
<option value="Congo"><?php
    echo esc_html__("Congo", "ezy_sc-text");
?></option>
<option value="Cook Islands"><?php
    echo esc_html__("Cook Islands", "ezy_sc-text");
?></option>
<option value="Costa Rica"><?php
    echo esc_html__("Costa Rica", "ezy_sc-text");
?></option>
<option value="Cote DIvoire"><?php
    echo esc_html__("Cote D'Ivoire", "ezy_sc-text");
?></option>
<option value="Croatia"><?php
    echo esc_html__("Croatia", "ezy_sc-text");
?></option>
<option value="Cuba"><?php
    echo esc_html__("Cuba", "ezy_sc-text");
?></option>
<option value="Curaco"><?php
    echo esc_html__("Curacao", "ezy_sc-text");
?></option>
<option value="Cyprus"><?php
    echo esc_html__("Cyprus", "ezy_sc-text");
?></option>
<option value="Czech Republic"><?php
    echo esc_html__("Czech Republic", "ezy_sc-text");
?></option>
<option value="Czechia"><?php
    echo esc_html__("Czechia", "ezy_sc-text");
?></option>
<option value="Denmark"><?php
    echo esc_html__("Denmark", "ezy_sc-text");
?></option>
<option value="Djibouti"><?php
    echo esc_html__("Djibouti", "ezy_sc-text");
?></option>
<option value="Dominica"><?php
    echo esc_html__("Dominica", "ezy_sc-text");
?></option>
<option value="Dominican Republic"><?php
    echo esc_html__("Dominican Republic", "ezy_sc-text");
?></option>
<option value="East Timor"><?php
    echo esc_html__("East Timor", "ezy_sc-text");
?></option>
<option value="Ecuador"><?php
    echo esc_html__("Ecuador", "ezy_sc-text");
?></option>
<option value="Egypt"><?php
    echo esc_html__("Egypt", "ezy_sc-text");
?></option>
<option value="El Salvador"><?php
    echo esc_html__("El Salvador", "ezy_sc-text");
?></option>
<option value="Equatorial Guinea"><?php
    echo esc_html__("Equatorial Guinea", "ezy_sc-text");
?></option>
<option value="Eritrea"><?php
    echo esc_html__("Eritrea", "ezy_sc-text");
?></option>
<option value="Estonia"><?php
    echo esc_html__("Estonia", "ezy_sc-text");
?></option>
<option value="Ethiopia"><?php
    echo esc_html__("Ethiopia", "ezy_sc-text");
?></option>
<option value="Falkland Islands"><?php
    echo esc_html__("Falkland Islands", "ezy_sc-text");
?></option>
<option value="Faroe Islands"><?php
    echo esc_html__("Faroe Islands", "ezy_sc-text");
?></option>
<option value="Fiji"><?php
    echo esc_html__("Fiji", "ezy_sc-text");
?></option>
<option value="Finland"><?php
    echo esc_html__("Finland", "ezy_sc-text");
?></option>
<option value="France"><?php
    echo esc_html__("France", "ezy_sc-text");
?></option>
<option value="French Guiana"><?php
    echo esc_html__("French Guiana", "ezy_sc-text");
?></option>
<option value="French Polynesia"><?php
    echo esc_html__("French Polynesia", "ezy_sc-text");
?></option>
<option value="French Southern Ter"><?php
    echo esc_html__("French Southern Ter", "ezy_sc-text");
?></option>
<option value="Gabon"><?php
    echo esc_html__("Gabon", "ezy_sc-text");
?></option>
<option value="Gambia"><?php
    echo esc_html__("Gambia", "ezy_sc-text");
?></option>
<option value="Georgia"><?php
    echo esc_html__("Georgia", "ezy_sc-text");
?></option>
<option value="Germany"><?php
    echo esc_html__("Germany", "ezy_sc-text");
?></option>
<option value="Ghana"><?php
    echo esc_html__("Ghana", "ezy_sc-text");
?></option>
<option value="Gibraltar"><?php
    echo esc_html__("Gibraltar", "ezy_sc-text");
?></option>
<option value="Great Britain"><?php
    echo esc_html__("Great Britain", "ezy_sc-text");
?></option>
<option value="Greece"><?php
    echo esc_html__("Greece", "ezy_sc-text");
?></option>
<option value="Greenland"><?php
    echo esc_html__("Greenland", "ezy_sc-text");
?></option>
<option value="Grenada"><?php
    echo esc_html__("Grenada", "ezy_sc-text");
?></option>
<option value="Guadeloupe"><?php
    echo esc_html__("Guadeloupe", "ezy_sc-text");
?></option>
<option value="Guam"><?php
    echo esc_html__("Guam", "ezy_sc-text");
?></option>
<option value="Guatemala"><?php
    echo esc_html__("Guatemala", "ezy_sc-text");
?></option>
<option value="Guinea"><?php
    echo esc_html__("Guinea", "ezy_sc-text");
?></option>
<option value="Guyana"><?php
    echo esc_html__("Guyana", "ezy_sc-text");
?></option>
<option value="Haiti"><?php
    echo esc_html__("Haiti", "ezy_sc-text");
?></option>
<option value="Hawaii"><?php
    echo esc_html__("Hawaii", "ezy_sc-text");
?></option>
<option value="Honduras"><?php
    echo esc_html__("Honduras", "ezy_sc-text");
?></option>
<option value="Hong Kong"><?php
    echo esc_html__("Hong Kong", "ezy_sc-text");
?></option>
<option value="Hungary"><?php
    echo esc_html__("Hungary", "ezy_sc-text");
?></option>
<option value="Iceland"><?php
    echo esc_html__("Iceland", "ezy_sc-text");
?></option>
<option value="India"><?php
    echo esc_html__("India", "ezy_sc-text");
?></option>
<option value="Indonesia"><?php
    echo esc_html__("Indonesia", "ezy_sc-text");
?></option>
<option value="Iran"><?php
    echo esc_html__("Iran", "ezy_sc-text");
?></option>
<option value="Iraq"><?php
    echo esc_html__("Iraq", "ezy_sc-text");
?></option>
<option value="Ireland"><?php
    echo esc_html__("Ireland", "ezy_sc-text");
?></option>
<option value="Isle of Man"><?php
    echo esc_html__("Isle of Man", "ezy_sc-text");
?></option>
<option value="Israel"><?php
    echo esc_html__("Israel", "ezy_sc-text");
?></option>
<option value="Italy"><?php
    echo esc_html__("Italy", "ezy_sc-text");
?></option>
<option value="Jamaica"><?php
    echo esc_html__("Jamaica", "ezy_sc-text");
?></option>
<option value="Japan"><?php
    echo esc_html__("Japan", "ezy_sc-text");
?></option>
<option value="Jordan"><?php
    echo esc_html__("Jordan", "ezy_sc-text");
?></option>
<option value="Kazakhstan"><?php
    echo esc_html__("Kazakhstan", "ezy_sc-text");
?></option>
<option value="Kenya"><?php
    echo esc_html__("Kenya", "ezy_sc-text");
?></option>
<option value="Kiribati"><?php
    echo esc_html__("Kiribati", "ezy_sc-text");
?></option>
<option value="Korea North"><?php
    echo esc_html__("Korea North", "ezy_sc-text");
?></option>
<option value="Korea Sout"><?php
    echo esc_html__("Korea South", "ezy_sc-text");
?></option>
<option value="Kuwait"><?php
    echo esc_html__("Kuwait", "ezy_sc-text");
?></option>
<option value="Kyrgyzstan"><?php
    echo esc_html__("Kyrgyzstan", "ezy_sc-text");
?></option>
<option value="Laos"><?php
    echo esc_html__("Laos", "ezy_sc-text");
?></option>
<option value="Latvia"><?php
    echo esc_html__("Latvia", "ezy_sc-text");
?></option>
<option value="Lebanon"><?php
    echo esc_html__("Lebanon", "ezy_sc-text");
?></option>
<option value="Lesotho"><?php
    echo esc_html__("Lesotho", "ezy_sc-text");
?></option>
<option value="Liberia"><?php
    echo esc_html__("Liberia", "ezy_sc-text");
?></option>
<option value="Libya"><?php
    echo esc_html__("Libya", "ezy_sc-text");
?></option>
<option value="Liechtenstein"><?php
    echo esc_html__("Liechtenstein", "ezy_sc-text");
?></option>
<option value="Lithuania"><?php
    echo esc_html__("Lithuania", "ezy_sc-text");
?></option>
<option value="Luxembourg"><?php
    echo esc_html__("Luxembourg", "ezy_sc-text");
?></option>
<option value="Macau"><?php
    echo esc_html__("Macau", "ezy_sc-text");
?></option>
<option value="Macedonia"><?php
    echo esc_html__("Macedonia", "ezy_sc-text");
?></option>
<option value="Madagascar"><?php
    echo esc_html__("Madagascar", "ezy_sc-text");
?></option>
<option value="Malaysia"><?php
    echo esc_html__("Malaysia", "ezy_sc-text");
?></option>
<option value="Malawi"><?php
    echo esc_html__("Malawi", "ezy_sc-text");
?></option>
<option value="Maldives"><?php
    echo esc_html__("Maldives", "ezy_sc-text");
?></option>
<option value="Mali"><?php
    echo esc_html__("Mali", "ezy_sc-text");
?></option>
<option value="Malta"><?php
    echo esc_html__("Malta", "ezy_sc-text");
?></option>
<option value="Marshall Islands"><?php
    echo esc_html__("Marshall Islands", "ezy_sc-text");
?></option>
<option value="Martinique"><?php
    echo esc_html__("Martinique", "ezy_sc-text");
?></option>
<option value="Mauritania"><?php
    echo esc_html__("Mauritania", "ezy_sc-text");
?></option>
<option value="Mauritius"><?php
    echo esc_html__("Mauritius", "ezy_sc-text");
?></option>
<option value="Mayotte"><?php
    echo esc_html__("Mayotte", "ezy_sc-text");
?></option>
<option value="Mexico"><?php
    echo esc_html__("Mexico", "ezy_sc-text");
?></option>
<option value="Midway Islands"><?php
    echo esc_html__("Midway Islands", "ezy_sc-text");
?></option>
<option value="Moldova"><?php
    echo esc_html__("Moldova", "ezy_sc-text");
?></option>
<option value="Monaco"><?php
    echo esc_html__("Monaco", "ezy_sc-text");
?></option>
<option value="Mongolia"><?php
    echo esc_html__("Mongolia", "ezy_sc-text");
?></option>
<option value="Montserrat"><?php
    echo esc_html__("Montserrat", "ezy_sc-text");
?></option>
<option value="Morocco"><?php
    echo esc_html__("Morocco", "ezy_sc-text");
?></option>
<option value="Mozambique"><?php
    echo esc_html__("Mozambique", "ezy_sc-text");
?></option>
<option value="Myanmar"><?php
    echo esc_html__("Myanmar", "ezy_sc-text");
?></option>
<option value="Nambia"><?php
    echo esc_html__("Nambia", "ezy_sc-text");
?></option>
<option value="Nauru"><?php
    echo esc_html__("Nauru", "ezy_sc-text");
?></option>
<option value="Nepal"><?php
    echo esc_html__("Nepal", "ezy_sc-text");
?></option>
<option value="Netherland Antilles"><?php
    echo esc_html__("Netherland Antilles", "ezy_sc-text");
?></option>
<option value="Netherlands"><?php
    echo esc_html__("Netherlands (Holland, Europe)", "ezy_sc-text");
?></option>
<option value="Nevis"><?php
    echo esc_html__("Nevis", "ezy_sc-text");
?></option>
<option value="New Caledonia"><?php
    echo esc_html__("New Caledonia", "ezy_sc-text");
?></option>
<option value="New Zealand"><?php
    echo esc_html__("New Zealand", "ezy_sc-text");
?></option>
<option value="Nicaragua"><?php
    echo esc_html__("Nicaragua", "ezy_sc-text");
?></option>
<option value="Niger"><?php
    echo esc_html__("Niger", "ezy_sc-text");
?></option>
<option value="Nigeria"><?php
    echo esc_html__("Nigeria", "ezy_sc-text");
?></option>
<option value="Niue"><?php
    echo esc_html__("Niue", "ezy_sc-text");
?></option>
<option value="Norfolk Island"><?php
    echo esc_html__("Norfolk Island", "ezy_sc-text");
?></option>
<option value="Norway"><?php
    echo esc_html__("Norway", "ezy_sc-text");
?></option>
<option value="Oman"><?php
    echo esc_html__("Oman", "ezy_sc-text");
?></option>
<option value="Pakistan"><?php
    echo esc_html__("Pakistan", "ezy_sc-text");
?></option>
<option value="Palau Island"><?php
    echo esc_html__("Palau Island", "ezy_sc-text");
?></option>
<option value="Palestine"><?php
    echo esc_html__("Palestine", "ezy_sc-text");
?></option>
<option value="Panama"><?php
    echo esc_html__("Panama", "ezy_sc-text");
?></option>
<option value="Papua New Guinea"><?php
    echo esc_html__("Papua New Guinea", "ezy_sc-text");
?></option>
<option value="Paraguay"><?php
    echo esc_html__("Paraguay", "ezy_sc-text");
?></option>
<option value="Peru"><?php
    echo esc_html__("Peru", "ezy_sc-text");
?></option>
<option value="Philippines"><?php
    echo esc_html__("Philippines", "ezy_sc-text");
?></option>
<option value="Pitcairn Island"><?php
    echo esc_html__("Pitcairn Island", "ezy_sc-text");
?></option>
<option value="Poland"><?php
    echo esc_html__("Poland", "ezy_sc-text");
?></option>
<option value="Portugal"><?php
    echo esc_html__("Portugal", "ezy_sc-text");
?></option>
<option value="Puerto Rico"><?php
    echo esc_html__("Puerto Rico", "ezy_sc-text");
?></option>
<option value="Qatar"><?php
    echo esc_html__("Qatar", "ezy_sc-text");
?></option>
<option value="Republic of Montenegro"><?php
    echo esc_html__("Republic of Montenegro", "ezy_sc-text");
?></option>
<option value="Republic of Serbia"><?php
    echo esc_html__("Republic of Serbia", "ezy_sc-text");
?></option>
<option value="Reunion"><?php
    echo esc_html__("Reunion", "ezy_sc-text");
?></option>
<option value="Romania"><?php
    echo esc_html__("Romania", "ezy_sc-text");
?></option>
<option value="Russia"><?php
    echo esc_html__("Russia", "ezy_sc-text");
?></option>
<option value="Rwanda"><?php
    echo esc_html__("Rwanda", "ezy_sc-text");
?></option>
<option value="St Barthelemy"><?php
    echo esc_html__("St Barthelemy", "ezy_sc-text");
?></option>
<option value="St Eustatius"><?php
    echo esc_html__("St Eustatius", "ezy_sc-text");
?></option>
<option value="St Helena"><?php
    echo esc_html__("St Helena", "ezy_sc-text");
?></option>
<option value="St Kitts-Nevis"><?php
    echo esc_html__("St Kitts-Nevis", "ezy_sc-text");
?></option>
<option value="St Lucia"><?php
    echo esc_html__("St Lucia", "ezy_sc-text");
?></option>
<option value="St Maarten"><?php
    echo esc_html__("St Maarten", "ezy_sc-text");
?></option>
<option value="St Pierre &amp; Miquelon"><?php
    echo esc_html__("St Pierre &amp; Miquelon", "ezy_sc-text");
?></option>
<option value="St Vincent &amp; Grenadines"><?php
    echo esc_html__("St Vincent &amp; Grenadines", "ezy_sc-text");
?></option>
<option value="Saipan"><?php
    echo esc_html__("Saipan", "ezy_sc-text");
?></option>
<option value="Samoa"><?php
    echo esc_html__("Samoa", "ezy_sc-text");
?></option>
<option value="Samoa American"><?php
    echo esc_html__("Samoa American", "ezy_sc-text");
?></option>
<option value="San Marino"><?php
    echo esc_html__("San Marino", "ezy_sc-text");
?></option>
<option value="Sao Tome &amp; Principe"><?php
    echo esc_html__("Sao Tome &amp; Principe", "ezy_sc-text");
?></option>
<option value="Saudi Arabia"><?php
    echo esc_html__("Saudi Arabia", "ezy_sc-text");
?></option>
<option value="Senegal"><?php
    echo esc_html__("Senegal", "ezy_sc-text");
?></option>
<option value="Serbia"><?php
    echo esc_html__("Serbia", "ezy_sc-text");
?></option>
<option value="Seychelles"><?php
    echo esc_html__("Seychelles", "ezy_sc-text");
?></option>
<option value="Sierra Leone"><?php
    echo esc_html__("Sierra Leone", "ezy_sc-text");
?></option>
<option value="Singapore"><?php
    echo esc_html__("Singapore", "ezy_sc-text");
?></option>
<option value="Slovakia"><?php
    echo esc_html__("Slovakia", "ezy_sc-text");
?></option>
<option value="Slovenia"><?php
    echo esc_html__("Slovenia", "ezy_sc-text");
?></option>
<option value="Solomon Islands"><?php
    echo esc_html__("Solomon Islands", "ezy_sc-text");
?></option>
<option value="Somalia"><?php
    echo esc_html__("Somalia", "ezy_sc-text");
?></option>
<option value="South Africa"><?php
    echo esc_html__("South Africa", "ezy_sc-text");
?></option>
<option value="Spain"><?php
    echo esc_html__("Spain", "ezy_sc-text");
?></option>
<option value="Sri Lanka"><?php
    echo esc_html__("Sri Lanka", "ezy_sc-text");
?></option>
<option value="Sudan"><?php
    echo esc_html__("Sudan", "ezy_sc-text");
?></option>
<option value="Suriname"><?php
    echo esc_html__("Suriname", "ezy_sc-text");
?></option>
<option value="Swaziland"><?php
    echo esc_html__("Swaziland", "ezy_sc-text");
?></option>
<option value="Sweden"><?php
    echo esc_html__("Sweden", "ezy_sc-text");
?></option>
<option value="Switzerland"><?php
    echo esc_html__("Switzerland", "ezy_sc-text");
?></option>
<option value="Syria"><?php
    echo esc_html__("Syria", "ezy_sc-text");
?></option>
<option value="Tahiti"><?php
    echo esc_html__("Tahiti", "ezy_sc-text");
?></option>
<option value="Taiwan"><?php
    echo esc_html__("Taiwan", "ezy_sc-text");
?></option>
<option value="Tajikistan"><?php
    echo esc_html__("Tajikistan", "ezy_sc-text");
?></option>
<option value="Tanzania"><?php
    echo esc_html__("Tanzania", "ezy_sc-text");
?></option>
<option value="Thailand"><?php
    echo esc_html__("Thailand", "ezy_sc-text");
?></option>
<option value="Togo"><?php
    echo esc_html__("Togo", "ezy_sc-text");
?></option>
<option value="Tokelau"><?php
    echo esc_html__("Tokelau", "ezy_sc-text");
?></option>
<option value="Tonga"><?php
    echo esc_html__("Tonga", "ezy_sc-text");
?></option>
<option value="Trinidad &amp; Tobago"><?php
    echo esc_html__("Trinidad &amp; Tobago", "ezy_sc-text");
?></option>
<option value="Tunisia"><?php
    echo esc_html__("Tunisia", "ezy_sc-text");
?></option>
<option value="Turkey"><?php
    echo esc_html__("Turkey", "ezy_sc-text");
?></option>
<option value="Turkmenistan"><?php
    echo esc_html__("Turkmenistan", "ezy_sc-text");
?></option>
<option value="Turks &amp; Caicos Is"><?php
    echo esc_html__("Turks &amp; Caicos Is", "ezy_sc-text");
?></option>
<option value="Tuvalu"><?php
    echo esc_html__("Tuvalu", "ezy_sc-text");
?></option>
<option value="Uganda"><?php
    echo esc_html__("Uganda", "ezy_sc-text");
?></option>
<option value="Ukraine"><?php
    echo esc_html__("Ukraine", "ezy_sc-text");
?></option>
<option value="United Arab Erimates"><?php
    echo esc_html__("United Arab Emirates", "ezy_sc-text");
?></option>
<option value="United Kingdom"><?php
    echo esc_html__("United Kingdom", "ezy_sc-text");
?></option>
<option value="United States"><?php
    echo esc_html__("United States", "ezy_sc-text");
?></option>
<option value="United States of America"><?php
    echo esc_html__("United States of America", "ezy_sc-text");
?></option>
<option value="Uraguay"><?php
    echo esc_html__("Uruguay", "ezy_sc-text");
?></option>
<option value="Uzbekistan"><?php
    echo esc_html__("Uzbekistan", "ezy_sc-text");
?></option>
<option value="Vanuatu"><?php
    echo esc_html__("Vanuatu", "ezy_sc-text");
?></option>
<option value="Vatican City State"><?php
    echo esc_html__("Vatican City State", "ezy_sc-text");
?></option>
<option value="Venezuela"><?php
    echo esc_html__("Venezuela", "ezy_sc-text");
?></option>
<option value="Vietnam"><?php
    echo esc_html__("Vietnam", "ezy_sc-text");
?></option>
<option value="Virgin Islands (Brit)"><?php
    echo esc_html__("Virgin Islands (Brit)", "ezy_sc-text");
?></option>
<option value="Virgin Islands (USA)"><?php
    echo esc_html__("Virgin Islands (USA)", "ezy_sc-text");
?></option>
<option value="Wake Island"><?php
    echo esc_html__("Wake Island", "ezy_sc-text");
?></option>
<option value="Wallis &amp; Futana Is"><?php
    echo esc_html__("Wallis &amp; Futana Is", "ezy_sc-text");
?></option>
<option value="Yemen"><?php
    echo esc_html__("Yemen", "ezy_sc-text");
?></option>
<option value="Zaire"><?php
    echo esc_html__("Zaire", "ezy_sc-text");
?></option>
<option value="Zambia"><?php
    echo esc_html__("Zambia", "ezy_sc-text");
?></option>
<option value="Zimbabwe"><?php
    echo esc_html__("Zimbabwe", "ezy_sc-text");
?></option>
<option value="Unknown"><?php
    echo esc_html__("Unknown", "ezy_sc-text");
?></option>
</select>
											</div>
										</div>
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-success" name="edit-ban" type="submit"><?php
    echo esc_html__("Save", "ezy_sc-text");
?></button>
							<button type="reset" class="btn btn-flat btn-default"><?php
    echo esc_html__("Reset", "ezy_sc-text");
?></button>
				        </div>
                     </div>
				</form>
<?php
}
?>
				    <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Country Bans", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
                            <div class="callout callout-info" role="callout">
							<?php
echo esc_html__("Only one country ban mode can be selected. The countries table is common for the both ban modes.
Redirecting option is not used when Whitelist country ban mode is selected.", "ezy_sc-text");
?>
                            </div>
						
Ban Mode: 
                        <a href="admin.php?page=ezy_sc-bans&a=2&blacklist" class="btn btn-flat btn-md btn-rounded <?php
if (get_option('wpg_countryban_blacklist') == 1) {
    echo 'btn-danger';
} else {
    echo 'btn-default';
}
?>"><?php
echo esc_html__("Blacklist", "ezy_sc-text");
?></a>
                        <a href="admin.php?page=ezy_sc-bans&a=2&whitelist" class="btn btn-flat btn-md btn-rounded <?php
if (get_option('wpg_countryban_blacklist') == 0) {
    echo 'btn-success';
} else {
    echo 'btn-default';
}
?>"><?php
echo esc_html__("Whitelist", "ezy_sc-text");
?></a> 
                        <hr />
						
<table id="dt-basic" class="table table-strcountryed table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
						                  <th><i class="fas fa-user"></i> <?php
echo esc_html__("Country", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table` WHERE type='country'");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . esc_html($row->value) . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-bans&a=2&editcountry-id=' . esc_html($row->id) . '" class="btn btn-flat btn-primary"><i class="fas fa-edit"></i> ' . esc_html__("Edit", "ezy_sc-text") . '</a>
                                            <a href="admin.php?page=ezy_sc-bans&a=2&delete-id=' . esc_html($row->id) . '" class="btn btn-flat btn-success"><i class="fas fa-trash"></i> ' . esc_html__("Unban", "ezy_sc-text") . '</a>
											</td>
										</tr>
';
}
?>
									</tbody>
								</table>
                        </div>
                     </div>
                </div>
				
				<div class="col-md-3">
				     <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title">Ban Country</h3>
						</div>
				        <div class="card-body">
						<form class="form-horizontal" action="" method="post">
										<div class="form-group">
											<label class="control-label"><?php
echo esc_html__("Country:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
<select class="form-control select2" width="100%" name="country" required>
<option value="Afganistan"><?php
echo esc_html__("Afghanistan", "ezy_sc-text");
?></option>
<option value="Albania"><?php
echo esc_html__("Albania", "ezy_sc-text");
?></option>
<option value="Algeria"><?php
echo esc_html__("Algeria", "ezy_sc-text");
?></option>
<option value="American Samoa"><?php
echo esc_html__("American Samoa", "ezy_sc-text");
?></option>
<option value="Andorra"><?php
echo esc_html__("Andorra", "ezy_sc-text");
?></option>
<option value="Angola"><?php
echo esc_html__("Angola", "ezy_sc-text");
?></option>
<option value="Anguilla"><?php
echo esc_html__("Anguilla", "ezy_sc-text");
?></option>
<option value="Antigua &amp; Barbuda"><?php
echo esc_html__("Antigua &amp; Barbuda", "ezy_sc-text");
?></option>
<option value="Argentina"><?php
echo esc_html__("Argentina", "ezy_sc-text");
?></option>
<option value="Armenia"><?php
echo esc_html__("Armenia", "ezy_sc-text");
?></option>
<option value="Aruba"><?php
echo esc_html__("Aruba", "ezy_sc-text");
?></option>
<option value="Australia"><?php
echo esc_html__("Australia", "ezy_sc-text");
?></option>
<option value="Austria"><?php
echo esc_html__("Austria", "ezy_sc-text");
?></option>
<option value="Azerbaijan"><?php
echo esc_html__("Azerbaijan", "ezy_sc-text");
?></option>
<option value="Bahamas"><?php
echo esc_html__("Bahamas", "ezy_sc-text");
?></option>
<option value="Bahrain"><?php
echo esc_html__("Bahrain", "ezy_sc-text");
?></option>
<option value="Bangladesh"><?php
echo esc_html__("Bangladesh", "ezy_sc-text");
?></option>
<option value="Barbados"><?php
echo esc_html__("Barbados", "ezy_sc-text");
?></option>
<option value="Belarus"><?php
echo esc_html__("Belarus", "ezy_sc-text");
?></option>
<option value="Belgium"><?php
echo esc_html__("Belgium", "ezy_sc-text");
?></option>
<option value="Belize"><?php
echo esc_html__("Belize", "ezy_sc-text");
?></option>
<option value="Benin"><?php
echo esc_html__("Benin", "ezy_sc-text");
?></option>
<option value="Bermuda"><?php
echo esc_html__("Bermuda", "ezy_sc-text");
?></option>
<option value="Bhutan"><?php
echo esc_html__("Bhutan", "ezy_sc-text");
?></option>
<option value="Bolivia"><?php
echo esc_html__("Bolivia", "ezy_sc-text");
?></option>
<option value="Bonaire"><?php
echo esc_html__("Bonaire", "ezy_sc-text");
?></option>
<option value="Bosnia &amp; Herzegovina"><?php
echo esc_html__("Bosnia &amp; Herzegovina", "ezy_sc-text");
?></option>
<option value="Botswana"><?php
echo esc_html__("Botswana", "ezy_sc-text");
?></option>
<option value="Brazil"><?php
echo esc_html__("Brazil", "ezy_sc-text");
?></option>
<option value="British Indian Ocean Ter"><?php
echo esc_html__("British Indian Ocean Ter", "ezy_sc-text");
?></option>
<option value="Brunei"><?php
echo esc_html__("Brunei", "ezy_sc-text");
?></option>
<option value="Bulgaria"><?php
echo esc_html__("Bulgaria", "ezy_sc-text");
?></option>
<option value="Burkina Faso"><?php
echo esc_html__("Burkina Faso", "ezy_sc-text");
?></option>
<option value="Burundi"><?php
echo esc_html__("Burundi", "ezy_sc-text");
?></option>
<option value="Cambodia"><?php
echo esc_html__("Cambodia", "ezy_sc-text");
?></option>
<option value="Cameroon"><?php
echo esc_html__("Cameroon", "ezy_sc-text");
?></option>
<option value="Canada"><?php
echo esc_html__("Canada", "ezy_sc-text");
?></option>
<option value="Canary Islands"><?php
echo esc_html__("Canary Islands", "ezy_sc-text");
?></option>
<option value="Cape Verde"><?php
echo esc_html__("Cape Verde", "ezy_sc-text");
?></option>
<option value="Cayman Islands"><?php
echo esc_html__("Cayman Islands", "ezy_sc-text");
?></option>
<option value="Central African Republic"><?php
echo esc_html__("Central African Republic", "ezy_sc-text");
?></option>
<option value="Chad"><?php
echo esc_html__("Chad", "ezy_sc-text");
?></option>
<option value="Channel Islands"><?php
echo esc_html__("Channel Islands", "ezy_sc-text");
?></option>
<option value="Chile"><?php
echo esc_html__("Chile", "ezy_sc-text");
?></option>
<option value="China"><?php
echo esc_html__("China", "ezy_sc-text");
?></option>
<option value="Christmas Island"><?php
echo esc_html__("Christmas Island", "ezy_sc-text");
?></option>
<option value="Cocos Island"><?php
echo esc_html__("Cocos Island", "ezy_sc-text");
?></option>
<option value="Colombia"><?php
echo esc_html__("Colombia", "ezy_sc-text");
?></option>
<option value="Comoros"><?php
echo esc_html__("Comoros", "ezy_sc-text");
?></option>
<option value="Congo"><?php
echo esc_html__("Congo", "ezy_sc-text");
?></option>
<option value="Cook Islands"><?php
echo esc_html__("Cook Islands", "ezy_sc-text");
?></option>
<option value="Costa Rica"><?php
echo esc_html__("Costa Rica", "ezy_sc-text");
?></option>
<option value="Cote DIvoire"><?php
echo esc_html__("Cote D'Ivoire", "ezy_sc-text");
?></option>
<option value="Croatia"><?php
echo esc_html__("Croatia", "ezy_sc-text");
?></option>
<option value="Cuba"><?php
echo esc_html__("Cuba", "ezy_sc-text");
?></option>
<option value="Curaco"><?php
echo esc_html__("Curacao", "ezy_sc-text");
?></option>
<option value="Cyprus"><?php
echo esc_html__("Cyprus", "ezy_sc-text");
?></option>
<option value="Czech Republic"><?php
echo esc_html__("Czech Republic", "ezy_sc-text");
?></option>
<option value="Czechia"><?php
echo esc_html__("Czechia", "ezy_sc-text");
?></option>
<option value="Denmark"><?php
echo esc_html__("Denmark", "ezy_sc-text");
?></option>
<option value="Djibouti"><?php
echo esc_html__("Djibouti", "ezy_sc-text");
?></option>
<option value="Dominica"><?php
echo esc_html__("Dominica", "ezy_sc-text");
?></option>
<option value="Dominican Republic"><?php
echo esc_html__("Dominican Republic", "ezy_sc-text");
?></option>
<option value="East Timor"><?php
echo esc_html__("East Timor", "ezy_sc-text");
?></option>
<option value="Ecuador"><?php
echo esc_html__("Ecuador", "ezy_sc-text");
?></option>
<option value="Egypt"><?php
echo esc_html__("Egypt", "ezy_sc-text");
?></option>
<option value="El Salvador"><?php
echo esc_html__("El Salvador", "ezy_sc-text");
?></option>
<option value="Equatorial Guinea"><?php
echo esc_html__("Equatorial Guinea", "ezy_sc-text");
?></option>
<option value="Eritrea"><?php
echo esc_html__("Eritrea", "ezy_sc-text");
?></option>
<option value="Estonia"><?php
echo esc_html__("Estonia", "ezy_sc-text");
?></option>
<option value="Ethiopia"><?php
echo esc_html__("Ethiopia", "ezy_sc-text");
?></option>
<option value="Falkland Islands"><?php
echo esc_html__("Falkland Islands", "ezy_sc-text");
?></option>
<option value="Faroe Islands"><?php
echo esc_html__("Faroe Islands", "ezy_sc-text");
?></option>
<option value="Fiji"><?php
echo esc_html__("Fiji", "ezy_sc-text");
?></option>
<option value="Finland"><?php
echo esc_html__("Finland", "ezy_sc-text");
?></option>
<option value="France"><?php
echo esc_html__("France", "ezy_sc-text");
?></option>
<option value="French Guiana"><?php
echo esc_html__("French Guiana", "ezy_sc-text");
?></option>
<option value="French Polynesia"><?php
echo esc_html__("French Polynesia", "ezy_sc-text");
?></option>
<option value="French Southern Ter"><?php
echo esc_html__("French Southern Ter", "ezy_sc-text");
?></option>
<option value="Gabon"><?php
echo esc_html__("Gabon", "ezy_sc-text");
?></option>
<option value="Gambia"><?php
echo esc_html__("Gambia", "ezy_sc-text");
?></option>
<option value="Georgia"><?php
echo esc_html__("Georgia", "ezy_sc-text");
?></option>
<option value="Germany"><?php
echo esc_html__("Germany", "ezy_sc-text");
?></option>
<option value="Ghana"><?php
echo esc_html__("Ghana", "ezy_sc-text");
?></option>
<option value="Gibraltar"><?php
echo esc_html__("Gibraltar", "ezy_sc-text");
?></option>
<option value="Great Britain"><?php
echo esc_html__("Great Britain", "ezy_sc-text");
?></option>
<option value="Greece"><?php
echo esc_html__("Greece", "ezy_sc-text");
?></option>
<option value="Greenland"><?php
echo esc_html__("Greenland", "ezy_sc-text");
?></option>
<option value="Grenada"><?php
echo esc_html__("Grenada", "ezy_sc-text");
?></option>
<option value="Guadeloupe"><?php
echo esc_html__("Guadeloupe", "ezy_sc-text");
?></option>
<option value="Guam"><?php
echo esc_html__("Guam", "ezy_sc-text");
?></option>
<option value="Guatemala"><?php
echo esc_html__("Guatemala", "ezy_sc-text");
?></option>
<option value="Guinea"><?php
echo esc_html__("Guinea", "ezy_sc-text");
?></option>
<option value="Guyana"><?php
echo esc_html__("Guyana", "ezy_sc-text");
?></option>
<option value="Haiti"><?php
echo esc_html__("Haiti", "ezy_sc-text");
?></option>
<option value="Hawaii"><?php
echo esc_html__("Hawaii", "ezy_sc-text");
?></option>
<option value="Honduras"><?php
echo esc_html__("Honduras", "ezy_sc-text");
?></option>
<option value="Hong Kong"><?php
echo esc_html__("Hong Kong", "ezy_sc-text");
?></option>
<option value="Hungary"><?php
echo esc_html__("Hungary", "ezy_sc-text");
?></option>
<option value="Iceland"><?php
echo esc_html__("Iceland", "ezy_sc-text");
?></option>
<option value="India"><?php
echo esc_html__("India", "ezy_sc-text");
?></option>
<option value="Indonesia"><?php
echo esc_html__("Indonesia", "ezy_sc-text");
?></option>
<option value="Iran"><?php
echo esc_html__("Iran", "ezy_sc-text");
?></option>
<option value="Iraq"><?php
echo esc_html__("Iraq", "ezy_sc-text");
?></option>
<option value="Ireland"><?php
echo esc_html__("Ireland", "ezy_sc-text");
?></option>
<option value="Isle of Man"><?php
echo esc_html__("Isle of Man", "ezy_sc-text");
?></option>
<option value="Israel"><?php
echo esc_html__("Israel", "ezy_sc-text");
?></option>
<option value="Italy"><?php
echo esc_html__("Italy", "ezy_sc-text");
?></option>
<option value="Jamaica"><?php
echo esc_html__("Jamaica", "ezy_sc-text");
?></option>
<option value="Japan"><?php
echo esc_html__("Japan", "ezy_sc-text");
?></option>
<option value="Jordan"><?php
echo esc_html__("Jordan", "ezy_sc-text");
?></option>
<option value="Kazakhstan"><?php
echo esc_html__("Kazakhstan", "ezy_sc-text");
?></option>
<option value="Kenya"><?php
echo esc_html__("Kenya", "ezy_sc-text");
?></option>
<option value="Kiribati"><?php
echo esc_html__("Kiribati", "ezy_sc-text");
?></option>
<option value="Korea North"><?php
echo esc_html__("Korea North", "ezy_sc-text");
?></option>
<option value="Korea Sout"><?php
echo esc_html__("Korea South", "ezy_sc-text");
?></option>
<option value="Kuwait"><?php
echo esc_html__("Kuwait", "ezy_sc-text");
?></option>
<option value="Kyrgyzstan"><?php
echo esc_html__("Kyrgyzstan", "ezy_sc-text");
?></option>
<option value="Laos"><?php
echo esc_html__("Laos", "ezy_sc-text");
?></option>
<option value="Latvia"><?php
echo esc_html__("Latvia", "ezy_sc-text");
?></option>
<option value="Lebanon"><?php
echo esc_html__("Lebanon", "ezy_sc-text");
?></option>
<option value="Lesotho"><?php
echo esc_html__("Lesotho", "ezy_sc-text");
?></option>
<option value="Liberia"><?php
echo esc_html__("Liberia", "ezy_sc-text");
?></option>
<option value="Libya"><?php
echo esc_html__("Libya", "ezy_sc-text");
?></option>
<option value="Liechtenstein"><?php
echo esc_html__("Liechtenstein", "ezy_sc-text");
?></option>
<option value="Lithuania"><?php
echo esc_html__("Lithuania", "ezy_sc-text");
?></option>
<option value="Luxembourg"><?php
echo esc_html__("Luxembourg", "ezy_sc-text");
?></option>
<option value="Macau"><?php
echo esc_html__("Macau", "ezy_sc-text");
?></option>
<option value="Macedonia"><?php
echo esc_html__("Macedonia", "ezy_sc-text");
?></option>
<option value="Madagascar"><?php
echo esc_html__("Madagascar", "ezy_sc-text");
?></option>
<option value="Malaysia"><?php
echo esc_html__("Malaysia", "ezy_sc-text");
?></option>
<option value="Malawi"><?php
echo esc_html__("Malawi", "ezy_sc-text");
?></option>
<option value="Maldives"><?php
echo esc_html__("Maldives", "ezy_sc-text");
?></option>
<option value="Mali"><?php
echo esc_html__("Mali", "ezy_sc-text");
?></option>
<option value="Malta"><?php
echo esc_html__("Malta", "ezy_sc-text");
?></option>
<option value="Marshall Islands"><?php
echo esc_html__("Marshall Islands", "ezy_sc-text");
?></option>
<option value="Martinique"><?php
echo esc_html__("Martinique", "ezy_sc-text");
?></option>
<option value="Mauritania"><?php
echo esc_html__("Mauritania", "ezy_sc-text");
?></option>
<option value="Mauritius"><?php
echo esc_html__("Mauritius", "ezy_sc-text");
?></option>
<option value="Mayotte"><?php
echo esc_html__("Mayotte", "ezy_sc-text");
?></option>
<option value="Mexico"><?php
echo esc_html__("Mexico", "ezy_sc-text");
?></option>
<option value="Midway Islands"><?php
echo esc_html__("Midway Islands", "ezy_sc-text");
?></option>
<option value="Moldova"><?php
echo esc_html__("Moldova", "ezy_sc-text");
?></option>
<option value="Monaco"><?php
echo esc_html__("Monaco", "ezy_sc-text");
?></option>
<option value="Mongolia"><?php
echo esc_html__("Mongolia", "ezy_sc-text");
?></option>
<option value="Montserrat"><?php
echo esc_html__("Montserrat", "ezy_sc-text");
?></option>
<option value="Morocco"><?php
echo esc_html__("Morocco", "ezy_sc-text");
?></option>
<option value="Mozambique"><?php
echo esc_html__("Mozambique", "ezy_sc-text");
?></option>
<option value="Myanmar"><?php
echo esc_html__("Myanmar", "ezy_sc-text");
?></option>
<option value="Nambia"><?php
echo esc_html__("Nambia", "ezy_sc-text");
?></option>
<option value="Nauru"><?php
echo esc_html__("Nauru", "ezy_sc-text");
?></option>
<option value="Nepal"><?php
echo esc_html__("Nepal", "ezy_sc-text");
?></option>
<option value="Netherland Antilles"><?php
echo esc_html__("Netherland Antilles", "ezy_sc-text");
?></option>
<option value="Netherlands"><?php
echo esc_html__("Netherlands (Holland, Europe)", "ezy_sc-text");
?></option>
<option value="Nevis"><?php
echo esc_html__("Nevis", "ezy_sc-text");
?></option>
<option value="New Caledonia"><?php
echo esc_html__("New Caledonia", "ezy_sc-text");
?></option>
<option value="New Zealand"><?php
echo esc_html__("New Zealand", "ezy_sc-text");
?></option>
<option value="Nicaragua"><?php
echo esc_html__("Nicaragua", "ezy_sc-text");
?></option>
<option value="Niger"><?php
echo esc_html__("Niger", "ezy_sc-text");
?></option>
<option value="Nigeria"><?php
echo esc_html__("Nigeria", "ezy_sc-text");
?></option>
<option value="Niue"><?php
echo esc_html__("Niue", "ezy_sc-text");
?></option>
<option value="Norfolk Island"><?php
echo esc_html__("Norfolk Island", "ezy_sc-text");
?></option>
<option value="Norway"><?php
echo esc_html__("Norway", "ezy_sc-text");
?></option>
<option value="Oman"><?php
echo esc_html__("Oman", "ezy_sc-text");
?></option>
<option value="Pakistan"><?php
echo esc_html__("Pakistan", "ezy_sc-text");
?></option>
<option value="Palau Island"><?php
echo esc_html__("Palau Island", "ezy_sc-text");
?></option>
<option value="Palestine"><?php
echo esc_html__("Palestine", "ezy_sc-text");
?></option>
<option value="Panama"><?php
echo esc_html__("Panama", "ezy_sc-text");
?></option>
<option value="Papua New Guinea"><?php
echo esc_html__("Papua New Guinea", "ezy_sc-text");
?></option>
<option value="Paraguay"><?php
echo esc_html__("Paraguay", "ezy_sc-text");
?></option>
<option value="Peru"><?php
echo esc_html__("Peru", "ezy_sc-text");
?></option>
<option value="Philippines"><?php
echo esc_html__("Philippines", "ezy_sc-text");
?></option>
<option value="Pitcairn Island"><?php
echo esc_html__("Pitcairn Island", "ezy_sc-text");
?></option>
<option value="Poland"><?php
echo esc_html__("Poland", "ezy_sc-text");
?></option>
<option value="Portugal"><?php
echo esc_html__("Portugal", "ezy_sc-text");
?></option>
<option value="Puerto Rico"><?php
echo esc_html__("Puerto Rico", "ezy_sc-text");
?></option>
<option value="Qatar"><?php
echo esc_html__("Qatar", "ezy_sc-text");
?></option>
<option value="Republic of Montenegro"><?php
echo esc_html__("Republic of Montenegro", "ezy_sc-text");
?></option>
<option value="Republic of Serbia"><?php
echo esc_html__("Republic of Serbia", "ezy_sc-text");
?></option>
<option value="Reunion"><?php
echo esc_html__("Reunion", "ezy_sc-text");
?></option>
<option value="Romania"><?php
echo esc_html__("Romania", "ezy_sc-text");
?></option>
<option value="Russia"><?php
echo esc_html__("Russia", "ezy_sc-text");
?></option>
<option value="Rwanda"><?php
echo esc_html__("Rwanda", "ezy_sc-text");
?></option>
<option value="St Barthelemy"><?php
echo esc_html__("St Barthelemy", "ezy_sc-text");
?></option>
<option value="St Eustatius"><?php
echo esc_html__("St Eustatius", "ezy_sc-text");
?></option>
<option value="St Helena"><?php
echo esc_html__("St Helena", "ezy_sc-text");
?></option>
<option value="St Kitts-Nevis"><?php
echo esc_html__("St Kitts-Nevis", "ezy_sc-text");
?></option>
<option value="St Lucia"><?php
echo esc_html__("St Lucia", "ezy_sc-text");
?></option>
<option value="St Maarten"><?php
echo esc_html__("St Maarten", "ezy_sc-text");
?></option>
<option value="St Pierre &amp; Miquelon"><?php
echo esc_html__("St Pierre &amp; Miquelon", "ezy_sc-text");
?></option>
<option value="St Vincent &amp; Grenadines"><?php
echo esc_html__("St Vincent &amp; Grenadines", "ezy_sc-text");
?></option>
<option value="Saipan"><?php
echo esc_html__("Saipan", "ezy_sc-text");
?></option>
<option value="Samoa"><?php
echo esc_html__("Samoa", "ezy_sc-text");
?></option>
<option value="Samoa American"><?php
echo esc_html__("Samoa American", "ezy_sc-text");
?></option>
<option value="San Marino"><?php
echo esc_html__("San Marino", "ezy_sc-text");
?></option>
<option value="Sao Tome &amp; Principe"><?php
echo esc_html__("Sao Tome &amp; Principe", "ezy_sc-text");
?></option>
<option value="Saudi Arabia"><?php
echo esc_html__("Saudi Arabia", "ezy_sc-text");
?></option>
<option value="Senegal"><?php
echo esc_html__("Senegal", "ezy_sc-text");
?></option>
<option value="Serbia"><?php
echo esc_html__("Serbia", "ezy_sc-text");
?></option>
<option value="Seychelles"><?php
echo esc_html__("Seychelles", "ezy_sc-text");
?></option>
<option value="Sierra Leone"><?php
echo esc_html__("Sierra Leone", "ezy_sc-text");
?></option>
<option value="Singapore"><?php
echo esc_html__("Singapore", "ezy_sc-text");
?></option>
<option value="Slovakia"><?php
echo esc_html__("Slovakia", "ezy_sc-text");
?></option>
<option value="Slovenia"><?php
echo esc_html__("Slovenia", "ezy_sc-text");
?></option>
<option value="Solomon Islands"><?php
echo esc_html__("Solomon Islands", "ezy_sc-text");
?></option>
<option value="Somalia"><?php
echo esc_html__("Somalia", "ezy_sc-text");
?></option>
<option value="South Africa"><?php
echo esc_html__("South Africa", "ezy_sc-text");
?></option>
<option value="Spain"><?php
echo esc_html__("Spain", "ezy_sc-text");
?></option>
<option value="Sri Lanka"><?php
echo esc_html__("Sri Lanka", "ezy_sc-text");
?></option>
<option value="Sudan"><?php
echo esc_html__("Sudan", "ezy_sc-text");
?></option>
<option value="Suriname"><?php
echo esc_html__("Suriname", "ezy_sc-text");
?></option>
<option value="Swaziland"><?php
echo esc_html__("Swaziland", "ezy_sc-text");
?></option>
<option value="Sweden"><?php
echo esc_html__("Sweden", "ezy_sc-text");
?></option>
<option value="Switzerland"><?php
echo esc_html__("Switzerland", "ezy_sc-text");
?></option>
<option value="Syria"><?php
echo esc_html__("Syria", "ezy_sc-text");
?></option>
<option value="Tahiti"><?php
echo esc_html__("Tahiti", "ezy_sc-text");
?></option>
<option value="Taiwan"><?php
echo esc_html__("Taiwan", "ezy_sc-text");
?></option>
<option value="Tajikistan"><?php
echo esc_html__("Tajikistan", "ezy_sc-text");
?></option>
<option value="Tanzania"><?php
echo esc_html__("Tanzania", "ezy_sc-text");
?></option>
<option value="Thailand"><?php
echo esc_html__("Thailand", "ezy_sc-text");
?></option>
<option value="Togo"><?php
echo esc_html__("Togo", "ezy_sc-text");
?></option>
<option value="Tokelau"><?php
echo esc_html__("Tokelau", "ezy_sc-text");
?></option>
<option value="Tonga"><?php
echo esc_html__("Tonga", "ezy_sc-text");
?></option>
<option value="Trinidad &amp; Tobago"><?php
echo esc_html__("Trinidad &amp; Tobago", "ezy_sc-text");
?></option>
<option value="Tunisia"><?php
echo esc_html__("Tunisia", "ezy_sc-text");
?></option>
<option value="Turkey"><?php
echo esc_html__("Turkey", "ezy_sc-text");
?></option>
<option value="Turkmenistan"><?php
echo esc_html__("Turkmenistan", "ezy_sc-text");
?></option>
<option value="Turks &amp; Caicos Is"><?php
echo esc_html__("Turks &amp; Caicos Is", "ezy_sc-text");
?></option>
<option value="Tuvalu"><?php
echo esc_html__("Tuvalu", "ezy_sc-text");
?></option>
<option value="Uganda"><?php
echo esc_html__("Uganda", "ezy_sc-text");
?></option>
<option value="Ukraine"><?php
echo esc_html__("Ukraine", "ezy_sc-text");
?></option>
<option value="United Arab Erimates"><?php
echo esc_html__("United Arab Emirates", "ezy_sc-text");
?></option>
<option value="United Kingdom"><?php
echo esc_html__("United Kingdom", "ezy_sc-text");
?></option>
<option value="United States"><?php
echo esc_html__("United States", "ezy_sc-text");
?></option>
<option value="United States of America"><?php
echo esc_html__("United States of America", "ezy_sc-text");
?></option>
<option value="Uraguay"><?php
echo esc_html__("Uruguay", "ezy_sc-text");
?></option>
<option value="Uzbekistan"><?php
echo esc_html__("Uzbekistan", "ezy_sc-text");
?></option>
<option value="Vanuatu"><?php
echo esc_html__("Vanuatu", "ezy_sc-text");
?></option>
<option value="Vatican City State"><?php
echo esc_html__("Vatican City State", "ezy_sc-text");
?></option>
<option value="Venezuela"><?php
echo esc_html__("Venezuela", "ezy_sc-text");
?></option>
<option value="Vietnam"><?php
echo esc_html__("Vietnam", "ezy_sc-text");
?></option>
<option value="Virgin Islands (Brit)"><?php
echo esc_html__("Virgin Islands (Brit)", "ezy_sc-text");
?></option>
<option value="Virgin Islands (USA)"><?php
echo esc_html__("Virgin Islands (USA)", "ezy_sc-text");
?></option>
<option value="Wake Island"><?php
echo esc_html__("Wake Island", "ezy_sc-text");
?></option>
<option value="Wallis &amp; Futana Is"><?php
echo esc_html__("Wallis &amp; Futana Is", "ezy_sc-text");
?></option>
<option value="Yemen"><?php
echo esc_html__("Yemen", "ezy_sc-text");
?></option>
<option value="Zaire"><?php
echo esc_html__("Zaire", "ezy_sc-text");
?></option>
<option value="Zambia"><?php
echo esc_html__("Zambia", "ezy_sc-text");
?></option>
<option value="Zimbabwe"><?php
echo esc_html__("Zimbabwe", "ezy_sc-text");
?></option>
<option value="Unknown"><?php
    echo esc_html__("Unknown", "ezy_sc-text");
?></option>
</select>
											</div>
										</div>
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-danger" name="ban-country" type="submit"><?php
echo esc_html__("Ban", "ezy_sc-text");
?></button>
							<button type="reset" class="btn btn-flat btn-default"><?php
echo esc_html__("Reset", "ezy_sc-text");
?></button>
				        </div>
				     </div>
				</div>
</form>
</div>