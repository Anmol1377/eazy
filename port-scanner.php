<?php

// include_once 'ezy_sc_sub_module.php';

//  ;





if (!defined('ABSPATH')) {

    die('Page not found');

}

?>

<div class="row">

				<div class="col-md-9">

<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);



set_time_limit(360);

ini_set('max_execution_time', 300); //300 Seconds = 5 Minutes

ini_set('memory_limit', '512M');



$ports = array(

    20,

    21,

    22,

    23,

    25,

    53,

    79,

    80,

    110,

    115,

    119,

    135,

    137,

    138,

    139,

    143,

    194,

    389,

    443,

    445,

    465,

    520,

    548,

    515,

    587,

    631,

    993,

    995,

    1080,

    1433,

    1434,

    1521,

    1701,

    1723,

    2082,

    2086,

    2095,

    3306,

    3389,

    5432,

    5900,

    8000,

    8080,

    11211

);



$results = array();

foreach ($ports as $port) {

    if ($pf = fsockopen($_SERVER['SERVER_NAME'], $port, $err, $err_string, 1)) {

        $results[$port] = true;

        fclose($pf);

    } else {

        $results[$port] = false;

    }

}



echo '<div class="card card-dark col-md-12">

			<div class="card-header" style="background-color:#8c52ff; color:white;">

				<h3 class="card-title">' . esc_html__("Scan results for", "ezy_sc-text") . ' <b>' . sanitize_text_field($_SERVER['SERVER_NAME']) . '</b></h3>

			</div>

			<div class="card-body">';



echo '<div class="table-responsive"><table class="table table-bordered table-hover table-sm">

    <thead>

      <tr>

        <th><i class="fas fa-dot"></i> ' . esc_html__("Port", "ezy_sc-text") . '</th>

        <th><i class="fas fa-cogs"></i> ' . esc_html__("Service", "ezy_sc-text") . '</th>

        <th><i class="fas fa-info-circle"></i> ' . esc_html__("Status", "ezy_sc-text") . '</th>

      </tr>

    </thead>

    <tbody>';



foreach ($results as $port => $val) {

    $prot = getservbyport($port, "tcp");

    echo "<tr><td>$port</td><td>$prot</td>";

    if ($val) {

        echo '<td><a href="http://' . sanitize_text_field($_SERVER['SERVER_NAME']) . ':' . esc_html($port) . '" target="_blank" class="badge badge-danger" size="13px"><i class="fas fa-unlock"></i> ' . esc_html__("Open", "ezy_sc-text") . '</a></td></tr>';

    } else {

        echo '

			<td><font class="badge badge-success" size="13px"><i class="fas fa-lock"></i> ' . esc_html__("Closed", "ezy_sc-text") . '</font></td></tr>';

    }

}



echo '</tbody>

    </table></div>';



echo '</div></div></div>';

?>

                    

				<div class="col-md-3">

				     <div class="card card-dark col-md-12">

						<div class="card-header" style="background-color:#8c52ff; color:white;">

							<h3 class="card-title"><?php

echo esc_html__("What is", "ezy_sc-text");

?> Port Scanning</h3>

						</div>

				        <div class="card-body">

						    <?php

echo esc_html__("Port Scanning is the name for the technique used to identify open ports and services available on a network host. Port Scanning is used to determine which ports are open and vulnerable to attacks.", "ezy_sc-text");

?> 

							<br /><br />

							<?php

echo esc_html__("Port Scanning is a slow proccess and can take a while.", "ezy_sc-text");

?>

                        </div>



				     </div>

				</div>

</div>