<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

$table = $wpdb->prefix . 'wpg_bans';

if (isset($_POST['ban-iprange'])) {
    
    $iprange = sanitize_text_field($_POST['ip_range']);
    $date    = date_i18n(get_option('date_format'));
    $time    = date_i18n(get_option('time_format'));
    $reason  = '';
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'ip_range', $iprange));
    if ($validator > 0) {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> ' . balanceTags("This <strong>IP Range</strong> is already banned.", "ezy_sc-text") . '</p>
        </div>';
    } else {
        add_ban("ip_range", $iprange, $date, $time, $reason);
    }
}
?>
<div class="row">
                    
				<div class="col-md-9">
<?php
if (isset($_GET['editiprange-id'])) {
    $id = (int) $_GET["editiprange-id"];
    
    $row      = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d AND type = %s LIMIT 1", $id, 'ip_range'));
    $ipranges = $row->value;
    $result   = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND value = %s LIMIT 1", 'ip_range', $ipranges));
    
    if (empty($id) || $result == 0) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-bans&a=3">';
        exit();
    }
    
    if (isset($_POST['edit-ban'])) {
        $iprange = sanitize_text_field($_POST['ip_range']);
        $reason  = '';
        
        update_ban($id, $iprange, $reason);
    }
?>         
<form class="form-horizontal" action="" method="post">
                    <div class="card col-md-12 card-dark">
						<div class="card-header" >
							<h3 class="card-title"><?php
    echo esc_html__("Edit - IP Range Ban", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
										<div class="form-group">
											<label class="control-label"><?php
    echo esc_html__("IP Range:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="ip_range" class="form-control" type="text" maxlength="19" value="<?php
    echo esc_html($row->value);
?>" required>
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
echo esc_html__("IP Range Bans", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
						
<table id="dt-basic2" class="table table-striprangeed table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
						                  <th><i class="fas fa-user"></i> <?php
echo esc_html__("IP Range", "ezy_sc-text");
?></th>
										  <th><i class="fas fa-cog"></i> <?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $wpdb->get_results("SELECT * FROM `$table` WHERE type='ip_range'");
foreach ($query as $row) {
    echo '
										<tr>
						                    <td>' . esc_html($row->value) . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-bans&a=3&editiprange-id=' . esc_html($row->id) . '" class="btn btn-flat btn-primary"><i class="fas fa-edit"></i> ' . esc_html__("Edit", "ezy_sc-text") . '</a>
                                            <a href="admin.php?page=ezy_sc-bans&a=3&delete-id=' . esc_html($row->id) . '" class="btn btn-flat btn-success"><i class="fas fa-trash"></i> ' . esc_html__("Unban", "ezy_sc-text") . '</a>
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
							<h3 class="card-title"><?php
echo esc_html__("Ban IP Range", "ezy_sc-text");
?></h3>
						</div>
				        <div class="card-body">
						<form class="form-horizontal" action="" method="post">
										<div class="form-group">
											<label class="control-label"><?php
echo esc_html__("IP Range:", "ezy_sc-text");
?> </label>
											<div class="col-sm-12">
												<input name="ip_range" class="form-control" type="text" placeholder="Format: 12.34.56 or 1111:db8:3333:4444" maxlength="19" value="" required>
											</div>
										</div>
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-danger btn-block" name="ban-iprange" type="submit"><?php
echo esc_html__("Ban", "ezy_sc-text");
?></button>
				        </div>
				     </div>
				</div>
</form>
</div>