<?php
include_once 'ezy_sc_sub_module.php';
//  ;


if (!defined('ABSPATH')) {
    die('Page not found');
}

$table = $wpdb->prefix . 'wpg_loginhistory';
?>
<div class="row">
                    
				<div class="col-md-12">
<form class="form-horizontal" method="post">
				    <div class="col-md-12 card card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><i class="fas fa-history"></i> <?php
echo esc_html__("Login History", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body mx-auto col-md-12">

<table id="dt-basic" class="table table-bordered table-hover table-sm" cellspacing="0" width="100%">
									<thead>
										<tr>
										  <th><i class="fas fa-list"></i> <?php
echo esc_html__("ID", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-user"></i> <?php
echo esc_html__("Username", "ezy_sc-text");
?></th>
                                          <th><i class="fas fa-address-card"></i> <?php
echo esc_html__("IP Address", "ezy_sc-text");
?></th>
						                  <th><i class="fas fa-calendar"></i> <?php
echo esc_html__("Date", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-clock"></i> <?php
echo esc_html__("Time", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-info-circle"></i> <?php
echo esc_html__("Login Status", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT id, username, ip, date, time, successful FROM `$table` ORDER by id DESC");
foreach ($query as $row) {
    echo '
										<tr>
										  <td>' . esc_html($row->id) . '</td>
										  <td>' . esc_html($row->username) . '</td>
										  <td>' . esc_html($row->ip) . '</td>
						                  <td  data-sort="' . esc_html($row->date) . '">' . esc_html($row->date) . '</td>
										  <td>' . esc_html($row->time) . '</td>
										  <td>';
    if ($row->successful == 1) {
        echo '<span class="badge badge-success">' . esc_html__("Successful", "ezy_sc-text") . '</span>';
    } else {
        echo '<span class="badge badge-danger">' . esc_html__("Failed", "ezy_sc-text") . '</span>';
    }
    echo '</td>
										</tr>
';
}
?>
									</tbody>
								    </table>

						</div>
                     </div>
					 </div>
</form>
</div>