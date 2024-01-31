<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_POST['add-database'])) {
    $table2   = $wpdb->prefix . 'wpg_dnsbl';
    $database = sanitize_text_field($_POST['database']);
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table2` WHERE `dnsbl_database` = %s LIMIT 1", $database));
    if ($validator > 0) {
    } else {
        $wpdb->insert($table2, array(
            'dnsbl_database' => $database
        ), array(
            '%s'
        ));
    }
}

if (isset($_POST['spsave'])) {
    
    if (isset($_POST['protection'])) {
        $protection = 1;
    } else {
        $protection = 0;
    }
    
    if (isset($_POST['logging'])) {
        $logging = 1;
    } else {
        $logging = 0;
    }
    
    if (isset($_POST['mail'])) {
        $mail = 1;
    } else {
        $mail = 0;
    }
    
    $redirect = sanitize_text_field($_POST['redirect']);
    
    update_option('wpg_spam_protection', $protection);
    update_option('wpg_spam_logging', $logging);
    update_option('wpg_spam_mail', $mail);
    update_option('wpg_spam_redirect', $redirect);
    
}
?>
<div class="row">
				<div class="col-md-8">
                    	    
<?php
$tablesp = $wpdb->prefix . 'wpg_dnsbl';
$countsp = $wpdb->get_var("SELECT COUNT(*) FROM $tablesp");
if (get_option('wpg_spam_protection') == 1 && $countsp > 0) {
    echo '
              <div class="card col-md-12 card-solid card-success">
';
} else {
    echo '
              <div class="card col-md-12 card-solid card-danger">
';
}
?>
						<div class="card-header">
							<h3 class="card-title"><?php
echo esc_html__("Spam", "ezy_sc-text");
?> - <?php
echo esc_html__("Protection Module", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body jumbotron">
<?php
if (get_option('wpg_spam_protection') == 1 && $countsp > 0) {
    echo '
        <h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", "ezy_sc-text") . '</h1>
        <p>' . esc_html__("The website is protected from", "ezy_sc-text") . ' <strong>' . esc_html__("Spammers", "ezy_sc-text") . '</strong></p>
';
} else {
    echo '
        <h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", "ezy_sc-text") . '</h1>
        <p>' . esc_html__("The website is not protected from", "ezy_sc-text") . ' <strong>' . esc_html__("Spammers", "ezy_sc-text") . '</strong></p>
';
}
?>
                        </div>
                    </div>
                    
                    <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Spam Databases (DNSBL)", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">

                                    <center><button data-target="#add" data-toggle="modal" class="btn btn-flat btn-primary btn-md"><i class="fas fa-plus-circle"></i> <?php
echo esc_html__("Add Spam Database (DNSBL)", "ezy_sc-text");
?></button></center>
                                    <br />
									
<form class="form-horizontal mb-lg" method="POST">
    <div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
										  <!--Modal header-->
										  <div class="modal-header bg-dark">
										  <h6 class="modal-title"><?php
echo esc_html__("Add Spam Database (DNSBL)", "ezy_sc-text");
?></h6>
										  <button data-dismiss="modal" class="close" type="button">
										  <span aria-hidden="true">&times;</span>
										  </button>
										  </div>
											<div class="modal-body">
												<div class="form-group" >
                                                        <label class="control-label"><?php
echo esc_html__("Spam Database (DNSBL):", "ezy_sc-text");
?></label>
														<div class="col-sm-12">
															<input type="text" class="form-control" name="database" required/>
														</div>
												</div>
											</div>
								            <!--Modal footer-->
				                            <div class="modal-footer">
												<div class="row">
													<div class="float-left">
									                    <input class="btn btn-flat btn-primary" name="add-database" type="submit" value="Add">
													</div>&nbsp;
                                                    <div class="float-right">
														<button data-dismiss="modal" class="btn btn-flat btn-default" type="button"><?php
echo esc_html__("Close", "ezy_sc-text");
?></button>
													</div>
												</div>
											</div>
										
									</div>
        </div>
    </div>
                                    </form>
									
<?php
if ($countsp > 3) {
	echo '<div class="callout callout-warning">
			' . esc_html__("It is NOT recommended to use more than ") . '<b>' . esc_html__("3 spam databases") . '</b>' . esc_html__(" because performance and accuracy could be affected in negative way.") . '
		  </div>';
}
?>
									
<div class="table-responsive">                
	<table class="table table-bordered table-hover table-sm" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><?php
echo esc_html__("DNSBL Database", "ezy_sc-text");
?></th>
											<th><?php
echo esc_html__("Actions", "ezy_sc-text");
?></th>
										</tr>
									</thead>
									<tbody>
<?php
$table2   = $wpdb->prefix . 'wpg_dnsbl';
$dnsbldbs = $wpdb->get_results("SELECT id, dnsbl_database FROM $table2");
foreach ($dnsbldbs as $rowd) {
    echo '
										<tr>
                                            <td>' . esc_html($rowd->dnsbl_database) . '</td>
											<td>
                                            <a href="admin.php?page=ezy_sc-modules&delete-id=' . esc_html($rowd->id) . '" class="btn btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> ' . esc_html__("Delete", "ezy_sc-text") . '</a>
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
                    
                <div class="col-md-4">
                     <div class="card col-md-12 card-dark">
                        	<div class="card-header" style="background-color:#8c52ff; color:white;">
								<h3 class="card-title"><?php
echo esc_html__("What is", "ezy_sc-text");
?> Spam & DNSBL</h3>
							</div>
							<div class="card-body">
                                <strong><?php
echo esc_html__("Electronic Spamming", "ezy_sc-text");
?></strong> <?php
echo esc_html__("is the use of electronic messaging systems to send unsolicited messages (spam), especially advertising, as card card-body bg-light as sending messages repeatedly on the same site.", "ezy_sc-text");
?>
                                <br /><br />
                                <?php
echo balanceTags("A <strong>DNS-based Blackhole List (DNSBL)</strong> or <strong>Real-time Blackhole List (RBL)</strong>", "ezy_sc-text");
?> <?php
echo esc_html__("is a list of IP addresses which are most often used to publish the addresses of computers or networks linked to spamming.", "ezy_sc-text");
?><br /><br />
                                    
                                <?php
echo balanceTags("All <strong>Blacklists</strong> can be found here", "ezy_sc-text");
?>: <strong><a href="https://www.dnsbl.info/dnsbl-list.php" target="_blank">https://www.dnsbl.info/dnsbl-list.php</a></strong>
                        	</div>
                     </div>
                     <div class="card col-md-12 card-dark">
                        	<div class="card-header" style="background-color:#8c52ff; color:white;">
								<h3 class="card-title"><?php
echo esc_html__("Module Settings", "ezy_sc-text");
?></h3>
							</div>
							<div class="card-body">
									<ul class="list-group">
<form class="form-horizontal form-bordered" action="" method="post">
										<li class="list-group-item">
											<p><?php
echo esc_html__("Protection", "ezy_sc-text");
?></p>
														<input type="checkbox" name="protection" class="psec-switch" <?php
if (get_option('wpg_spam_protection') == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted"><?php
echo esc_html__("If this protection module is enabled all threats of this type will be blocked", "ezy_sc-text");
?></span>
										</li>
										<li class="list-group-item">
											<p><?php
echo esc_html__("Logging", "ezy_sc-text");
?></p>
														<input type="checkbox" name="logging" class="psec-switch" <?php
if (get_option('wpg_spam_logging') == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted"><?php
echo esc_html__("Logging every threat of this type", "ezy_sc-text");
?></span>
										
										</li>
                                        <li class="list-group-item">
											<p><?php
echo esc_html__("Redirect URL", "ezy_sc-text");
?></p>
											<input name="redirect" class="form-control" type="text" value="<?php
echo get_option('wpg_spam_redirect');
?>" required>
										</li>
									</ul>
                        	</div>
                            <div class="card-footer">
                                <button class="btn btn-flat btn-block btn-primary mar-top" name="spsave" type="submit"><i class="fas fa-floppy"></i> <?php
echo esc_html__("Save", "ezy_sc-text");
?></button>
                            </div>
</form>
                        </div>
                </div>
                
</div>