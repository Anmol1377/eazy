<?php
//Fake Bots Protection
if (get_option('wpg_badbot_protection2') == 1) {
    
    if ($fake_bot == 1) {
            
        $type = "Fake Bot";
            
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