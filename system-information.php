<?php
//  ;
include_once 'ezy_sc_sub_module.php';

if (!defined('ABSPATH')) {
    die('Page not found');
}

//Clean URL
function clean_urlwpg($site)
{
    $site = strtolower($site);
    $site = str_replace(array(
        'http://',
        'https://',
        'www.'
    ), '', $site);
    return $site;
}

$site = clean_urlwpg(get_site_url());

//Host Info Check
function host_info($site)
{
    global $site_url;
	
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    
    $ip  = gethostbyname($site_url);
    $url = 'https://ipapi.co/' . $ip . '/json/';
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
    $ipcontent = curl_exec($ch);
    curl_close($ch);
    
    $ip_data = json_decode($ipcontent);
    if ($ip_data && !isset($ip_data->{'error'})) {
        $country = $ip_data->{'country_name'};
        $isp     = $ip_data->{'org'};
    } else {
        $country = "Unknown";
        $isp     = "Unknown";
    }
    
    if ($country == '') {
        $country = "Unknown";
    }
    
    if ($isp == '') {
        $isp = "Unknown";
    }
    
    $data = $ip . "::" . $country . "::" . $isp . "::";
    return $data;
}

// Response time
$ch_resptime = curl_init(get_site_url());
curl_setopt($ch_resptime, CURLOPT_RETURNTRANSFER,1);
if(curl_exec($ch_resptime)) {
	
	$curl_resptime = curl_getinfo($ch_resptime);
	$response_time = $curl_resptime['total_time'];
} else {
	$response_time = 0.01;
}

//Host Info
$data         = host_info($site);
$data         = explode("::", $data);
$host_ip      = $data[0];
$serverip     = getHostByName(getHostName());
$host_country = $data[1];
$host_isp     = $data[2];

$inipath = php_ini_loaded_file();

if ($inipath) {
    $iniflp = $inipath;
} else {
    $iniflp = esc_html__("A php.ini file is not loaded", "wpg_sc-text");
}

$zend_version = zend_version();

$errorlog_path = ini_get('error_log');
?>
<div class="row">
    <div class="col-md-6">
        <div class="card card-dark card-outline col-md-12">
            <div class="card-header" >
                <h3 class="card-title"><?php
echo esc_html($site);
?></h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr bgcolor="#F3F4F5">
                                <th><?php
echo esc_html__("Site Stats & Information", "wpg_sc-text");
?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php
echo esc_html__("Response Time", "wpg_sc-text");
?></td>
                                <td>
                                    <h5><span class="badge badge-success"><?php
echo esc_html($response_time);
?> sec</span></h5>
                                </td>
                            </tr>
                            <tr>
                                <td><?php
echo esc_html__("PHP Configuration File (php.ini)", "wpg_sc-text");
?></td>
                                <td>
                                    <h5><span class="badge badge-warning"><?php
echo esc_html($iniflp);
?></span></h5>
                                </td>
                            </tr>
                            <tr>
                                <td><?php
echo esc_html__("PHP Error Log", "wpg_sc-text");
?></td>
                                <td>
                                    <h5><span class="badge badge-warning"><?php
echo esc_html($errorlog_path);
?></span></h5>
                                </td>
                            </tr>
                            <tr>
                                <td><?php
echo esc_html__("Zend Version", "wpg_sc-text");
?></td>
                                <td>
                                    <h5><span class="badge badge-danger"><?php
echo esc_html($zend_version);
?></span></h5>
                                </td>
                            </tr>
                            <tr>
                                <td><?php
echo esc_html__("Default Timezone", "wpg_sc-text");
?></td>
                                <td>
                                    <h5><span class="badge badge-primary"><?php
echo date_default_timezone_get();
?></span></h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-dark card-outline col-md-12" style="
    position: absolute;
    margin-left: 50%;
    width: 50%;
" >



        <?php
