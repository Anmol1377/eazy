<?php
include_once 'ezy_sc_sub_module.php';
//  ;

if (!defined('ABSPATH')) {
    die('Page not found');
}

function get_banned($ip)
{
    global $wpdb, $ip;
    
    $table = $wpdb->prefix . 'wpg_bans';
    $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE value = %s AND type = %s LIMIT 1", $ip, 'ip'));
    if ($count > 0) {
        return 1;
    } else {
        return 0;
    }
}

function get_bannedid($ip)
{
    global $wpdb, $ip;
    
    $table = $wpdb->prefix . 'wpg_bans';
    $row   = $wpdb->get_row($wpdb->prepare("SELECT id FROM $table
                    WHERE value = %s AND type = %s LIMIT 1", $ip, 'ip'));
    return $row->id;
}

if (isset($_GET['id'])) {
    $table  = $wpdb->prefix . 'wpg_logs';
    $id     = (int) $_GET["id"];
    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table` WHERE `id` = %d LIMIT 1", $id));
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-logs">';
        exit();
    }
    if ($result == 0) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-logs">';
        exit();
    }
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d LIMIT 1", $id));
?>
<div class="row">
				<div class="col-md-12">
				    <div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
    echo esc_html__("Log", "ezy_sc-text");
?> #<?php
    echo esc_html($row->id) . esc_html__(" - Details", "ezy_sc-text");
?></h3>
							<div class="float-sm-right">
							<?php
    if (get_banned($row->ip) == 1) {
        echo '
										    <a href="admin.php?page=ezy_sc-bans&delete-id=' . get_bannedid($row->ip) . '" class="btn btn-flat btn-success btn-sm"><i class="fas fa-ban"></i> ' . esc_html__("Unban", "ezy_sc-text") . '</a>
									        ';
    } else {
        echo '
										    <a href="admin.php?page=ezy_sc-bans&ip=' . esc_html($row->ip) . '&reason=' . esc_html($row->type) . '" class="btn btn-flat btn-warning btn-sm"><i class="fas fa-ban"></i> ' . esc_html__("Ban", "ezy_sc-text") . '</a>
									        ';
    }
    echo '
											<a href="admin.php?page=ezy_sc-logs&delete-id=' . esc_html($row->id) . '" class="btn btn-flat btn-danger btn-sm"><i class="fas fa-times"></i> ' . esc_html__("Delete", "ezy_sc-text") . '</a>
';
?>
							</div>
						</div>
						<div class="card-body">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                        <i class="fas fa-user"></i> <?php
    echo esc_html__("IP Address", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->ip);
?>" readonly>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                        <i class="fas fa-calendar"></i> <?php
    echo esc_html__("Date & Time", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo '' . esc_html($row->date) . ' at ' . esc_html($row->time) . '';
?>" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-globe"></i> <?php
    echo esc_html__("Browser", "ezy_sc-text");
?>
                                                    </label>
                                                    <div class="input-group mar-btm">
											            <span class="input-group-addon">
                                                            <img src="<?php echo esc_url(plugins_url('assets/img/icons/browser/'.esc_html($row->browser_code).'.png', __FILE__)); ?>" />
                                                        </span>
													   <input type="text" class="form-control" value="<?php
    echo esc_html($row->browser);
?>" readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-desktop"></i> <?php
    echo esc_html__("Operating System", "ezy_sc-text");
?>
                                                    </label>
                                                    <div class="input-group mar-btm">
											            <span class="input-group-addon">
                                                            <img src="<?php echo esc_url(plugins_url('assets/img/icons/os/'.esc_html($row->os_code).'.png', __FILE__)); ?>" />
                                                        </span>
                                                        <input type="text" class="form-control" value="<?php
    echo esc_html($row->os);
?>" readonly>
                                                    </div>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-flag"></i> <?php
    echo esc_html__("Country", "ezy_sc-text");
?>
                                                    </label>
                                                    <div class="input-group mar-btm">
											            <span class="input-group-addon">
                                                            <img src="<?php echo esc_url(plugins_url('assets/plugins/flags/blank.png', __FILE__)); ?>" class="flag flag-<?php
    echo strtolower(esc_html($row->country_code));
?>" alt="<?php
    echo esc_html($row->country);
?>" />
                                                        </span>
                                                        <input type="text" class="form-control" value="<?php
    echo esc_html($row->country);
?>" readonly>
                                                    </div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-map-pin"></i> <?php
    echo esc_html__("Region", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->region);
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-map"></i> <?php
    echo esc_html__("City", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->city);
?>" readonly>
												</div>
											</div>
                                            <div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-cloud"></i> <?php
    echo esc_html__("Internet Service Provider", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->isp);
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                        <i class="fas fa-bomb"></i> <?php
    echo esc_html__("Threat Type", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->type);
?>" readonly>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                        <i class="fas fa-ban"></i> <?php
    echo esc_html__("Banned", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    if (get_banned($row->ip) == 0) {
        echo 'No';
    } else {
        echo 'Yes';
    }
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-reply"></i> <?php
    echo esc_html__("Referer URL", "ezy_sc-text");
?>
                                                </label>
                                                <input type="text" class="form-control" value="<?php
    echo esc_html($row->referer_url);
?>" readonly>
                                            </div>
                                            </div>
                                            <div class="col-sm-8">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-user-secret"></i> <?php
    echo esc_html__("User Agent", "ezy_sc-text");
?>
                                                </label>
                                                <textarea placeholder="User Agent" rows="2" class="form-control" readonly><?php
    echo esc_html($row->useragent);
?></textarea>
                                            </div>
                                            </div>	
										</div>
                                        <hr>
                                        <div class="row">
											<div class="col-sm-4">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-file-alt"></i> <?php
    echo esc_html__("Attacked Page", "ezy_sc-text");
?>
                                                </label>
                                                <input type="text" class="form-control" value="<?php
    echo esc_html($row->page);
?>" readonly>
                                            </div>
                                            </div>	
                                            <div class="col-sm-8">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-code"></i> <?php
    echo esc_html__("Query used for the attack", "ezy_sc-text");
?>
                                                </label>
                                                <textarea placeholder="Query" rows="2" class="form-control" readonly><?php
    echo esc_html($row->query);
?></textarea>
                                            </div>
                                            </div>
										</div>

									</div>
                     </div>
                </div>
</div>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-logs">';
    exit();
}
?>