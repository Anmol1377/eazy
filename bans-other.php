<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_POST['block'])) {
    $value  = sanitize_text_field($_POST['value']);
    $type   = sanitize_text_field($_POST['type']);
    $date   = date_i18n(get_option('date_format'));
    $time   = date_i18n(get_option('time_format'));
    $reason = '';
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", $type, $value));
    if ($validator > 0) {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> ' . esc_html__("There is already such record in the database.", "ezy_sc-text") . '</p>
        </div>';
    } else {
        add_ban($type, $value, $date, $time, $reason);
    }
}
?>
<div class="row">
                   
				<div class="col-md-6">
				     <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Ban Browser, OS or ISP", "ezy_sc-text");
?></h3>
						</div>
				        <div class="card-body">
						<form class="form-horizontal" action="" method="post">
										<div class="form-group">
											<label class="control-label"><?php
echo esc_html__("Browser, OS or ISP Name:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="value" class="form-control" type="text" required>
											</div>
										</div>
                                        <div class="form-group">
											<label class="control-label"><?php
echo esc_html__("Type:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
	<select name="type" class="form-control" required>
        <option value="browser" selected><?php
echo esc_html__("Browser", "ezy_sc-text");
?></option>
        <option value="os"><?php
echo esc_html__("Operating System", "ezy_sc-text");
?></option>
        <option value="isp"><?php
echo esc_html__("Internet Service Provider", "ezy_sc-text");
?></option>
		<option value="referrer"><?php
echo esc_html__("Referrer", "ezy_sc-text");
?></option>
    </select>
											</div>
										</div>
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-block btn-danger" name="block" type="submit"><?php
echo esc_html__("Ban", "ezy_sc-text");
?></button>
				        </div>
				     </div>
				</div>
</form>
                    
                    <div class="col-md-6">
				     <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Blocked", "ezy_sc-text");
?> <strong><?php
echo esc_html__("Internet Service Providers", "ezy_sc-text");
?></strong></h3>
						</div>
				        <div class="card-body">
<table id="dt-basic4" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
						                  <th><i class="fas fa-cloud"></i> <?php
echo esc_html__("ISP", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table` WHERE type='isp'");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . esc_html($row->value) . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-bans&a=4&delete-id=' . esc_html($row->id) . '" class="btn btn-flat btn-success btn-sm btn-block"><i class="fas fa-unlock"></i> ' . esc_html__("Unblock", "ezy_sc-text") . '</a>
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
                    
                <div class="row">
				<div class="col-md-6">
				    <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Blocked", "ezy_sc-text");
?> <strong><?php
echo esc_html__("Browsers", "ezy_sc-text");
?></strong></h3>
						</div>
						<div class="card-body">
<table id="dt-basic5" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
						                  <th><i class="fas fa-globe"></i> <?php
echo esc_html__("Browser", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table` WHERE type='browser'");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . $row->value . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-bans&a=4&delete-id=' . $row->id . '" class="btn btn-flat btn-success btn-sm btn-block"><i class="fas fa-unlock"></i> ' . esc_html__("Unblock", "ezy_sc-text") . '</a>
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
                    
				<div class="col-md-6">
				     <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Blocked", "ezy_sc-text");
?> <strong><?php
echo esc_html__("Operating Systems", "ezy_sc-text");
?></strong></h3>
						</div>
				        <div class="card-body">
<table id="dt-basic6" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
						                  <th><i class="fas fa-desktop"></i> <?php
echo esc_html__("Operating System", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table` WHERE type='os'");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . $row->value . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-bans&a=4&delete-id=' . $row->id . '" class="btn btn-flat btn-success btn-sm btn-block"><i class="fas fa-unlock"></i> ' . esc_html__("Unblock", "ezy_sc-text") . '</a>
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
				
				<div class="col-md-6">
				     <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Blocked", "ezy_sc-text");
?> <strong><?php
echo esc_html__("Referrers", "ezy_sc-text");
?></strong></h3>
						</div>
				        <div class="card-body">
<table id="dt-basic7" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
						                  <th><i class="fas fa-link"></i> <?php
echo esc_html__("Referrer", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table` WHERE type='referrer'");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . $row->value . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-bans&a=4&delete-id=' . $row->id . '" class="btn btn-flat btn-success btn-sm btn-block"><i class="fas fa-unlock"></i> ' . esc_html__("Unblock", "ezy_sc-text") . '</a>
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