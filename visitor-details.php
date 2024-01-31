<?php
include_once 'ezy_sc_sub_module.php';
//  ;


if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_GET['id'])) {
    $table  = $wpdb->prefix . 'wpg_livetraffic';
    $id     = (int) $_GET["id"];
    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table` WHERE `id` = %d LIMIT 1", $id));
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-analytics">';
        exit();
    }
    if ($result == 0) {
        echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-analytics">';
        exit();
    }
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d LIMIT 1", $id));
?>
<div class="row">
				<div class="col-md-12">
				    <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
    echo esc_html__("Details for Visit", "ezy_sc-text");
?> #<?php
    echo esc_html($row->id);
?></h3>
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
                                                        <i class="fas fa-calendar-alt"></i> <?php
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
                                                         <i class="fas fa-map"></i> <?php
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
    echo esc_html__("Country Code", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->country_code);
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-mobile-alt"></i> <?php
    echo esc_html__("Device Type", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->device_type);
?>" readonly>
												</div>
											</div>
                                            <div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">
                                                         <i class="fas fa-link"></i> <?php
    echo esc_html__("Visited Page", "ezy_sc-text");
?>
                                                    </label>
													<input type="text" class="form-control" value="<?php
    echo esc_html($row->request_uri);
?>" readonly>
												</div>
											</div>
										</div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                            <div class="form-group">
												<label class="control-label">
                                                    <i class="fas fa-robot"></i> <?php
    echo esc_html__("Bot", "ezy_sc-text");
?>
                                                </label>
                                                <input type="text" class="form-control" value="
<?php
    if ($row->bot == 1) {
        echo 'Yes';
    } else {
        echo 'No';
    }
?>
												" readonly>
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
										<div class="row">
											<div class="col-sm-12">
											    <label class="control-label">
                                                    <i class="fas fa-reply"></i> <?php
    echo esc_html__("Referer URL", "ezy_sc-text");
?>
                                                </label>
                                                <input type="text" class="form-control" value="<?php
    echo esc_html($row->referer);
?>" readonly>
											</div>
										</div>

									</div>
                     </div>
                </div>
</div>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=admin.php?page=ezy_sc-analytics">';
    exit();
}
?>