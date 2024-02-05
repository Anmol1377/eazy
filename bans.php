<?php

// include_once 'ezy_sc_sub_module.php';

//  ;

?>



<?php

if (!defined('ABSPATH')) {

    die('Page not found');

}



$table = $wpdb->prefix . 'wpg_bans';



$active = $active2 = $active3 = $active4 = '';

$show   = $show2 = $show3 = $show4 = '';



global $id, $date, $time, $reason;



if (isset($_GET['delete-all'])) {

    $wpdb->delete($table, array(

        'type' => 'ip'

    ));

}



if (isset($_GET['delete-id'])) {

    $id = (int) $_GET["delete-id"];

    

    $wpdb->delete($table, array(

        'id' => $id

    ));

}



if (isset($_GET['blacklist'])) {

    update_option('wpg_countryban_blacklist', "1");

}



if (isset($_GET['whitelist'])) {

    update_option('wpg_countryban_blacklist', "0");

}



function add_ban($btype, $bvalue, $date, $time, $reason)

{

    global $wpdb, $date, $time, $reason;

    

    $table = $wpdb->prefix . 'wpg_bans';

    

    $data   = array(

        'type' => $btype,

        'value' => $bvalue,

        'date' => $date,

        'time' => $time,

        'reason' => $reason

    );

    $format = array(

        '%s',

        '%s',

        '%s',

        '%s',

        '%s'

    );

    $wpdb->insert($table, $data, $format);

}



function update_ban($id, $bvalue, $reason)

{

    global $wpdb, $id, $reason;

    

    $table = $wpdb->prefix . 'wpg_bans';

    

    $data_update = array(

        'value' => $bvalue,

        'reason' => $reason

    );

    $data_where  = array(

        'id' => $id

    );

    $wpdb->update($table, $data_update, $data_where);

}



if (((isset($_GET['a']) && $_GET['a'] == 2)) OR isset($_POST['ban-country'])) {

    $active2 = 'active';

    $show2   = 'show ';

} else if (((isset($_GET['a']) && $_GET['a'] == 3)) OR isset($_POST['ban-iprange'])) {

    $active3 = 'active';

    $show3   = 'show ';

} else if (((isset($_GET['a']) && $_GET['a'] == 4)) OR isset($_POST['block'])) {

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

?>" id="ip-tab" data-toggle="tab" href="#ip" role="tab" aria-controls="ip" aria-selected="true"><i class="fas fa-user"></i> <?php

echo esc_html__("IP Bans", "ezy_sc-text");

?></a>

  </li>

  <li class="nav-item">

    <a class="nav-link <?php

echo esc_html($active2);

?>" id="country-tab" data-toggle="tab" href="#country" role="tab" aria-controls="country" aria-selected="false"><i class="fas fa-globe"></i> <?php

echo esc_html__("Country Bans", "ezy_sc-text");

?></a>

  </li>

  <li class="nav-item">

    <a class="nav-link <?php

echo esc_html($active3);

?>" id="iprange-tab" data-toggle="tab" href="#iprange" role="tab" aria-controls="iprange" aria-selected="false"><i class="fas fa-grip-horizontal"></i> <?php

echo esc_html__("IP Range Bans", "ezy_sc-text");

?></a>

  </li>

  <li class="nav-item">

    <a class="nav-link <?php

echo esc_html($active4);

?>" id="other-tab" data-toggle="tab" href="#other" role="tab" aria-controls="other" aria-selected="false"><i class="fas fa-desktop"></i> <?php

echo esc_html__("Other Bans", "ezy_sc-text");

?></a>

  </li>

</ul>

<div class="tab-content" id="myTabContent">

  <div class="tab-pane <?php

echo esc_html($show) . ' ' . esc_html($active);

?>" id="ip" role="tabpanel" aria-labelledby="ip-tab">

<?php

include_once "bans-ip.php";

?>

  </div>

  <div class="tab-pane <?php

echo esc_html($show2) . ' ' . esc_html($active2);

?>" id="country" role="tabpanel" aria-labelledby="country-tab">

<?php

include_once "bans-country.php";

?>

  </div>

  <div class="tab-pane <?php

echo esc_html($show3) . ' ' . esc_html($active3);

?>" id="iprange" role="tabpanel" aria-labelledby="iprange-tab">

<?php

include_once "bans-iprange.php";

?>

  </div>

  <div class="tab-pane <?php

echo esc_html($show4) . ' ' . esc_html($active4);

?>" id="other" role="tabpanel" aria-labelledby="other-tab">

<?php

include_once "bans-other.php";

?>

  </div>

</div>