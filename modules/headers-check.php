<?php
//Anonymous Bots Protection
if (get_option('wpg_badbot_protection3') == 1) {
    
    //Detect Missing User-Agent Header
    if (empty($useragent)) {
        
        $type = "Missing User-Agent header";
        
        //Logging
        if (get_option('wpg_badbot_logging') == 1) {
            ezy_sc_logging($type);
        }
        
        //AutoBan
        if (get_option('wpg_badbot_autoban') == 1) {
            ezy_sc_autoban($type);
        }
        
        // //E-Mail Notification
        // if (get_option('wpg_mail_notifications') == 1 && get_option('wpg_badbot_mail')) {
        //     ezy_sc_mail($type);
        // }
        
        if ($actual_url != get_option('wpg_badbot_redirect') && $actual_url != (get_option('wpg_badbot_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_badbot_redirect') . '" />';
            exit;
        }
    }
    
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        
        $type = "Invalid IP Address header";
        
        //Logging
        if (get_option('wpg_badbot_logging') == 1) {
            ezy_sc_logging($type);
        }
        
        //AutoBan
        if (get_option('wpg_badbot_autoban') == 1) {
            ezy_sc_autoban($type);
        }
        
        // //E-Mail Notification
        // if (get_option('wpg_mail_notifications') == 1 && get_option('wpg_badbot_mail')) {
        //     ezy_sc_mail($type);
        // }
        
        if ($actual_url != get_option('wpg_badbot_redirect') && $actual_url != (get_option('wpg_badbot_redirect') . '/')) {
            echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_badbot_redirect') . '" />';
            exit;
        }
        
    }
}
?>