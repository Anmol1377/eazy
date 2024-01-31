<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_POST['ssave2'])) {
    
    if (isset($_POST['protection2'])) {
        $protection2 = 1;
    } else {
        $protection2 = 0;
    }
    
    if (isset($_POST['protection3'])) {
        $protection3 = 1;
    } else {
        $protection3 = 0;
    }
    
    if (isset($_POST['protection4'])) {
        $protection4 = 1;
    } else {
        $protection4 = 0;
    }
    
    if (isset($_POST['protection5'])) {
        $protection5 = 1;
    } else {
        $protection5 = 0;
    }
    
    if (isset($_POST['protection6'])) {
        $protection6 = 1;
    } else {
        $protection6 = 0;
    }
    
    update_option('wpg_sqli_protection2', $protection2);
    update_option('wpg_sqli_protection3', $protection3);
    update_option('wpg_sqli_protection4', $protection4);
    update_option('wpg_sqli_protection5', $protection5);
    update_option('wpg_sqli_protection6', $protection6);
    
}

if (isset($_POST['ssave'])) {
    
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
    
    if (isset($_POST['autoban'])) {
        $autoban = 1;
    } else {
        $autoban = 0;
    }
    
    if (isset($_POST['mail'])) {
        $mail = 1;
    } else {
        $mail = 0;
    }
    
    $redirect = sanitize_text_field($_POST['redirect']);
    
    update_option('wpg_sqli_protection', $protection);
    update_option('wpg_sqli_logging', $logging);
    update_option('wpg_sqli_autoban', $autoban);
    update_option('wpg_sqli_mail', $mail);
    update_option('wpg_sqli_redirect', $redirect);
}
?>
<div class="row">
				<div class="col-md-8">       	    
<?php
if (get_option('wpg_sqli_protection') == 1) {
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
echo esc_html__("SQL Injection", "ezy_sc-text");
?> - <?php
echo esc_html__("Protection Module", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body jumbotron">
<?php
if (get_option('wpg_sqli_protection') == 1) {
    echo '
        <h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", "ezy_sc-text") . '</h1>
        <p>' . esc_html__("The website is protected from", "ezy_sc-text") . ' <strong>' . esc_html__("SQL Injection Attacks (SQLi)", "ezy_sc-text") . '</strong></p>
';
} else {
    echo '
        <h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", "ezy_sc-text") . '</h1>
        <p>' . esc_html__("The website is not protected from", "ezy_sc-text") . ' <strong>' . esc_html__("SQL Injection Attacks (SQLi)", "ezy_sc-text") . '</strong></p>
';
}
?>
                        </div>
                    </div>
                    
                    <form class="form-horizontal form-bordered" action="" method="post">
                    
                        <div class="card col-md-12">
                        	<div class="card-header">
								<h3 class="card-title"><?php
echo esc_html__("Additional Protection Modules", "ezy_sc-text");
?></h3>
							</div>
							<div class="card-body">
                        	    <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5><?php
echo esc_html__("XSS Protection", "ezy_sc-text");
?></h5><hr />
                                        <?php
echo esc_html__("Sanitizes infected requests", "ezy_sc-text");
?>
                                        <br /><br /><br />
                                        
											<input type="checkbox" name="protection2" class="psec-switch" <?php
if (get_option('wpg_sqli_protection2') == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5><?php
echo esc_html__("Clickjacking Protection", "ezy_sc-text");
?></h5><hr />
                                        <?php
echo esc_html__("Detecting and blocking clickjacking attempts", "ezy_sc-text");
?>
                                        <br /><br />
                                        
											<input type="checkbox" name="protection3" class="psec-switch" <?php
if (get_option('wpg_sqli_protection3') == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5><?php
echo esc_html__("Hide PHP Information", "ezy_sc-text");
?></h5><hr />
                                        <?php
echo esc_html__("Hides the PHP version to remote requests", "ezy_sc-text");
?>
                                        <br /><br />
                                        
											<input type="checkbox" name="protection6" class="psec-switch" <?php
if (get_option('wpg_sqli_protection6') == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
								</div>
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5><?php
echo esc_html__("MIME Mismatch Attacks Protection", "ezy_sc-text");
?></h5><hr />
                                        <?php
echo esc_html__("Prevents attacks based on MIME-type mismatch", "ezy_sc-text");
?>
                                        <br /><br />
                                        
											<input type="checkbox" name="protection4" class="psec-switch" <?php
if (get_option('wpg_sqli_protection4') == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5><?php
echo esc_html__("Secure Connection", "ezy_sc-text");
?></h5><hr />
                                        <?php
echo esc_html__("Forces the website to use secure connection (HTTPS)", "ezy_sc-text");
?>
                                        <br /><br /><br />
                                        
											<input type="checkbox" name="protection5" class="psec-switch" <?php
if (get_option('wpg_sqli_protection5') == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
								</div>
                                    <center><button class="btn btn-flat btn-md btn-block btn-primary" name="ssave2" type="submit"><i class="fas fa-floppy"></i> <?php
echo esc_html__("Save", "ezy_sc-text");
?></button></center>
                        	</div>
                        </div>
                    
                    </form>
                </div>
                    
                <div class="col-md-4">
                     <div class="card col-md-12 card-dark">
                        	<div class="card-header" style="background-color:#8c52ff; color:white;">
								<h3 class="card-title"><?php
echo esc_html__("What is", "ezy_sc-text");
?> <?php
echo esc_html__("SQL Injection", "ezy_sc-text");
?></h3>
							</div>
							<div class="card-body">
                                <strong><?php
echo esc_html__("SQL Injection", "ezy_sc-text");
?></strong> <?php
echo esc_html__("is a technique where malicious users can inject SQL commands into an SQL statement, via web page input. Injected SQL commands can alter SQL statement and compromise the security of a web application.", "ezy_sc-text");
?>
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
if (get_option('wpg_sqli_protection') == 1) {
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
if (get_option('wpg_sqli_logging') == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted"><?php
echo esc_html__("Logging every threat of this type", "ezy_sc-text");
?></span>
										</li>
										<li class="list-group-item">
											<p><?php
echo esc_html__("AutoBan", "ezy_sc-text");
?></p>
														<input type="checkbox" name="autoban" class="psec-switch" <?php
if (get_option('wpg_sqli_autoban') == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted"><?php
echo esc_html__("Automatically ban anyone who is detected as this type of threat", "ezy_sc-text");
?></span>
										
										</li>
                                        <li class="list-group-item">
											<p><?php
echo esc_html__("Redirect URL", "ezy_sc-text");
?></p>
											<input name="redirect" class="form-control" type="text" value="<?php
echo get_option('wpg_sqli_redirect');
?>" required>
										</li>
									</ul>
                        	</div>
                            <div class="card-footer">
                                <button class="btn btn-flat btn-block btn-primary mar-top" name="ssave" type="submit"><i class="fas fa-floppy"></i> <?php
echo esc_html__("Save", "ezy_sc-text");
?></button>
                            </div>
</form>
                        </div>
                </div>
                
</div>