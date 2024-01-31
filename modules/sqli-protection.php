<?php
//SQLi Protection
if (get_option('wpg_sqli_protection') == 1) {
    
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	
    if (get_option('wpg_sqli_protection2') == 1) {
        //XSS Protection - Sanitize infected requests
        header("X-XSS-Protection: 1");
    }
    
    if (get_option('wpg_sqli_protection3') == 1) {
        //Clickjacking Protection
        header("X-Frame-Options: sameorigin");
    }
    
    if (get_option('wpg_sqli_protection4') == 1) {
        //Prevents attacks based on MIME-type mismatch
        header("X-Content-Type-Options: nosniff");
    }
    
    if (get_option('wpg_sqli_protection5') == 1) {
        //Force secure connection
        header("Strict-Transport-Security: max-age=15552000; preload");
    }
    
    if (get_option('wpg_sqli_protection6') == 1) {
        //Hide PHP Version
        header('X-Powered-By: Project SECURITY');
    }
    
    $query_string = $_SERVER['QUERY_STRING'];
    
    //Patterns, used to detect Malicous Request (SQL Injection)
    $patterns = array(
        "**/",
        "/**",
        "0x3a",
        "/*",
        "*/",
        "||",
        "' #",
        "or 1=1",
		"or%201=1",
        "'1'='1",
        "S@BUN",
        "`",
        "'",
        '"',
        "<",
        ">",
        "1,1",
        "1=1",
        "sleep(",
        "<?",
        "<?php",
        "?>",
        "../",
        "%0A",
        "%0D",
        "%3C",
        "%3E",
        "%00",
        "%2e%2e",
        "input_file",
        "path=.",
        "mod=.",
        "eval\(",
        "javascript:",
        "base64_",
        "boot.ini",
        "etc/passwd",
        "self/environ",
        "echo.*kae",
        "=%27$"
    );
    foreach ($patterns as $pattern) {
        if (strpos(strtolower($query_string), strtolower($pattern)) !== false) {
            
            $type = "SQLi";
            
            //Logging
            if (get_option('wpg_sqli_logging') == 1) {
                ezy_sc_logging($type);
            }
            
            //AutoBan
            if (get_option('wpg_sqli_autoban') == 1) {
                ezy_sc_autoban($type);
            }
            
            // //E-Mail Notification
            // if (get_option('wpg_mail_notifications') == 1 && get_option('wpg_sqli_mail')) {
            //     ezy_sc_mail($type);
            // }
            
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_sqli_redirect') . '" />';
            exit;
        }
    }
}
?>