$files   = 0;
$folders = 0;
$images  = 0;
$php     = 0;
$html    = 0;
$css     = 0;
$js      = 0;
$dir     = glob("../");
foreach ($dir as $obj) {
    if (is_dir($obj)) {
        $folders++;
        $scan = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($obj, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($scan as $file) {
            if (is_file($file)) {
                $files++;
                $exp = explode(".", $file);
                if (@array_search("png", $exp, $strict = FALSE) || @array_search("jpg", $exp, $strict = FALSE) || @array_search("svg", $exp, $strict = FALSE) || @array_search("jpeg", $exp, $strict = FALSE) || @array_search("gif", $exp, $strict = FALSE)) {
                    $images++;
                } else if (@array_search("php", $exp)) {
                    $php++;
                } else if (@array_search("html", $exp) || @array_search("htm", $exp)) {
                    $html++;
                } else if (@array_search("css", $exp)) {
                    $css++;
                } else if (@array_search("js", $exp)) {
                    $js++;
                }
            } else {
                $folders++;
            }
        }
    } else {
        $files++;
    }
}
?>
        <div class="row" >
            <div class="col-md-6">
                <div class="small-box bg-primary">
                    <div class="inner" style="padding:16px;">
                        <h3><?php
echo esc_html($files);
?></h3>
                        <p><?php
echo esc_html__("Files", "wpg_sc-text");
?></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-info">
                    <div class="inner" style="padding:16px;">
                        <h3><?php
echo esc_html($folders);
?></h3>
                        <p><?php
echo esc_html__("Folders", "wpg_sc-text");
?></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-folder"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="small-box bg-success">
                    <div class="inner" style="padding:16px;">
                        <h3><?php
echo esc_html($images);
?></h3>
                        <p><?php
echo esc_html__("Images", "wpg_sc-text");
?></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-image"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner" style="padding:16px;">
                        <h3><?php
echo esc_html($php);
?></h3>
                        <p><?php
echo esc_html__("PHP Files", "wpg_sc-text");
?></p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-php"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="small-box bg-info">
                    <div class="inner" style="padding:16px;">
                        <h3><?php
echo esc_html($html);
?></h3>
                        <p><?php
echo esc_html__("HTML Files", "wpg_sc-text");
?></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-code"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-success">
                    <div class="inner" style="padding:16px;">
                        <h3><?php
echo esc_html($css);
?></h3>
                        <p><?php
echo esc_html__("CSS Files", "wpg_sc-text");
?></p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-css3-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="small-box bg-warning">
                    <div class="inner" style="padding:16px;">
                        <h3><?php
echo esc_html($js);
?></h3>
                        <p><?php
echo esc_html__("JS Files", "wpg_sc-text");
?></p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-js"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (!function_exists("view_size")) {
    function view_size($size)
    {
        if (!is_numeric($size)) {
            return FALSE;
        } else {
            if ($size >= 1073741824) {
                $size = round($size / 1073741824 * 100) / 100 . " GB";
            } elseif ($size >= 1048576) {
                $size = round($size / 1048576 * 100) / 100 . " MB";
            } elseif ($size >= 1024) {
                $size = round($size / 1024 * 100) / 100 . " KB";
            } else {
                $size = $size . " B";
            }
            return $size;
        }
    }
}

if (is_callable("disk_free_space") && is_callable("disk_total_space")) {
    $storstat_disabled = 0;
	$directory = '/';
	
    @$total = disk_total_space($directory);
	@$free = disk_free_space($directory);
	
    if ($total === FALSE || $total <= 0) {
        $total = 0;
		$storstat_disabled = 1;
    }
	if ($free === FALSE || $free < 0) {
        $free = 0;
    }
	
    @$used = $total - $free;
    @$free_percent = round(100 / ($total / $free), 2);
    @$used_percent = round(100 / ($total / $used), 2);
?>

<div class="info-box bg-info" style="width:49.5%;">
    <span class="info-box-icon"><i class="fas fa-hdd"></i></span>

    <div class="info-box-content">
        <span class="info-box-text"><?php
    echo esc_html__("STORAGE", "wpg_sc-text");
?></span>
        <span class="info-box-number"><?php
    echo esc_html__("Total: ", "wpg_sc-text");
?> <?php
    echo view_size($total);
?></span>

        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?php
    echo $used_percent;
?>%"></div>
        </div>
        <span class="progress-description">
            <?php
    echo esc_html__("Used: ", "wpg_sc-text");
?> <span class="text-semibold"><?php
    echo view_size($used);
?> (<?php
    echo $used_percent;
?>%)</span>
            <?php
if ($storstat_disabled == 1) {
	echo '<br /><i>';
	echo esc_html__("Feature not available on this host.", "wpg_sc-text");
	echo '</i>';
}
?>
        </span>
    </div>
</div>

</div><br />
<?php
}
?>



