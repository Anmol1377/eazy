<?php

// include_once 'ezy_sc_sub_module.php';



if (!defined('ABSPATH')) {

    die('Page not found');

}



if (isset($_GET['enable'])) {

	

    $live_traffic = 1;

	update_option('wpg_live_traffic', $live_traffic);

}



if (isset($_GET['disable'])) {

	

    $live_traffic = 0;

	update_option('wpg_live_traffic', $live_traffic);

	

	$files = glob(plugin_dir_path(__FILE__) . 'modules/cache/live-traffic/*'); // Get all cache file names

	foreach($files as $file){ // Iterate cache files

		if(is_file($file)) {

			unlink($file); // Delete cache file

		}

	}

}



$active = $active2 = '';

$show   = $show2 = '';



if (isset($_POST['save']) OR isset($_GET['refresh'])) {

    $active2 = 'active';

    $show2   = 'show ';

} else {

    $active = 'active';

    $show   = 'show ';

}



$table = $wpdb->prefix . 'wpg_livetraffic';



if (isset($_GET['delete-all'])) {

    $wpdb->query("TRUNCATE TABLE `$table`");

}



//Today Stats

$date  = date_i18n("d F Y");

$ctime = date_i18n("H:i", strtotime('-30 seconds'));



$tscount1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date = %s AND time >= %s", $date, $ctime));

$tscount2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date = %s AND uniquev = %d", $date, '1'));

$tscount3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date = %s", $date));

$tscount4 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date = %s AND uniquev = %d AND bot = %d", $date, '1', '1'));

//Month Stats

$mdate    = date_i18n('F Y');

$mscount1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date LIKE %s AND uniquev = %d", "%$mdate", '1'));

$mscount2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date LIKE %s", "%$mdate"));

$mscount3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date LIKE %s AND uniquev = %d AND bot = %d", "%$mdate", '1', '1'));



//Browser Stats

$bcount1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE browser LIKE %s", '%Google Chrome%'));

$bcount2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE browser LIKE %s", '%Firefox%'));

$bcount3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE browser LIKE %s", '%Opera%'));

$bcount4 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE browser LIKE %s", '%Edge%'));

$bcount5 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE browser LIKE %s", '%Internet Explorer%'));

$bcount6 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE browser LIKE %s", '%Safari%'));

$bcount7 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE browser NOT LIKE %s AND browser NOT LIKE %s AND browser NOT LIKE %s AND browser NOT LIKE %s AND browser NOT LIKE %s AND browser NOT LIKE %s", '%Google Chrome%', '%Firefox%', '%Opera%', '%Edge%', '%Internet Explorer%', '%Safari%'));



//OS Stats

$ocount1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE os LIKE %s", '%Windows%'));

$ocount2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE os LIKE %s", '%Linux%'));

$ocount3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE os LIKE %s", '%Android%'));

$ocount4 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE os LIKE %s", '%iOS%'));

$ocount5 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE os LIKE %s", '%Mac OS X%'));

$ocount6 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE os NOT LIKE %s AND os NOT LIKE %s AND os NOT LIKE %s AND os NOT LIKE %s AND os NOT LIKE %s", '%Windows%', '%Linux%', '%Android%', '%iOS%', '%Mac OS X%'));



//Platform Stats

$pcount1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE device_type = %s", 'Computer'));

$pcount2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE device_type = %s", 'Mobile'));

$pcount3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE device_type = %s", 'Tablet'));

?>

<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">

    <li class="nav-item">

        <a class="nav-link <?php

echo esc_html($active);

?>" id="analytics-tab" data-toggle="tab" href="#analytics" role="tab" aria-controls="analytics" aria-selected="true"><i

                class="fas fa-chart-line"></i> <?php

echo esc_html__("Visit Analytics", "ezy_sc-text");

?></a>

    </li>

    <li class="nav-item">

        <a class="nav-link <?php

echo esc_html($active2);

?>" id="livetraffic-tab" data-toggle="tab" href="#livetraffic" role="tab" aria-controls="livetraffic"

            aria-selected="false"><i class="fas fa-globe"></i> <?php

