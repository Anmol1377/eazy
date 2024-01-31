<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

$table = $wpdb->prefix . 'wpg_bans';

if (isset($_POST['ban-ip'])) {
    
    $ip     = sanitize_text_field($_POST['ip']);
    $date   = date_i18n(get_option('date_format'));
    $time   = date_i18n(get_option('time_format'));
    $reason = sanitize_text_field($_POST['reason']);
    
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        echo '<br />
			<div class="callout callout-danger">
					<p><i class="fas fa-exclamation-triangle"></i> ' . balanceTags("The entered <strong>IP Address</strong> is invalid.", "ezy_sc-text") . '</p>
			</div>';
    } else {
        $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'ip', $ip));
        if ($validator > 0) {
            echo '<br />
			<div class="callout callout-info">
					<p><i class="fas fa-info-circle"></i> ' . balanceTags("This <strong>IP Address</strong> is already banned.", "ezy_sc-text") . '</p>
			</div>';
        } else {
            add_ban("ip", $ip, $date, $time, $reason);
        }
    }
}
?>
<div class="row">
                    
				<div class="col-md-9">
<?php
if (isset($_GET['editip-id'])) {
    $id = (int) $_GET["editip-id"];
    
    $row    = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d AND type = %s LIMIT 1", $id, 'ip'));
    $ips    = $row->value;
    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'ip', $ips));
    
    if (empty($id) || $result == 0) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-bans">';
        exit();
    }
    
    if (isset($_POST['edit-ban'])) {
        $ip     = sanitize_text_field($_POST['ip']);
        $reason = sanitize_text_field($_POST['reason']);
        
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            echo '<br />
			<div class="callout callout-danger">
					<p><i class="fas fa-exclamation-triangle"></i> ' . balanceTags("The entered <strong>IP Address</strong> is invalid.", "ezy_sc-text") . '</p>
			</div>';
        } else {
            update_ban($id, $ip, $reason);
        }
    }
?>         
<form class="form-horizontal" action="" method="post">
                    <div class="card col-md-12 card-dark">
						<div class="card-header">
							<h3 class="card-title"><?php
    echo esc_html__("Edit - IP Address Ban", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
										<div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("IP Address:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="ip" class="form-control" type="text" value="<?php
    echo esc_html($row->value);
?>" required>
											</div>
										</div>
                                        <div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("Reason:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="reason" class="form-control" type="text" value="<?php
    echo esc_html($row->reason);
?>">
											</div>
										</div>
                                        <div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("Ban Date:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="date" class="form-control" type="text" value="<?php
    echo esc_html($row->date) . ' at ' . esc_html($row->time);
?>" readonly>
											</div>
										</div>
                                        <div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("AutoBanned:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="autoban" class="form-control" type="text" value="<?php
    if ($row->autoban == 1) {
        echo 'Yes';
    } else {
        echo 'No';
    }
?>" readonly>
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
echo esc_html__("IP Bans", "ezy_sc-text");
?></h3>
							<a href="admin.php?page=ezy_sc-bans&delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" title="Delete all IP Bans"><i class="fas fa-trash"></i> <?php
echo esc_html__("Delete All", "ezy_sc-text");
?></a>
						</div>
						<div class="card-body">
						
<table id="dt-basic3" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
						                  <th><i class="fas fa-user"></i> <?php
echo esc_html__("IP Address", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-calendar"></i> <?php
echo esc_html__("Banned On", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-magic"></i> <?php
echo esc_html__("Autobanned", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table` WHERE type='ip'");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . $row->value . '</td>
										    <td>' . $row->date . '</td>
										    <td>';
    if ($row->autoban == 1) {
        echo 'Yes';
    } else {
        echo 'No';
    }
    echo '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-bans&editip-id=' . $row->id . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> ' . esc_html__("Edit", "ezy_sc-text") . '</a>
                                            <a href="admin.php?page=ezy_sc-bans&delete-id=' . $row->id . '" class="btn btn-flat btn-success btn-sm"><i class="fas fa-ban"></i> ' . esc_html__("Unban", "ezy_sc-text") . '</a>
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
                   
<?php
if (!isset($_GET['ip'])) {
    $ip = '';
} else {
    $ip = $_GET['ip'];
}
if (!isset($_GET['reason'])) {
    $reason = '';
} else {
    $reason = $_GET['reason'];
}
?>

				<div class="col-md-3">
				     <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Ban IP Address", "ezy_sc-text");
?></h3>
						</div>
				        <div class="card-body">
						<form class="form-horizontal" action="" method="post">
										<div class="form-group">
											<label class="control-label"><?php
echo esc_html__("IP Address:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="ip" class="form-control" type="text" value="<?php
echo esc_html($ip);
?>" required>
											</div>
										</div>
                                        <div class="form-group">
											<label class="control-label"><?php
echo esc_html__("Reason:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="reason" class="form-control" type="text" value="<?php
echo esc_html($reason);
?>">
											</div>
										</div>
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-danger" name="ban-ip" type="submit"><?php
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