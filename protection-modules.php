<?php
include_once 'ezy_sc_sub_module.php';
//  ;

?>

<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_GET['delete-id'])) {
    $id = (int) $_GET["delete-id"];
    
    $table2 = $wpdb->prefix . 'wpg_dnsbl';
    $wpdb->delete($table2, array(
        'id' => $id
    ));
}

$active = $active2 = $active3 = $active4 = $active5 = '';
$show   = $show2 = $show3 = $show4 = $show5 = '';

if (isset($_POST['ssave']) OR isset($_POST['ssave2'])) {
    $active = 'active';
    $show   = 'show ';
} else if (isset($_POST['bsave']) OR isset($_POST['bsave2'])) {
    $active2 = 'active';
    $show2   = 'show ';
} else if (isset($_POST['psave']) OR isset($_POST['psave2']) OR isset($_GET['api'])) {
    $active3 = 'active';
    $show3   = 'show ';
} else if (isset($_POST['spsave']) OR isset($_POST['add-database']) OR isset($_GET['delete-id'])) {
    $active4 = 'active';
    $show4   = 'show ';
} else {
    $active = 'active';
    $show   = 'show ';
}
?>
<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link <?php
echo esc_html($active);
?>" id="sqliprotection-tab" data-toggle="tab" href="#sqliprotection" role="tab" aria-controls="sqliprotection" aria-selected="true"><i class="fas fa-code"></i> <?php
echo esc_html__("SQLi Protection", "ezy_sc-text");
?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php
echo esc_html($active2);
?>" id="badbotsprotection-tab" data-toggle="tab" href="#badbotsprotection" role="tab" aria-controls="badbotsprotection" aria-selected="false"><i class="fas fa-user-secret"></i> <?php
echo esc_html__("Bad Bots Protection", "ezy_sc-text");
?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php
echo esc_html($active3);
?>" id="proxyprotection-tab" data-toggle="tab" href="#proxyprotection" role="tab" aria-controls="proxyprotection" aria-selected="false"><i class="fas fa-globe"></i> <?php
echo esc_html__("Proxy Protection", "ezy_sc-text");
?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php
echo esc_html($active4);
?>" id="spamprotection-tab" data-toggle="tab" href="#spamprotection" role="tab" aria-controls="spamprotection" aria-selected="false"><i class="fas fa-keyboard"></i> <?php
echo esc_html__("Spam Protection", "ezy_sc-text");
?></a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane <?php
echo esc_html($show) . ' ' . esc_html($active);
?>" id="sqliprotection" role="tabpanel" aria-labelledby="sqliprotection-tab">
<?php
include_once "sqli-protection.php";
?>
  </div>
  <div class="tab-pane <?php
echo esc_html($show2) . ' ' . esc_html($active2);
?>" id="badbotsprotection" role="tabpanel" aria-labelledby="badbotsprotection-tab">
<?php
include_once "badbots-protection.php";
?>
  </div>
  <div class="tab-pane <?php
echo esc_html($show3) . ' ' . esc_html($active3);
?>" id="proxyprotection" role="tabpanel" aria-labelledby="proxyprotection-tab">
<?php
include_once "proxy-protection.php";
?>
  </div>
  <div class="tab-pane <?php
echo esc_html($show4) . ' ' . esc_html($active4);
?>" id="spamprotection" role="tabpanel" aria-labelledby="spamprotection-tab">
<?php
include_once "spam-protection.php";
?>
  </div>
</div>