echo esc_html__("Live Traffic", "ezy_sc-text");

?></a>

    </li>

</ul>

<div class="tab-content" id="myTabContent">

    <div class="tab-pane <?php

echo esc_html($show) . ' ' . esc_html($active);

?>" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">



        <div class="row">

            <div class="col-md-12">



                <div class="card col-md-12 card-dark">

                    <div class="card-header" style="background-color:#8c52ff; color:white;">

                        <h3 class="card-title"><?php

echo esc_html__("Visit Analytics", "ezy_sc-text");

?></h3>

                        <div class="float-sm-right">

                            <?php

if (get_option('wpg_live_traffic') == 0) {

	echo '<a href="admin.php?page=ezy_sc-analytics&enable" class="btn btn-flat btn-dark btn-sm" style="background-color:white; color:black;"><i class="fas fa-play"></i> Enable</a>';

} else {

	echo '<a href="admin.php?page=ezy_sc-analytics&disable" class="btn btn-flat btn-dark btn-sm" style="background-color:white; color:black;"><i class="fas fa-pause-circle"></i> Disable</a>';

}

?>

                            <a href="admin.php?page=ezy_sc-analytics&delete-all"

                                class="btn btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> Delete Data</a>

                        </div>

                    </div>

                    <div class="card-body">



                        <h4 class="card-title"><?php

echo esc_html__("Today's Stats", "ezy_sc-text");

?></h4><br />



                        <div class="row">

                            <div class="col-sm-6 col-lg-3">

                                <div class="small-box bg-success">

                                    <div class="inner">

                                        <h3><?php

echo esc_html($tscount1);

?></h3>

                                        <p><?php

echo esc_html__("Online Visitors", "ezy_sc-text");

?></p>

                                    </div>

                                    <div class="icon">

                                        <i class="fas fa-users"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-6 col-lg-3">

                                <div class="small-box bg-info">

                                    <div class="inner">

                                        <h3><?php

echo esc_html($tscount2);

?></h3>

                                        <p><?php

echo esc_html__("Unique Visits", "ezy_sc-text");

?></p>

                                    </div>

                                    <div class="icon">

                                        <i class="fas fa-chart-line"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-6 col-lg-3">

                                <div class="small-box bg-danger">

                                    <div class="inner">

                                        <h3><?php

echo esc_html($tscount3);

?></h3>

                                        <p><?php

echo esc_html__("Total Visits", "ezy_sc-text");

?></p>

                                    </div>

                                    <div class="icon">

                                        <i class="fas fa-chart-bar"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-6 col-lg-3">

                                <div class="small-box bg-warning">

                                    <div class="inner">

                                        <h3><?php

echo esc_html($tscount4);

?></h3>

                                        <p><?php

echo esc_html__("Bot Visits", "ezy_sc-text");

?></p>

                                    </div>

                                    <div class="icon">

                                        <i class="fab fa-android"></i>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <br />

                        <h4 class="card-title"><?php

echo esc_html__("This Month's Stats", "ezy_sc-text");

?></h4><br />



                        <div class="row">



                            <div class="col-sm-6 col-lg-4">

                                <div class="small-box bg-info">

                                    <div class="inner">

                                        <h3><?php

echo esc_html($mscount1);

?></h3>

                                        <p><?php

echo esc_html__("Unique Visits", "ezy_sc-text");

?></p>

                                    </div>

                                    <div class="icon">

                                        <i class="fas fa-chart-line"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-6 col-lg-4">

                                <div class="small-box bg-danger">

                                    <div class="inner">

                                        <h3><?php

echo esc_html($mscount2);

?></h3>

                                        <p><?php

echo esc_html__("Total Visits", "ezy_sc-text");

?></p>

                                    </div>

                                    <div class="icon">

                                        <i class="fas fa-chart-bar"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-6 col-lg-4">

                                <div class="small-box bg-warning">

                                    <div class="inner">

                                        <h3><?php

echo esc_html($mscount3);

?></h3>

                                        <p><?php

echo esc_html__("Bot Visits", "ezy_sc-text");