<div class="col-md-12">
    <h3 class="mt-none"><?php
echo esc_html__("Host Information", "wpg_sc-text");
?></h3>
    <p><?php
echo esc_html__("System information about the web host", "wpg_sc-text");
?></p>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("Domain IP", "wpg_sc-text");
?></p>
                    <i class="fas fa-user fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
echo esc_html($serverip);
?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("Country", "wpg_sc-text");
?></p>
                    <i class="fas fa-globe fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
echo esc_html($host_country);
?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("Server Software", "wpg_sc-text");
?></p>
                    <i class="fas fa-database fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin">
                        <?php
$version = explode("/", $_SERVER['SERVER_SOFTWARE']);
$softNum = explode(" ", $version[1]);
$soft    = $version[0] . '/' . $softNum[0];
echo esc_html($soft);
?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("ISP", "wpg_sc-text");
?></p>
                    <i class="fas fa-tasks fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
echo esc_html($host_isp);
?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("Server OS", "wpg_sc-text");
?></p>
                    <i class="fas fa-desktop fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin">
                        <?php
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo 'Windows';
} elseif (PHP_OS === 'Linux') {
    echo 'Linux';
} elseif (PHP_OS === 'FreeBSD') {
    echo 'FreeBSD';
} elseif (PHP_OS === 'OpenBSD') {
    echo 'OpenBSD';
} elseif (PHP_OS === 'NetBSD') {
    echo 'NetBSD';
} elseif (PHP_OS === 'SunOS') {
    echo 'SunOS';
} elseif (PHP_OS === 'Unix') {
    echo 'Unix';
} elseif (PHP_OS === 'Darwin') {
    echo 'Darwin';
} elseif (PHP_OS === 'HP-UX') {
    echo 'HP-UX';
} elseif (PHP_OS === 'IRIX64') {
    echo 'IRIX64';
} elseif (PHP_OS === 'CYGWIN_NT-5.1') {
    echo 'CYGWIN';
} elseif (PHP_OS === 'GNU') {
    echo 'GNU';
} elseif (PHP_OS === 'DragonFly') {
    echo 'DragonFly';
} elseif (PHP_OS === 'MSYS_NT-6.1') {
    echo 'MSYS';
} else {
    echo 'Unknown';
}
?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("PHP Version", "wpg_sc-text");
?></p>
                    <i class="fas fa-file-code fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
echo phpversion();
?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("MySQL Version", "wpg_sc-text");
?></p>
                    <i class="fas fa-list-alt fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
$mysqlVersion = $wpdb->db_version();
echo esc_html($mysqlVersion);
?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("Server Port", "wpg_sc-text");
?></p>
                    <i class="fas fa-plug fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
echo esc_html($_SERVER['SERVER_PORT']);
?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("OpenSSL Version", "wpg_sc-text");
?></p>
                    <i class="fas fa-lock fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin">
                        <?php
if (!extension_loaded('openssl')) {
    echo '<font color="red">Deactivated</font>';
} else {
    echo str_replace("OpenSSL", "", OPENSSL_VERSION_TEXT);
}
?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("cURL Extension", "wpg_sc-text");
?></p>
                    <i class="fas fa-link fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin">
                        <?php
if (function_exists('curl_version')) {
    $values = curl_version();
    echo esc_html($values["version"]);
} else {
    echo '<font color="red">Disabled</font>';
}
?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("HTTP Protocol", "wpg_sc-text");
?></p>
                    <i class="fas fa-hdd fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
echo esc_html($_SERVER['SERVER_PROTOCOL']);
?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-uppercase mar-btm text-sm" size="20px"><?php
echo esc_html__("Gateway Interface", "wpg_sc-text");
?></p>
                    <i class="fas fa-sitemap fa-3x"></i>
                    <hr>
                    <p class="h4 text-thin"><?php
echo esc_html($_SERVER['GATEWAY_INTERFACE']);
?></p>
                </div>
            </div>
        </div>
    </div>