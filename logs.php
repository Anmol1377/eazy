<?php

// include_once 'ezy_sc_sub_module.php';

?>



<?php

if (!defined('ABSPATH')) {

    die('Page not found');

}



$table = $wpdb->prefix . 'wpg_logs';



if (isset($_GET['delete-id'])) {

    $id = (int) $_GET["delete-id"];

    

    $wpdb->delete($table, array(

        'id' => $id

    ));

}



if (isset($_GET['delete-all'])) {

    $wpdb->query("TRUNCATE TABLE `$table`");

}

?>

<div class="row">

				<div class="col-md-12">

                    

				    <div class="card col-md-12 card-dark">

						<div class="card-header" style="background-color:#8c52ff; color:white;">

							<h3 class="card-title"><i class="fas fa-list"></i> <?php

echo esc_html__("Logs", "ezy_sc-text");

?></h3>

							<a href="admin.php?page=ezy_sc-logs&delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" title="Delete all logs"><i class="fas fa-trash"></i> <?php

echo esc_html__("Delete All", "ezy_sc-text");

?></a>

						</div>

						<div class="card-body">



<table id="dt-basic" class="table table-bordered table-hover table-sm" cellspacing="0" width="100%">

									<thead>

										<tr>

						                  <th><?php

echo esc_html__("ID", "ezy_sc-text");

?></th>

										  <th><?php

echo esc_html__("IP Address", "ezy_sc-text");

?></th>

										  <th><?php

echo esc_html__("Type", "ezy_sc-text");

?></th>

						                  <th><?php

echo esc_html__("Date", "ezy_sc-text");

?></th>

										  <th><?php

echo esc_html__("Browser", "ezy_sc-text");

?></th>

										  <th><?php

echo esc_html__("OS", "ezy_sc-text");

?></th>

										  <th><?php

echo esc_html__("Country", "ezy_sc-text");

?></th>

										  <th><?php

echo esc_html__("Actions", "ezy_sc-text");

?></th>

										</tr>

									</thead>

									<tbody>

<?php

$query = $wpdb->get_results("SELECT id, ip, date, time, browser, browser_code, os, os_code, country, country_code, type FROM `$table` ORDER by id DESC");

foreach ($query as $row) {

    echo '

										<tr>

										  <td>' . esc_html($row->id) . '</td>

										  <td>' . esc_html($row->ip) . '</td>

										  <td>';

    if ($row->type == 'SQLi') {

        echo '

						                    <i class="fas fa-code"></i> ' . esc_html($row->type) . '

						                    ';

    } else if ($row->type == 'Proxy') {

        echo '

						                    <i class="fas fa-globe"></i> ' . esc_html($row->type) . ' 

						                    ';

    } else if ($row->type == 'Spammer') {

        echo '

						                    <i class="fas fa-keyboard"></i> ' . esc_html($row->type) . '

						                    ';

    } else {

        echo '

						                    <i class="fas fa-user-secret"></i> ' . esc_html($row->type) . '

						                    ';

    }

    echo '

										  </td>

						                  <td data-sort="' . esc_html($row->date) . ', ' . $row->time . '">' . $row->date . ', ' . $row->time . '</td>

										  <td><img src="'. esc_url(plugins_url('assets/img/icons/browser/'.esc_html($row->browser_code).'.png', __FILE__)) .'" /> ' . esc_html($row->browser) . '</td>

										  <td><img src="'.esc_url(plugins_url('assets/img/icons/os/'.esc_html($row->os_code).'.png', __FILE__)) .'" /> ' . esc_html($row->os) . '</td>

										  <td><img src="'. esc_url(plugins_url('assets/plugins/flags/blank.png', __FILE__)) .'" class="flag flag-' . strtolower(esc_html($row->country_code)) . '" alt="' . esc_html($row->country) . '" /> ' . esc_html($row->country) . '</td>

										  <td>

                                            <a href="admin.php?page=ezy_sc-logdetails&id=' . esc_html($row->id) . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-tasks"></i> Details</a>

											<a href="admin.php?page=ezy_sc-logs&delete-id=' . esc_html($row->id) . '" class="btn btn-flat btn-danger btn-sm"><i class="fas fa-times"></i> ' . esc_html__("Delete", "ezy_sc-text") . '</a>

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

                    

</div>