?></p>

                                    </div>

                                    <div class="icon">

                                        <i class="fab fa-android"></i>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <br />

                        <h4 class="card-title"><?php

echo esc_html__("Visits This Month", "ezy_sc-text");

?></h4><br />



                        <canvas id="visits-chart"></canvas>



                        <br />

                        <h4 class="card-title"><?php

echo esc_html__("Overall Statistics", "ezy_sc-text");

?></h4><br />



                        <div class="row">

                            <div class="col-md-4">

                                <center>

                                    <h5><?php

echo esc_html__("Browser Statistics", "ezy_sc-text");

?></h5>

                                </center>

                                <div id="canvas-holder" width="100%">

                                    <canvas id="browser-graph"></canvas>

                                </div>

                            </div>



                            <div class="col-md-4">

                                <center>

                                    <h5><?php

echo esc_html__("Operating System Statistics", "ezy_sc-text");

?></h5>

                                </center>

                                <div id="canvas-holder" width="100%">

                                    <canvas id="os-graph"></canvas>

                                </div>

                            </div>





                            <div class="col-md-4">

                                <br />

                                <center>

                                    <h5><?php

echo esc_html__("Device Statistics", "ezy_sc-text");

?></h5>

                                </center>

                                <div id="canvas-holder" width="100%">

                                    <canvas id="device-graph"></canvas>

                                </div>

                            </div>

                        </div>





                        <div class="col-md-12">

                            <hr />

                            <h5><?php

echo esc_html__("Visits by Country", "ezy_sc-text");

?></h5><br />



                            <table id="dt-basic" class="table table-bordered table-hover" cellspacing="0" width="100%">

                                <thead>

                                    <tr>

                                        <th><i class="fas fa-globe"></i> <?php

echo esc_html__("Country", "ezy_sc-text");

?></th>

                                        <th><i class="fas fa-users"></i> Visitors</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

$countries = array(

    "Afghanistan",

    "Albania",

    "Algeria",

    "Andorra",

    "Angola",

    "Antigua and Barbuda",

    "Argentina",

    "Armenia",

    "Australia",

    "Austria",

    "Azerbaijan",

    "Bahamas",

    "Bahrain",

    "Bangladesh",

    "Barbados",

    "Belarus",

    "Belgium",

    "Belize",

    "Benin",

    "Bhutan",

    "Bolivia",

    "Bosnia and Herzegovina",

    "Botswana",

    "Brazil",

    "Brunei",

    "Bulgaria",

    "Burkina Faso",

    "Burundi",

    "Cambodia",

    "Cameroon",

    "Canada",

    "Cape Verde",

    "Central African Republic",

    "Chad",

    "Chile",

    "China",

    "Colombi",

    "Comoros",

    "Congo (Brazzaville)",

    "Congo",

    "Costa Rica",

    "Cote d\'Ivoire",

    "Croatia",

    "Cuba",

    "Cyprus",

    "Czech Republic",

    "Denmark",

    "Djibouti",

    "Dominica",

    "Dominican Republic",

    "East Timor (Timor Timur)",

    "Ecuador",

    "Egypt",

    "El Salvador",

    "Equatorial Guinea",

    "Eritrea",

    "Estonia",

    "Ethiopia",

    "Fiji",

    "Finland",

    "France",

    "Gabon",

    "Gambia, The",

    "Georgia",

    "Germany",

    "Ghana",

    "Greece",

    "Grenada",

    "Guatemala",

    "Guinea",

    "Guinea-Bissau",

    "Guyana",

    "Haiti",

    "Honduras",

    "Hungary",

    "Iceland",

    "India",

    "Indonesia",

    "Iran",

    "Iraq",

    "Ireland",

    "Israel",

    "Italy",

    "Jamaica",

    "Japan",

    "Jordan",

    "Kazakhstan",

    "Kenya",

    "Kiribati",

    "Korea, North",

    "Korea, South",

    "Kuwait",

    "Kyrgyzstan",

    "Laos",

    "Latvia",

    "Lebanon",

    "Lesotho",

    "Liberia",

    "Libya",

    "Liechtenstein",

    "Lithuania",

    "Luxembourg",

    "Macedonia",

    "Madagascar",

    "Malawi",

    "Malaysia",

    "Maldives",

    "Mali",

    "Malta",

    "Marshall Islands",

    "Mauritania",

    "Mauritius",

    "Mexico",

    "Micronesia",

    "Moldova",

    "Monaco",

    "Mongolia",

    "Morocco",

    "Mozambique",

    "Myanmar",

    "Namibia",

    "Nauru",

    "Nepal",

    "Netherlands",

    "New Zealand",

    "Nicaragua",

    "Niger",

    "Nigeria",

    "Norway",

    "Oman",

    "Pakistan",

    "Palau",

    "Panama",

    "Papua New Guinea",

    "Paraguay",

    "Peru",

    "Philippines",

    "Poland",

    "Portugal",

    "Qatar",

    "Romania",

    "Russia",

    "Rwanda",

    "Saint Kitts and Nevis",

    "Saint Lucia",

    "Saint Vincent",

    "Samoa",

    "San Marino",

    "Sao Tome and Principe",

    "Saudi Arabia",

    "Senegal",

    "Serbia and Montenegro",

    "Seychelles",

    "Sierra Leone",

    "Singapore",

    "Slovakia",

    "Slovenia",

    "Solomon Islands",

    "Somalia",

    "South Africa",

    "Spain",

    "Sri Lanka",

    "Sudan",

    "Suriname",

    "Swaziland",

    "Sweden",

    "Switzerland",

    "Syria",

    "Taiwan",

    "Tajikistan",

    "Tanzania",

    "Thailand",

    "Togo",

    "Tonga",

    "Trinidad and Tobago",

    "Tunisia",

    "Turkey",

    "Turkmenistan",

    "Tuvalu",

    "Uganda",

    "Ukraine",

    "United Arab Emirates",

    "United Kingdom",

    "United States",

    "Uruguay",

    "Uzbekistan",

    "Vanuatu",

    "Vatican City",

    "Venezuela",

    "Vietnam",

    "Yemen",

    "Zambia",

    "Zimbabwe",

    "Unknown"

);



