<?php
include_once 'ezy_sc_sub_module.php';
//  ;


if (!defined('ABSPATH')) {
    die('Page not found');
}
?>
<div class="row">
				<div class="col-md-12">
				
				<div class="card col-md-12 card-dark">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("PHP Information", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
						    <div class="table-responsive">
<?php
ob_start();
phpinfo();
$pinfo = ob_get_contents();
ob_end_clean();

$pinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
echo '' . $pinfo;
?>
                            </div>
						</div>
			    </div>
				
</div>
</div>