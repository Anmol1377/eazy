<?php

if (!defined('ABSPATH')) {
    die('Page not found');
}
$table  = $wpdb->prefix . 'wpg_logs';
$count  = $wpdb->get_var("SELECT COUNT(*) FROM $table");
$table2 = $wpdb->prefix . 'wpg_bans';
$count2 = $wpdb->get_var("SELECT COUNT(*) FROM $table2");
?>
<h1>EaZy Security - <?php
echo esc_html($pagetitle);
?><a href="https://security.bikswee.com/doc/" target="_blank" style=" margin-left:30px; font-size:18px;">Visit Documentation</a></h1>



<?php
//  ;
?>
<style>
.stylish {
    color: black;
    background-color: white;
    font-size: 12px;
}
.stylish:hover{
    color:black;
    transform: scale(1.15);
}
</style>

<div id="welcome-panelwpg" class="welcome-panelwpg wpanelbg  "
    style="border-radius:5px; background-color:#8c52ff; font-size:12px;">
    <div class="welcome-panel-contentwpg">
        <center><br />
            <p style="display:block; padding:10px 10px; justify-content:space-evenly;">
            <a href="admin.php?page=ezy_sc" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-home fa-2x"></i> <?php
echo esc_html__("Dashboard", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-settings" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-cogs fa-2x"></i> <?php
echo esc_html__("Settings", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-modules" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-shield-alt fa-2x"></i> <?php
echo esc_html__("Protection Modules", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-logs" class="btn btn-app btn-primary stylish">
                    <span class="badge bg-primary" style="right:3px; top:3px; font-size: 12px;"></span>
                    <i class="fas fa-align-justify fa-2x" style="margin-top:0px;"></i> <?php
echo esc_html__("Logs", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-bans" class="btn btn-app btn-primary stylish">
                    <span class="badge bg-danger" style="right:3px; top:3px; font-size: 12px;"></span>
                    <i class="fas fa-ban fa-2x" style="margin-top:0px;"></i> <?php
echo esc_html__("Bans", "ezy_sc-text");
?>
                </a>
                <!-- <a href="admin.php?page=ezy_sc_wm_scanner" class="btn btn-app btn-primary">
                    <i class="fas fa-search fa-2x"></i> 
?>
                </a> -->
                <a href="admin.php?page=ezy_sc-scanner" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-search fa-2px"></i> <?php
echo esc_html__("Scan", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-whitelist" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-flag fa-2x"></i> <?php
echo esc_html__("Whitelist", "ezy_sc-text");
?>
                </a>


                <a href="admin.php?page=ezy_sc-systeminfo" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-info-circle fa-2x"></i> <?php
echo esc_html__("System Information", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-analytics" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-chart-line fa-2x"></i> <?php
echo esc_html__("Visit Analytics", "ezy_sc-text");
?>
                </a>

                <a href="admin.php?page=ezy_sc-hteditor" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-columns fa-2x"></i> <?php
echo esc_html__(".htaccess Editor", "ezy_sc-text");
?>
                </a>
                </a>
			<a href="edit.php?post_type=page&orderby=date&order=desc" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-file-alt fa-2x"></i> <?php
echo esc_html__("Warning Pages", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-seccheck" class="btn btn-app btn-primary stylish">
                    <i class="fab fa-php fa-2x"></i> <?php
echo esc_html__("PHP Security Check", "ezy_sc-text");
?>
			<a href="admin.php?page=ezy_sc-errormonitoring" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-exclamation-circle fa-2x"></i> <?php
echo esc_html__("Error Monitoring", "ezy_sc-text");
?>
                </a>
                </a>
                <a href="admin.php?page=ezy_sc-portscanner" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-search fa-2x"></i> <?php
echo esc_html__("Port Scanner", "ezy_sc-text");
?>
                </a>
                <a href="admin.php?page=ezy_sc-ipblacklistcheck" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-list fa-2x"></i> <?php
echo esc_html__("IP Blacklist Checker", "ezy_sc-text");
?>
                </a>



                <a href="admin.php?page=ezy_sc-loginhistory" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-history fa-2x"></i> <?php
echo esc_html__("Login History", "ezy_sc-text");
?></a>
                <a href="admin.php?page=ezy_sc-contactUs" class="btn btn-app btn-primary stylish">
                    <i class="fas fa-regular fa-user"></i> <?php
echo esc_html__("Contact Us!", "ezy_sc-text");
?>
                </a>
                

            </p>
        </center>
    </div>
</div>
<?php

// Check if the .htaccess file exists
if (file_exists(ABSPATH . '.htaccess') && !get_option('htaccess_lines_added')) {
    // Get the .htaccess file content
    $htaccess_content = file_get_contents(ABSPATH . '.htaccess');
    
    // Add the desired lines to the .htaccess file content
    $lines_to_add = "php_flag output_buffering on";
    $new_content = $lines_to_add . $htaccess_content;
    
    // Write the new content back to the .htaccess file
    file_put_contents(ABSPATH . '.htaccess', $new_content);

    // Store a flag to indicate that the plugin has run
    add_option('htaccess_lines_added', true);
}
?>