foreach ($countries as $country) {

    $log_result = $wpdb->get_row($wpdb->prepare("SELECT country, country_code FROM `$table` WHERE `country` LIKE %s LIMIT 1", "%$country%"));

    $log_rows   = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table` WHERE `country` LIKE %s", "%$country%"));

    

    if ($log_rows > 0) {

        echo '<tr>';

        echo '<td><img src="'. esc_url(plugins_url('assets/plugins/flags/blank.png', __FILE__)) .'" class="flag flag-' . strtolower($log_result->country_code) . '"/>&nbsp; ' . $country . '</td>';

        echo '<td>' . $log_rows . '</td>';

        echo '</tr>';

    }

}

?>

                                </tbody>

                            </table>



                        </div>



                    </div>

                </div>



            </div>

        </div>



    </div>

    <div class="tab-pane <?php

echo esc_html($show2) . ' ' . esc_html($active2);

?>" id="livetraffic" role="tabpanel" aria-labelledby="livetraffic-tab">

        <div class="row">

            <div class="col-md-12">



                <div class="card col-md-12 card-dark">

                    <div class="card-header" style="background-color:#8c52ff; color:white;">

                        <h3 class="card-title"><?php

echo esc_html__("Live Traffic", "ezy_sc-text");

?></h3>

                        <div class="float-sm-right">

                            <?php

if (get_option('wpg_live_traffic') == 0) {

	echo '<a href="admin.php?page=ezy_sc-analytics&enable" class="btn btn-flat btn-dark btn-sm" style="background-color:white; color:black;"><i class="fas fa-play"></i> Enable</a>';

} else {

	echo '<a href="admin.php?page=ezy_sc-analytics&disable" class="btn btn-flat btn-drak btn-sm" style="background-color:white; color:black;"><i class="fas fa-pause-circle"></i> Disable</a>';

}

?>

                            <a href="admin.php?page=ezy_sc-analytics&refresh" class="btn btn-flat btn-primary btn-sm" style="background-color:white; color:black;"><i

                                    class="fas fa-sync-alt" ></i> Refresh</a>

                            <a href="admin.php?page=ezy_sc-analytics&delete-all"

                                class="btn btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> <?php

echo esc_html__("Delete All", "ezy_sc-text");

?></a>

                        </div>

                    </div>

                    <div class="card-body">



                        <div class="table-responsive">

                            <table id="dt-basic2" class="table table-sm table-bordered table-hover compact"

                                cellspacing="0" width="100%">

                                <thead class="thead-light">

                                    <tr>

                                        <th><?php

echo esc_html__("ID", "ezy_sc-text");

?></th>

                                        <th><?php

echo esc_html__("IP Address", "ezy_sc-text");

?></th>

                                        <th><?php

echo esc_html__("Country", "ezy_sc-text");

?></th>

                                        <th><?php

echo esc_html__("Browser", "ezy_sc-text");

?></th>

                                        <th><?php

echo esc_html__("OS", "ezy_sc-text");

?></th>

                                        <th><?php

echo esc_html__("Page", "ezy_sc-text");

?></th>

                                        <th><?php

echo esc_html__("Date & Time", "ezy_sc-text");

?></th>

                                        <th><?php

echo esc_html__("Actions", "ezy_sc-text");

?></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

$livetrafficdb = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");

foreach ($livetrafficdb as $row) {

    echo '

										<tr>

											<td>' . $row->id . '</td>

											<td>' . $row->ip . '

											';

    if ($row->bot == 1) {

        echo '<span class="badge badge-primary">' . esc_html__("Bot", "ezy_sc-text") . '</span>';

    }

    echo '</td>

                                            <td><img src="'. esc_url(plugins_url('assets/plugins/flags/blank.png', __FILE__)) .'" class="flag flag-' . strtolower($row->country_code) . '" alt="' . $row->country . '" /> ' . $row->country . '</td>

											<td><img src="'. esc_url(plugins_url('assets/img/icons/browser/'.esc_html($row->browser_code).'.png', __FILE__)) .'" /> ' . $row->browser . '</td>

										    <td><img src="'. esc_url(plugins_url('assets/img/icons/os/'.esc_html($row->os_code).'.png', __FILE__)) .'" /> ' . $row->os . '</td>

											<td>' . $row->request_uri . '</td>

	                                        <td data-sort="' . esc_html($row->date) . ', ' . $row->time . '">' . $row->date . ', ' . $row->time . '</td>

											<td><a href="admin.php?page=ezy_sc-visitordetails&id=' . $row->id . '" class="btn btn-sm btn-flat btn-primary"><i class="fas fa-tasks"></i> ' . esc_html__("Details", "ezy_sc-text") . '</a></td>

										</tr>

';

}

?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>



            </div>

        </div>

    </div>

    <?php

$wpgcustom_js3 = '

var config = {

    type: \'pie\',

    data: {

		datasets: [{

			data: [

				' . esc_html($bcount1) . ',

				' . esc_html($bcount2) . ',

				' . esc_html($bcount3) . ',

				' . esc_html($bcount4) . ',

				' . esc_html($bcount5) . ',

				' . esc_html($bcount6) . ',

				' . esc_html($bcount7) . ',

					],

					backgroundColor: [

						\'#32CD32\',

    					\'#FFD700\',

    					\'#FF0000\',

						\'#00BFFF\',

						\'#1E90FF\',

						\'#B0C4DE\',

    					\'#000000\',

					]

				}],

				labels: [

					\'Google Chrome\',

					\'Firefox\',

					\'Opera\',

					\'Edge\',

					\'Internet Explorer\',

					\'Safari\',

					\'Other\'

				]

			},

			options: {

				responsive: true

			}

  };

  

var config2 = {

    type: \'pie\',

    data: {

		datasets: [{

			data: [

				' . esc_html($ocount1) . ',

				' . esc_html($ocount2) . ',

				' . esc_html($ocount3) . ',

				' . esc_html($ocount4) . ',

				' . esc_html($ocount5) . ',

				' . esc_html($ocount6) . ',

					],

					backgroundColor: [

						\'#1E90FF\',

    					\'#FFD700\',

    					\'#7CFC00\',

						\'#D3D3D3\',

						\'#B0C4DE\',

    					\'#000000\',

					]

				}],

				labels: [

					\'Windows\',

					\'Linux\',

					\'Android\',

					\'iOS\',

					\'Mac OS X\',

					\'Other\'

				]

			},

			options: {

				responsive: true

			}

  };

  

var config3 = {

    type: \'pie\',

    data: {

		datasets: [{

			data: [

				' . esc_html($pcount2) . ',

				' . esc_html($ocount3) . ',

				' . esc_html($ocount1) . ',

					],

					backgroundColor: [

						\'#00BFFF\',

    					\'#FFD700\',

    					\'#FF0000\',

					]

				}],

				labels: [

					\'Mobile\',

					\'Tablet\',

					\'Computer\'

				]

			},

			options: {

				responsive: true

			}

  };

  

		var config4 = {

			type: \'line\',

			data: {

				labels: [';

$i             = 1;

$days = cal_days_in_month(CAL_GREGORIAN, date_i18n("n"), date_i18n("Y"));

while ($i <= $days) {

    $wpgcustom_js3 .= "'$i'";

    

    if ($i != $days) {

        $wpgcustom_js3 .= ',';

    }

    

    $i++;

}

$wpgcustom_js3 .= '

				],

				datasets: [{

					label: \'Total Visits\',

					backgroundColor: \'#1E90FF\',

					borderColor: \'#1E90FF\',

					data: [';

$i    = 1;

$days = cal_days_in_month(CAL_GREGORIAN, date_i18n("n"), date_i18n("Y"));

while ($i <= $days) {

    $mdatef = sprintf("%02d", $i) . ' ' . date_i18n("F Y");

    $mcount1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date = %s", $mdatef));

    $wpgcustom_js3 .= "'$mcount1'";

    

    if ($i != $days) {

        $wpgcustom_js3 .= ',';

    }

    

    $i++;

}

$wpgcustom_js3 .= '

					],

					fill: false,

				}, {

					label: \'Unique Visits\',

					fill: false,

					backgroundColor: \'#3CB371\',

					borderColor: \'#3CB371\',

					data: [';

$i    = 1;

$days = cal_days_in_month(CAL_GREGORIAN, date_i18n("n"), date_i18n("Y"));

while ($i <= $days) {

    $mdatef = sprintf("%02d", $i) . ' ' . date_i18n("F Y");

    $mcount2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table

                    WHERE date = %s AND uniquev = %d", $mdatef, '1'));

    $wpgcustom_js3 .= "'$mcount2'";

    

    if ($i != $days) {

        $wpgcustom_js3 .= ',';

    }

    

    $i++;

}

$wpgcustom_js3 .= '

					],

				}]

			},

			options: {

				responsive: true,

				tooltips: {

					mode: \'index\',

					intersect: false,

				},

				hover: {

					mode: \'nearest\',

					intersect: true

				},

				scales: {

					xAxes: [{

						display: true,

						scaleLabel: {

							display: true,

							labelString: \'' . date_i18n("F Y") . '\'

						}

					}],

					yAxes: [{

						display: true,

						scaleLabel: {

							display: true,

							labelString: \'Visits\'

						}

					}]

				}

			}

		};

  

  window.onload = function() {

	var ctx = document.getElementById(\'browser-graph\').getContext(\'2d\');

	window.browsergraph = new Chart(ctx, config);

	var ctx2 = document.getElementById(\'os-graph\').getContext(\'2d\');

	window.osgraph = new Chart(ctx2, config2);

	var ctx3 = document.getElementById(\'device-graph\').getContext(\'2d\');

	window.devicegraph = new Chart(ctx3, config3);

	var ctx4 = document.getElementById(\'visits-chart\').getContext(\'2d\');

	window.visitschart = new Chart(ctx4, config4);

  };

';

wp_register_script('ezy_sc-js3', '', [], '', true);

wp_enqueue_script('ezy_sc-js3');

wp_add_inline_script('ezy_sc-js3', $wpgcustom_js3);

?>