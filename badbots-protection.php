<?php

// include_once 'ezy_sc_sub_module.php';

//  ;



if (!defined('ABSPATH')) {

    die('Page not found');

}



if (isset($_POST['bsave2'])) {

    

    if (isset($_POST['protection'])) {

        $protection = 1;

    } else {

        $protection = 0;

    }

    

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

    

    update_option('wpg_badbot_protection', $protection);

    update_option('wpg_badbot_protection2', $protection2);

    update_option('wpg_badbot_protection3', $protection3);

}



if (isset($_POST['bsave'])) {

    

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

    

    update_option('wpg_badbot_logging', $logging);

    update_option('wpg_badbot_autoban', $autoban);

    update_option('wpg_badbot_mail', $mail);

}

?>

<div class="row">

				<div class="col-md-8">

                    	    

<?php

if (get_option('wpg_badbot_protection') == 1 OR get_option('wpg_badbot_protection2') == 1 OR get_option('wpg_badbot_protection3') == 1) {

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

echo esc_html__("Bad Bots", "ezy_sc-text");

?> - <?php

echo esc_html__("Protection Module", "ezy_sc-text");

?></h3>

						</div>

						<div class="card-body jumbotron">

<?php

if (get_option('wpg_badbot_protection') == 1 OR get_option('wpg_badbot_protection2') == 1 OR get_option('wpg_badbot_protection3') == 1) {

    echo '

        <h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", "ezy_sc-text") . '</h1>

        <p>' . esc_html__("The website is protected from", "ezy_sc-text") . ' <strong>Bad Bots</strong></p>

';

} else {

    echo '

        <h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", "ezy_sc-text") . '</h1>

        <p>' . esc_html__("The website is not protected from", "ezy_sc-text") . ' <strong>Bad Bots</strong></p>

';

}

?>

                        </div>

                    </div>

                    

<form class="form-horizontal form-bordered" action="" method="post">

                        <div class="card col-md-12">

                        	<div class="card-header" style="background-color:#8c52ff; color:white;">

								<h3 class="card-title"><?php

echo esc_html__("Protection Modules", "ezy_sc-text");

?></h3>

							</div>

							<div class="card-body">

                        	    <div class="row">

                                    <div class="col-md-4">

                                        <div class="card card-body bg-light">

                                        <center>

                                        <h5><?php

echo esc_html__("Bad Bots", "ezy_sc-text");

?></h5><hr />

                                        <?php

echo balanceTags("Detects the <b>bad bots</b> and blocks their access to the website", "ezy_sc-text");

?>

                                        <br /><br />

                                        

											<input type="checkbox" name="protection" class="psec-switch" <?php

if (get_option('wpg_badbot_protection') == 1) {

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

echo esc_html__("Fake Bots", "ezy_sc-text");

?></h5><hr />

                                        <?php

echo balanceTags("Detects the <b>fake bots</b> and blocks their access to the website", "ezy_sc-text");

?>

                                        <br /><br />

                                        

											<input type="checkbox" name="protection2" class="psec-switch" <?php

if (get_option('wpg_badbot_protection2') == 1) {

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

echo esc_html__("Anonymous Bots", "ezy_sc-text");

?></h5><hr />

                                        <?php

echo balanceTags("Detects the <b>anonymous bots</b> and blocks their access to the website", "ezy_sc-text");

?><br />

                                        <br /><br />

                                        

											<input type="checkbox" name="protection3" class="psec-switch" <?php

if (get_option('wpg_badbot_protection3') == 1) {

    echo 'checked="checked"';

}

?> />

                                        </center>

                                        </div>

                                    </div>

								</div>

                                    <center><button class="btn btn-flat btn-md btn-block btn-primary mar-top" name="bsave2" type="submit"><i class="fas fa-floppy"></i> <?php

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

echo esc_html__("Bad Bot", "ezy_sc-text");

?></h3>

							</div>

							<div class="card-body">

                                <?php

echo balanceTags("<strong>Bad</strong>, <strong>Fake</strong> and <strong>Anonymous Bots</strong>", "ezy_sc-text");

?> <?php

echo esc_html__("are bots that consume bandwidth, slow down your server, steal your content and look for vulnerability to compromise your server.", "ezy_sc-text");

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

echo esc_html__("Logging", "ezy_sc-text");

?></p>

														<input type="checkbox" name="logging" class="psec-switch" <?php

if (get_option('wpg_badbot_logging') == 1) {

    echo 'checked="checked"';

}

?> /><br />

											<span class="text-muted"><?php

echo esc_html__("Logging every threat of this type", "ezy_sc-text");

?></span>

										</li>

										<li class="list-group-item">

											<p>AutoBan</p>

														<input type="checkbox" name="autoban" class="psec-switch" <?php

if (get_option('wpg_badbot_autoban') == 1) {

    echo 'checked="checked"';

}

?> /><br />

											<span class="text-muted"><?php

echo esc_html__("Automatically ban anyone who is detected as this type of threat", "ezy_sc-text");

?></span>

										

										</li>

									</ul>

                        	</div>

                            <div class="card-footer">

                                <button class="btn btn-flat btn-block btn-primary mar-top" name="bsave" type="submit"><i class="fas fa-floppy"></i> <?php

echo esc_html__("Save", "ezy_sc-text");

?></button>

                            </div>

</form>

                        </div>

                </div>

                

</div>