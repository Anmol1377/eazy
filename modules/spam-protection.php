<?php
//Spam Protection
if (get_option('wpg_spam_protection') == 1) {
    
    $dnsbl_lookup = array();
    $table        = $wpdb->prefix . 'wpg_dnsbl';
    $dnsbldbs     = $wpdb->get_results("SELECT dnsbl_database FROM $table");
    foreach ($dnsbldbs as $row) {
        
        $dnsbl_lookup[] = $row->dnsbl_database;
        $reverse_ip     = implode(".", array_reverse(explode(".", $ip)));
        
        foreach ($dnsbl_lookup as $host) {
            if (checkdnsrr($reverse_ip . "." . $host . ".", "A")) {
                
                $type = "Spammer";
                
                //Logging
                if (get_option('wpg_spam_logging') == 1) {
                    ezy_sc_logging($type);
                }
                
                // //E-Mail Notification
                // if (get_option('wpg_mail_notifications') == 1 && get_option('wpg_spam_mail')) {
                //     ezy_sc_mail($type);
                // }
                
                if ($actual_url != get_option('wpg_spam_redirect') && $actual_url != (get_option('wpg_spam_redirect') . '/')) {
                    echo '<meta http-equiv="refresh" content="0;url=' . get_option('wpg_spam_redirect') . '" />';
                    exit;
                }
            }
        }
    }
}
?>