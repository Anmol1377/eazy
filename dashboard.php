<?php
// include_once 'ezy_sc_sub_module.php';
//  ;
//include_once 'login.php';
//session_start();
?>
<?php
 //session_start();
 //if(!isset($_SESSION['login'])){
 //    header("location: /admin.php?page=ezy_sc-login");
     // header("location: http://localhost/wordpress/wp-admin/admin.php?page=ezy_sc-login");
 //}
//session_abort();
?>
<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

// Delete outdated cache files
$now   = time();

$files = glob(plugin_dir_path(__FILE__) . "modules/cache/ip-details" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
$files = glob(plugin_dir_path(__FILE__) . "modules/cache/live-traffic" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
$files = glob(plugin_dir_path(__FILE__) . "modules/cache/proxy" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}

$table  = $wpdb->prefix . 'wpg_logs';

$tableb = $wpdb->prefix . 'wpg_bans';

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
?>
<h4 class="card-title"><?php
echo esc_html__("Today's Stats", "ezy_sc-text");
?></h4>
<?php
$date   = date_i18n("d F Y");
$count  = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND date = %s", 'SQLi', $date));
$count2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE date = %s AND type = %s OR type = %s OR type = %s OR type = %s OR type = %s", $date, 'Bad Bot', 'Fake Bot', 'Missing User-Agent header', 'Missing header Accept', 'Invalid IP Address header'));
$count3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND date = %s", 'Proxy', $date));
$count4 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE type = %s AND date = %s", 'Spammer', $date));
?>
<br />
<div class="row">

    <div class="col-sm-6 col-lg-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php
echo esc_html($count);
?></h3>
                <p><?php
echo esc_html__("SQLi Attacks", "ezy_sc-text");
?></p>
            </div>
            <div class="icon">
                <i class="fas fa-code"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?php
echo esc_html($count2);
?></h3>
                <p><?php
echo esc_html__("Bad Bots", "ezy_sc-text");
?></p>
            </div>
            <div class="icon">
                <i class="fas fa-robot"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?php
echo esc_html($count3);
?></h3>
                <p><?php
echo esc_html__("Proxies", "ezy_sc-text");
?></p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?php
echo esc_html($count4);
?></h3>
                <p><?php
echo esc_html__("Spammers", "ezy_sc-text");
?></p>
            </div>
            <div class="icon">
                <i class="fas fa-keyboard"></i>
            </div>
        </div>
    </div>
</div>

<br />
<h4 class="card-title"><?php
echo esc_html__("Overall Statistics", "ezy_sc-text");
?></h4><br />

<div class="row">
    <div class="col-lg-7">
        <div id="panel-network" class="card col-md-12">
            <div class="card-header">
                <h3 class="card-title"><?php
echo esc_html__("Statistics", "ezy_sc-text");
?></h3>
            </div>
            <div class="card-body">
                <canvas id="log-stats"></canvas>
            </div>
        </div>

    </div>
    <?php
$countm  = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE type = %s", 'SQLi'));
$countm2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE type = %s OR type = %s OR type = %s OR type = %s OR type = %s", 'Bad Bot', 'Fake Bot', 'Missing User-Agent header', 'Missing header Accept', 'Invalid IP Address header'));
$countm3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE type = %s", 'Proxy'));
$countm4 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE type = %s", 'Spammer'));
?>
    <div class="col-lg-5">
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body text-center">
                        <p class="text-uppercase mar-btm text-lg"><?php
echo esc_html__("SQL Injections", "ezy_sc-text");
?></p>
                        <i class="fas fa-code fa-2x"></i>
                        <hr>
                        <p class="h3 text-thin"><?php
echo esc_html($countm);
?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="card card-danger card-outline">
                    <div class="card-body text-center">
                        <p class="text-uppercase mar-btm text-lg"><?php
echo esc_html__("Bad Bots", "ezy_sc-text");
?></p>
                        <i class="fas fa-robot fa-2x"></i>
                        <hr>
                        <p class="h3 text-thin"><?php
echo esc_html($countm2);
?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <div class="card card-success card-outline">
                    <div class="card-body text-center">
                        <p class="text-uppercase mar-btm text-lg"><?php
echo esc_html__("Proxies", "ezy_sc-text");
?></p>
                        <i class="fas fa-globe fa-2x"></i>
                        <hr>
                        <p class="h3 text-thin"><?php
echo esc_html($countm3);
?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="card card-warning card-outline">
                    <div class="card-body text-center">
                        <p class="text-uppercase mar-btm text-lg"><?php
echo esc_html__("Spammers", "ezy_sc-text");
?></p>
                        <i class="fas fa-keyboard fa-2x"></i>
                        <hr>
                        <p class="h3 text-thin"><?php
echo esc_html($countm4);
?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card col-md-12 card-dark" >
    <div class="card-header" style="background-color:#8c52ff; color:white;">
        <h3 class="card-title"><?php
echo esc_html__("Modules & Functions", "ezy_sc-text");
?></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <h5><i class="fas fa-shield-alt"></i> &nbsp;<?php
echo esc_html__("Protection Modules", "ezy_sc-text");
?></h5>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <?php
echo balanceTags("<strong><i class=\"fas fa-code\"></i> SQLi</strong><br />Protection", "ezy_sc-text");
?>
                        <hr />
                        <?php
if (get_option('wpg_sqli_protection') == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <strong><i class="fas fa-robot"></i> <?php
echo esc_html__("Bad Bots", "ezy_sc-text");
?></strong><br /><?php
echo esc_html__("Protection", "ezy_sc-text");
?>
                        <hr />
                        <?php
if (get_option('wpg_badbot_protection') == 1 OR get_option('wpg_badbot_protection2') == 1 OR get_option('wpg_badbot_protection3') == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <strong><i class="fas fa-globe"></i> <?php
echo esc_html__("Proxy", "ezy_sc-text");
?></strong><br /><?php
echo esc_html__("Protection", "ezy_sc-text");
?><br />
                        <hr />
                        <?php
if (get_option('wpg_proxy_protection') > 1 OR get_option('wpg_proxy_protection2') == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <strong><i class="fas fa-keyboard"></i> <?php
echo esc_html__("Spam", "ezy_sc-text");
?></strong><br /><?php
echo esc_html__("Protection", "ezy_sc-text");
?><br />
                        <hr />
                        <?php
$tablesp = $wpdb->prefix . 'wpg_dnsbl';
$countsp = $wpdb->get_var("SELECT COUNT(*) FROM $tablesp");
if (get_option('wpg_spam_protection') == 1 && $countsp > 0) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <h5><i class="fas fa-list-ul"></i> &nbsp;<?php
echo esc_html__("Logging Settings", "ezy_sc-text");
?></h5>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <strong><i class="fas fa-code"></i> <?php
echo esc_html__("SQLi", "ezy_sc-text");
?></strong><br /><?php
echo esc_html__("Logging", "ezy_sc-text");
?>
                        <hr />
                        <?php
if (get_option('wpg_sqli_logging') == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <strong><i class="fas fa-robot"></i> <?php
echo esc_html__("Bad Bots", "ezy_sc-text");
?></strong><br /><?php
echo esc_html__("Logging", "ezy_sc-text");
?>
                        <hr />
                        <?php
if (get_option('wpg_badbot_logging') == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <strong><i class="fas fa-globe"></i> <?php
echo esc_html__("Proxy", "ezy_sc-text");
?></strong><br /><?php
echo esc_html__("Logging", "ezy_sc-text");
?> <br />
                        <hr />
                        <?php
if (get_option('wpg_proxy_logging') == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card col-md-12 card-body bg-light">
                    <center>
                        <strong><i class="fas fa-keyboard"></i> <?php
echo esc_html__("Spam", "ezy_sc-text");
?></strong><br /><?php
echo esc_html__("Logging", "ezy_sc-text");
?><br />
                        <hr />
                        <?php
if (get_option('wpg_spam_logging') == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ' . esc_html__("ON", "ezy_sc-text") . '</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> ' . esc_html__("OFF", "ezy_sc-text") . '</span></h4>
';
}
?>
                    </center>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <?php
$url = 'https://ipapi.co/8.8.8.8/json/';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60');
curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = json_decode($ipcontent);
if ($ip_data && !isset($ip_data->{'error'})) {
    $gstatus = '<font color="green">' . esc_html__("Online", "ezy_sc-text") . '</font>';
} else {
    $gstatus = '<font color="red">' . esc_html__("Offline", "ezy_sc-text") . '</font>';
}
?>
    <div class="col-md-6">
        <div class="info-box">
            <span class="info-box-icon" style="background-color:#8c52ff; color:white;"><i class="fas fa-globe"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?php
echo esc_html__("GeoIP API Status", "ezy_sc-text");
?></span>
                <span class="info-box-number" ><?php
echo balanceTags($gstatus);
?></span>
            </div>
        </div>
    </div>
    <?php
$proxy_check = 0;

if (get_option('wpg_proxy_protection') > 0) {
    $apik = 'wpg_proxy_api' . get_option('wpg_proxy_protection');
    $key  = get_option($apik);
}

if (get_option('wpg_proxy_protection') == 1) {
    //Invalid API Key ==> Offline
    $ch  = curl_init();
    $url = "http://v2.api.iphub.info";
    curl_setopt_array($ch, [
		CURLOPT_URL => $url,
		CURLOPT_CONNECTTIMEOUT => 30,
		CURLOPT_RETURNTRANSFER => true,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else if (get_option('wpg_proxy_protection') == 2) {
    
    $ch = curl_init('http://proxycheck.io/v2/8.8.8.8');
    $curl_options = array(
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $curl_options);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else if (get_option('wpg_proxy_protection') == 3) {
    //Invalid API Key ==> Offline
    $headers = [
		'X-Key: '.$key.'',
    ];
    $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else {
	$proxy_check = -1;
}

if ($proxy_check == 1) {
    $pstatus = '<font color="green">' . esc_html__("Online", "ezy_sc-text") . '</font>';
} else if ($proxy_check == 0) {
    $pstatus = '<font color="red">' . esc_html__("Offline", "ezy_sc-text") . '</font>';
} else {
	$pstatus = '<font color="red">' . esc_html__("Disabled", "ezy_sc-text") . '</font>';
}
?>
    <div class="col-md-6">
        <div class="info-box">
            <span class="info-box-icon" style="background-color:#8c52ff; color:white;"><i class="fas fa-cloud"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?php
echo esc_html__("Proxy API Status", "ezy_sc-text");
?></span>
                <span class="info-box-number"><?php
echo balanceTags($pstatus);
?></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card col-md-12 card-dark">
            <div class="card-header with-border" style="background-color:#8c52ff; color:white;">
                <h3 class="card-title"><?php
echo esc_html__("Recent Logs", "ezy_sc-text");
?></h3>
            </div>
            <div class="card-body">
                <?php
$rowm  = $wpdb->get_results("SELECT * FROM $table
                    ORDER BY id DESC LIMIT 2");
$count = $wpdb->get_var("SELECT COUNT(id) FROM $table
                    ORDER BY id DESC LIMIT 2");
if ($count > 0) {
    foreach ($rowm as $row) {
        echo '
							<h4 class="dashboardlb"><i class="fas fa-user pull-left"></i> ' . esc_html($row->ip) . '</h4>
													
							<div class="media">
                            <div class="media-body">

                                    <p><i class="fas fa-file-alt"></i> ' . esc_html__("Threat Type:", "ezy_sc-text") . '
';
        if ($row->type == 'SQLi') {
            echo '<button class="btn btn-sm btn-primary btn-flat"><i class="fas fa-code"></i> <b>' . esc_html($row->type) . '</b></button>';
        } elseif ($row->type == 'Bad Bot' || $row->type == 'Fake Bot' || $row->type == 'Missing User-Agent header' || $row->type == 'Missing header Accept' || $row->type == 'Invalid IP Address header') {
            echo '<button class="btn btn-sm btn-danger btn-flat"><i class="fas fa-robot"></i> <b>' . esc_html($row->type) . '</b></button>';
        } elseif ($row->type == 'Proxy') {
            echo '<button class="btn btn-sm btn-success btn-flat"><i class="fas fa-globe"></i> <b>' . esc_html($row->type) . '</b></button>';
        } elseif ($row->type == 'Spammer') {
            echo '<button class="btn btn-sm btn-warning btn-flat"><i class="fas fa-keyboard"></i> <b>' . esc_html($row->type) . '</b></button>';
        } else {
            echo '<button class="btn btn-sm btn-success btn-flat"><i class="fas fa-user-secret"></i> <b>' . esc_html__("Other", "ezy_sc-text") . '</b></button>';
        }
        echo '
		                    </p>
							<p><i class="fas fa-calendar"></i> ' . esc_html($row->date) . ' at ' . esc_html($row->time) . '</p>
							
                            </div>
							<p class="ml-3">
								<a href="admin.php?page=ezy_sc-logdetails&id=' . esc_html($row->id) . '" class="btn btn-sm btn-flat btn-block btn-primary"><i class="fas fa-tasks"></i> ' . esc_html__("Details", "ezy_sc-text") . '</a>
								<a href="admin.php?page=ezy_sc-logs&delete-id=' . esc_html($row->id) . '" class="btn btn-sm btn-flat btn-block btn-danger"><i class="fas fa-times"></i> ' . esc_html__("Delete", "ezy_sc-text") . '</a>       
                            </p>
                            </div>
							<hr>
';
    }
    echo '<center><a href="admin.php?page=ezy_sc-logs" class="btn btn-flat btn-block btn-primary"><i class="fas fa-search"></i> ' . esc_html__("View All", "ezy_sc-text") . '</a></center>';
} else {
    echo '<div class="callout callout-info"><p>' . balanceTags("There are no recent <b>Logs</b>", "ezy_sc-text") . '</p></div>';
}
?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card col-md-12 card-dark">
            <div class="card-header with-border" style="background-color:#8c52ff; color:white;">
                <h3 class="card-title"><?php
echo esc_html__("Recent IP Bans", "ezy_sc-text");
?></h3>
            </div>
            <div class="card-body">
                <?php
$rowb  = $wpdb->get_results("SELECT * FROM $tableb
                    WHERE type='ip' ORDER BY id DESC LIMIT 2");
$count = $wpdb->get_var("SELECT COUNT(id) FROM $tableb WHERE type='ip'");
if ($count > 0) {
    foreach ($rowb as $row) {
        echo '	
							<h4 class="dashboardlb"><i class="fas fa-user pull-left"></i> ' . esc_html($row->value) . '</h4>
													
							<div class="media">
                            <div class="media-body">

									<p><i class="fas fa-file-alt"></i> ' . esc_html($row->reason) . '</p>
									<p><i class="fas fa-calendar"></i> ' . esc_html($row->date) . ' at ' . esc_html($row->time) . '</p>

                                    <p>
                                        <button class="btn btn-sm btn-flat btn-danger"><i class="fas fa-magic"></i> ' . esc_html__("Autobanned", "ezy_sc-text") . ': <b>';
        if ($row->autoban == 1) {
            echo esc_html__("Yes", "ezy_sc-text");
        } else {
            echo esc_html__("No", "ezy_sc-text");
        }
        echo '</b></button>
                                    </p>
                            </div>
							<p class="ml-3">
                                        
										<a href="admin.php?page=ezy_sc-bans&editip-id=' . esc_html($row->id) . '" class="btn btn-sm btn-flat btn-block btn-primary"><i class="fas fa-edit"></i> ' . esc_html__("Edit", "ezy_sc-text") . '</a>
                            			<a href="admin.php?page=ezy_sc-bans&delete-id=' . esc_html($row->id) . '" class="btn btn-sm btn-flat btn-block btn-success"><i class="fas fa-trash"></i> ' . esc_html__("Unban", "ezy_sc-text") . '</a>
                                    </p>
                            </div>
							<hr />
';
    }
    echo '<center><a href="admin.php?page=ezy_sc-bans" class="btn btn-flat btn-block btn-primary"><i class="fas fa-search"></i> ' . esc_html__("View All", "ezy_sc-text") . '</a></center>';
} else {
    echo '<div class="callout callout-info"><p>' . balanceTags("There are no recent <b>IP Bans</b>", "ezy_sc-text") . '</p></div>';
}
?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card col-md-12 card-dark">
            <div class="card-header with-border" style="background-color:#8c52ff; color:white;">
                <h3 class="card-title"><?php
echo esc_html__("Statistics", "ezy_sc-text");
?></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr class="active">
                            <th><i class="fas fa-list"></i> <?php
echo esc_html__("Logs", "ezy_sc-text");
?></th>
                            <th><?php
echo esc_html__("Value", "ezy_sc-text");
?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$count = $wpdb->get_var("SELECT COUNT(id) FROM $table");
?>
                        <tr>
                            <td><?php
echo esc_html__("Total", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count);
?></td>
                        </tr>
                        <?php
$date2  = date_i18n('d F Y');
$count2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE date = %s", $date2));
?>
                        <tr>
                            <td><?php
echo esc_html__("Today", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count2);
?></td>
                        </tr>
                        <?php
$date3  = date_i18n('F Y');
$count3 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE date LIKE %s", "% $date3"));
?>
                        <tr>
                            <td><?php
echo esc_html__("This month", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count3);
?></td>
                        </tr>
                        <?php
$date4  = date_i18n('Y');
$count4 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE date LIKE %s", "% $date4"));
?>
                        <tr>
                            <td><?php
echo esc_html__("This year", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count4);
?></td>
                        </tr>
                    </tbody>
                    <thead class="thead-light">
                        <tr class="active">
                            <th><i class="fas fa-ban"></i> <?php
echo esc_html__("IP Bans", "ezy_sc-text");
?></th>
                            <th><?php
echo esc_html__("Value", "ezy_sc-text");
?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$count5 = $wpdb->get_var("SELECT COUNT(id) FROM $tableb WHERE type='ip'");
?>
                        <tr>
                            <td><?php
echo esc_html__("Total", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count5);
?></td>
                        </tr>
                        <?php
$date6  = date_i18n(get_option('date_format'));
$count6 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $tableb
                    WHERE date = %s AND type='ip'", $date6));
?>
                        <tr>
                            <td><?php
echo esc_html__("Today", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count6);
?></td>
                        </tr>
                        <?php
$date7  = date_i18n('F Y');
$count7 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $tableb
                    WHERE date LIKE %s AND type='ip'", "% $date7"));
?>
                        <tr>
                            <td><?php
echo esc_html__("This month", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count7);
?></td>
                        </tr>
                        <?php
$date8  = date_i18n('Y');
$count8 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $tableb
                    WHERE date LIKE %s AND type='ip'", "% $date8"));
?>
                        <tr>
                            <td><?php
echo esc_html__("This year", "ezy_sc-text");
?></td>
                            <td><?php
echo esc_html($count8);
?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card col-md-12 card-dark">
    <div class="card-header" style="background-color:#8c52ff; color:white;">
        <h3 class="card-title"><?php
echo esc_html__("Threats by Country", "ezy_sc-text");
?></h3>
    </div>
    <div class="card-body">
        <div class="col-md-12">

            <table id="dt-basicdb" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><i class="fas fa-globe"></i> <?php
echo esc_html__("Country", "ezy_sc-text");
?></th>
                        <th><i class="fas fa-bug"></i> <?php
echo esc_html__("Threats", "ezy_sc-text");
?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$countries = array(
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cape Verde",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombi",
    "Comoros",
    "Congo (Brazzaville)",
    "Congo",
    "Costa Rica",
    "Cote d\'Ivoire",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "East Timor (Timor Timur)",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia, The",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea, North",
    "Korea, South",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia and Montenegro",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Swaziland",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe",
    "Unknown"
);

foreach ($countries as $country) {
    $log_result = $wpdb->get_row($wpdb->prepare("SELECT country, country_code FROM `$table` WHERE `country` LIKE %s LIMIT 1", "%$country%"));
    $log_rows   = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table` WHERE `country` LIKE %s", "%$country%"));
    
    if ($log_rows > 0) {
        echo '<tr>';
        echo '<td><img src="'. esc_url(plugins_url('assets/plugins/flags/blank.png' , __FILE__)) .'" class="flag flag-' . strtolower($log_result->country_code) . '"/>&nbsp; ' . $country . '</td>';
        echo '<td>' . esc_html($log_rows) . '</td>';
        echo '</tr>';
    }
}
?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php
$wpgcustom_js4 = '
var barChartData = {
			labels: [';
$i             = 1;
while ($i <= 12) {
    $date = date_i18n('F', mktime(0, 0, 0, $i, 1));
    $wpgcustom_js4 .= "'$date'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
			],
			datasets: [{
				label: \'SQLi\',
				backgroundColor: \'#007bff\',
				stack: \'1\',
				data: [';
$i = 1;
while ($i <= 12) {
    $date   = date_i18n('F Y', mktime(0, 0, 0, $i, 1));
    $tcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE date LIKE %s AND type = %s", "%$date", 'SQLi'));
    $wpgcustom_js4 .= "'$tcount'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
				]
			}, {
				label: \'Bad Bot\',
				backgroundColor: \'#dc3545\',
				stack: \'2\',
				data: [';
$i = 1;
while ($i <= 12) {
    $date   = date_i18n('F Y', mktime(0, 0, 0, $i, 1));
    $tcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE date LIKE %s AND (type = %s OR type = %s OR type = %s OR type = %s OR type = %s)", "%$date", 'Bad Bot', 'Fake Bot', 'Missing User-Agent header', 'Missing header Accept', 'Invalid IP Address header'));
    $wpgcustom_js4 .= "'$tcount'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
				]
			}, {
				label: \'Proxies\',
				backgroundColor: \'#28a745\',
				stack: \'3\',
				data: [';
$i = 1;
while ($i <= 12) {
    $date   = date_i18n('F Y', mktime(0, 0, 0, $i, 1));
    $tcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE date LIKE %s AND type = %s", "%$date", 'Proxy'));
    $wpgcustom_js4 .= "'$tcount'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
				]
			}, {
				label: \'Spammers\',
				backgroundColor: \'#ffc107\',
				stack: \'4\',
				data: [';
$i = 1;
while ($i <= 12) {
    $date   = date_i18n('F Y', mktime(0, 0, 0, $i, 1));
    $tcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table
                    WHERE date LIKE %s AND type = %s", "%$date", 'Spammer'));
    $wpgcustom_js4 .= "'$tcount'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
				]
			}]

		};
		window.onload = function() {
			var ctx = document.getElementById(\'log-stats\').getContext(\'2d\');
			window.myBar = new Chart(ctx, {
				type: \'bar\',
				data: barChartData,
				options: {
					tooltips: {
						mode: \'index\',
						intersect: false
					},
					responsive: true,
					scales: {
						xAxes: [{
							stacked: true,
						}],
						yAxes: [{
							stacked: true
						}]
					}
				}
			});
		};
';
wp_register_script('ezy_sc-js4', '', [], '', true);
wp_enqueue_script('ezy_sc-js4');
wp_add_inline_script('ezy_sc-js4', $wpgcustom_js4);
?>