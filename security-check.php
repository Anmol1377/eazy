<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}
?>
<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="phpfunctions-tab" data-toggle="tab" href="#phpfunctions" role="tab" aria-controls="phpfunctions" aria-selected="true"><i class="fas fa-check"></i> <?php
echo esc_html__("PHP Functions", "ezy_sc-text");
?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="phpconfig-tab" data-toggle="tab" href="#phpconfig" role="tab" aria-controls="phpconfig" aria-selected="false"><i class="fab fa-php"></i> <?php
echo esc_html__("PHP Configuration", "ezy_sc-text");
?></a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane show active" id="phpfunctions" role="tabpanel" aria-labelledby="phpfunctions-tab">
<?php
include_once "phpfunctions-check.php";
?>
  </div>
  <div class="tab-pane" id="phpconfig" role="tabpanel" aria-labelledby="phpconfig-tab">
<?php
include_once "phpconfig-check.php";
?>
  </div>
</div>