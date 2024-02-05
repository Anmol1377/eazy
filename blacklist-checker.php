<?php

// include_once 'ezy_sc_sub_module.php';

//  ;



if (!defined('ABSPATH')) {

    die('Page not found');

}

?>

<div class="row">

				<div class="col-md-12">

				    <div class="card card-dark col-md-12">

						<div class="card-header" style="background-color:#8c52ff; color:white;">

							<h3 class="card-title"><?php

echo esc_html__("IP Blacklist Checker", "ezy_sc-text");

?></h3>

						</div>

						<div class="card-body">

<form method="post" >

	<?php

echo esc_html__("IP Address:", "ezy_sc-text");

?> 

	<input type="text" class="form-control" name="ip" placeholder="1.2.3.4" required/><br /> 

	<input type="submit" class="btn btn-primary btn-block btn-flat" value="Lookup" />

</form>

                        </div>

                    </div>

					 

<?php

if (!empty($_POST['ip'])) {

    

    $ip = $_POST['ip'];

    

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {

        echo '<div class="callout callout-danger"><strong>' . esc_html__("The entered IP Address is invalid", "ezy_sc-text") . '</strong></div>';

    } else {

        

        set_time_limit(360);

        ini_set('max_execution_time', 300); //300 Seconds = 5 Minutes

        ini_set('memory_limit', '512M');

        

        $dnsbl_lookup = array(

            "all.s5h.net",

			"b.barracudacentral.org",

			"bl.spamcop.net",

			"blacklist.woody.ch",

			"bogons.cymru.com",

			"cbl.abuseat.org",

			"combined.abuse.ch",

			"db.wpbl.info",

			"dnsbl-1.uceprotect.net",

			"dnsbl-2.uceprotect.net",

			"dnsbl-3.uceprotect.net",

			"dnsbl.dronebl.org",

			"dnsbl.sorbs.net",

			"drone.abuse.ch",

			"duinv.aupads.org",

			"dul.dnsbl.sorbs.net",

			"dyna.spamrats.com",

			"http.dnsbl.sorbs.net",

			"ips.backscatterer.org",

			"ix.dnsbl.manitu.net",

			"korea.services.net",

			"misc.dnsbl.sorbs.net",

			"noptr.spamrats.com",

			"orvedb.aupads.org",

			"pbl.spamhaus.org",

			"proxy.bl.gweep.ca",

			"psbl.surriel.com",

			"relays.bl.gweep.ca",

			"relays.nether.net",

			"sbl.spamhaus.org",

			"singular.ttk.pte.hu",

			"smtp.dnsbl.sorbs.net",

			"socks.dnsbl.sorbs.net",

			"spam.abuse.ch",

			"spam.dnsbl.anonmails.de",

			"spam.dnsbl.sorbs.net",

			"spam.spamrats.com",

			"spambot.bls.digibase.ca",

			"spamrbl.imp.ch",

			"spamsources.fabel.dk",

			"ubl.lashback.com",

			"ubl.unsubscore.com",

			"virus.rbl.jp",

			"web.dnsbl.sorbs.net",

			"wormrbl.imp.ch",

			"xbl.spamhaus.org",

			"z.mailspike.net",

			"zen.spamhaus.org",

			"zombie.dnsbl.sorbs.net",

        );

        

        $AllCount = count($dnsbl_lookup);

        $BadCount = 0;

        

        $reverse_ip = implode(".", array_reverse(explode(".", $ip)));

        

        echo '<div class="card card-dark col-md-12">

			<div class="card-header">

				<h3 class="card-title">' . esc_html__("Results for", "ezy_sc-text") . ' <b>' . sanitize_text_field($_POST['ip']) . '</b></h3>

			</div>

			<div class="card-body">';

        

        echo '<div class="table-responsive"><table class="table table-bordered table-hover table-sm">

    <thead>

      <tr>

        <th><i class="fas fa-database"></i> ' . esc_html__("DNSBL", "ezy_sc-text") . '</th>

        <th><i class="fas fa-cogs"></i> ' . esc_html__("Reverse IP", "ezy_sc-text") . '</th>

        <th><i class="fas fa-info-circle"></i> <?php echo esc_html__("Status", "ezy_sc-text"); ?></th>

      </tr>

    </thead>

    <tbody>';

        

        foreach ($dnsbl_lookup as $host) {

            echo '<tr><td>' . esc_html($host) . '</td><td>' . esc_html($reverse_ip) . '.' . esc_html($host) . '</td>';

            if (checkdnsrr($reverse_ip . "." . $host . ".", "A")) {

                echo '<td><font class="badge badge-danger" size="13px"><i class="fas fa-times-circle"></i> Listed</font></td></tr>';

                $BadCount++;

            } else {

                echo '<td><font class="badge badge-success" size="13px"><i class="fas fa-check-circle"></i> Not Listed</font></td></tr>';

            }

        }

        

        echo '</tbody>

    </table></div><br />';

        

        echo esc_html__("Thе IP Address is listed in", "ezy_sc-text") . " " . esc_html($BadCount) . " " . esc_html__("blacklists of", "ezy_sc-text") . " " . esc_html($AllCount) . " " . esc_html__("total", "ezy_sc-text") . "<br/>";

        

        echo '</div></div></div>';

    }

} else {

    echo '</div>';

}

?>

</div>