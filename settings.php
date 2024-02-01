<?php

// include_once 'ezy_sc_sub_module.php';

//  ;



?>



<?php

if (!defined('ABSPATH')) {

    die('Page not found');

}



if (isset($_POST['save'])) {

    if (isset($_POST['mail_notifications'])) {

        $mail_notifications = 1;

    } else {

        $mail_notifications = 0;

    }

    

    update_option('wpg_mail_notifications', $mail_notifications);

    

    $redirectb  = sanitize_text_field($_POST['redirectb']);

    $redirectbc = sanitize_text_field($_POST['redirectbc']);

    $redirectbo = sanitize_text_field($_POST['redirectbo']);

    $redirectbb = sanitize_text_field($_POST['redirectbb']);

    $redirectbi = sanitize_text_field($_POST['redirectbi']);

    $redirectbr = sanitize_text_field($_POST['redirectbr']);

    

    update_option('wpg_banned_redirect', $redirectb);

    update_option('wpg_bannedc_redirect', $redirectbc);

    update_option('wpg_bannedo_redirect', $redirectbo);

    update_option('wpg_bannedb_redirect', $redirectbb);

    update_option('wpg_bannedi_redirect', $redirectbi);

    update_option('wpg_bannedr_redirect', $redirectbr);

}

?>

<div class="row">

                    

				<div class="col-md-12">

<form class="form-horizontal" method="post">

				    <div class="col-md-12 card card-dark">

						<div class="card-header" style="background-color:#8c52ff; color:white;">

							<h3 class="card-title"><i class="fas fa-cog"></i> <?php

echo esc_html__("Settings", "ezy_sc-text");

?></h3>

                            <div class="float-sm-right">

                                <button class="btn btn-flat btn-primary" name="save" type="submit"><?php

echo esc_html__("Save", "ezy_sc-text");

?></button>

                                <button type="reset" class="btn btn-flat btn-default"><?php

echo esc_html__("Reset", "ezy_sc-text");

?></button>

                            </div>

                        </div>

						<br />

										<div class="form-group">

											<label class="control-label"><?php

echo esc_html__("\"Banned\" Page URL", "ezy_sc-text");

?>: </label>

											<div class="col-sm-12">

												<input name="redirectb" class="form-control" type="url" value="<?php

echo get_option('wpg_banned_redirect');

?>" required>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label"><?php

echo esc_html__("\"Banned Country\" Page URL", "ezy_sc-text");

?>: </label>

											<div class="col-sm-12">

												<input name="redirectbc" class="form-control" type="url" value="<?php

echo get_option('wpg_bannedc_redirect');

?>" required>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label"><?php

echo esc_html__("\"Banned OS\" Page URL", "ezy_sc-text");

?>: </label>

											<div class="col-sm-12">

												<input name="redirectbo" class="form-control" type="url" value="<?php

echo get_option('wpg_bannedo_redirect');

?>" required>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label"><?php

echo esc_html__("\"Banned Browser\" Page URL", "ezy_sc-text");

?>: </label>

											<div class="col-sm-12">

												<input name="redirectbb" class="form-control" type="url" value="<?php

echo get_option('wpg_bannedb_redirect');

?>" required>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label"><?php

echo esc_html__("\"Banned ISP\" Page URL", "ezy_sc-text");

?>: </label>

											<div class="col-sm-12">

												<input name="redirectbi" class="form-control" type="url" value="<?php

echo get_option('wpg_bannedi_redirect');

?>" required>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label"><?php

echo esc_html__("\"Banned Referer\" Page URL", "ezy_sc-text");

?>: </label>

											<div class="col-sm-12">

												<input name="redirectbr" class="form-control" type="url" value="<?php

echo get_option('wpg_bannedr_redirect');

?>" required>

											</div>

										</div>

						</div>

                     </div>

					 </div>

</form>

