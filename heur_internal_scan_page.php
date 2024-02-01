<!-- div class="container" style="float:left;" -->
<?php
// include_once 'ezy_sc_sub_module.php';
//  ;

?>

<style>
#hover:hover {
    color: white;
}

.design {
    font-size: 14px;
    margin-right: 10px;
}

button {
    background: white;
    color: black;
    border: none;
}

button:hover {
    transform: scale(1.25);
    border: none;
    color: black;
}

#hover {
    color: black;
    margin-right: 20px;
    border: none;
}

.sumdetec:hover {
    color: black !important;
    transform: scale(1.25);
}
</style>


<div class="container-fluid">
    <!-- // echo '<table>';
        // echo '<tr>';
        // echo '<td><img src="' . plugins_url( 'EaZy Security_icon.png', __FILE__ ) . '" height="30px" width="30px" style="margin-right: 5px;"/></td>';
        // echo '<td><h2>EaZy Security Web Malware Scanner for WordPress (Plugin version 3.4.0.62)</h2></td>';
        // echo '</tr>';
        // echo '</table>';

        // echo "<script type='text/javascript' src='" . plugins_url( 'JS/bootstrap.bundle.min.js', __FILE__ ) . "'></script>\n"; -->

    <div class="row">
        <div class="col-md-12"
            style="background: white;height: 200px;border-radius: 9px;width: 100%;box-shadow:0px 0px 1px #212529;">
            <h3 class="text-muted"
                style=" background-color: #8c52ff;color: white!important;height: 45px;font-size: 23px;font-family: 'Poppins', sans-serif; margin-top:12px; padding: 6px 12px;">
                Internal Scanner <i style="font-size:15px;"> by</i> EaZy Security</h3>
            <p style="margin-bottom: 7px; font-size:15px">PHP, JS, CSS, and image files will all be scanned internally
                for malware. The file system is being scanned for viruses using heuristic methods. Our technique use
                heuristics to find unidentified infections. Note that because of its great sensitivity, it might also
                detect potentially safe code (False-Positive). Please get in touch with EaZy Security support via the
                plugin page to resolve the false positives or email :- contact@bikswee.com .</p>
            <p style="margin-top: 7px; font-size:15px">Press <b>Scan Now</b> to run internal scan</p>
            <hr>
        </div>
    </div>


    <div class="row"
        style="margin-top: 24px;background-color: white;padding: 16px 7px;border-radius: 9px;box-shadow:0px 0px 1px #212529;">
        <div class="col-md-8">
            <form action="<?php admin_url( 'admin.php?page=ezy_sc_scanner' ); ?>" method="post"
                style="background-color: #8c52ff;width: 100%;height: 45px;padding: 6px; ">
                <?php wp_nonce_field( /*action*/'ezy_sc_scanner-scan_url' ); ?>
                <input type="hidden" name="action" value="scan" />
                <!-- <style>.button-primary{background-color:#212529;}</style> -->
                <button type="button" class="button-primary btn-sm " aria-haspopup="true" aria-expanded="false"
                    id="run-internal-scanner" style="margin-left:10px; background-color:white; color:black; ">
                    <i class="fas fa-search fa-2x design"></i>
                    Scan Now
                </button>
                <button type="button" class="button-primary btn-sm " aria-haspopup="true" aria-expanded="false"
                    id="stop-internal-scanner" style="margin-left:10px; background-color:white; color:black;">
                    <i class="fas fa-ban fa-2x design"></i> Stop Scanner
                </button>

                <button type="button" class="button-primary btn-sm " aria-haspopup="true" aria-expanded="false"
                    id="get-scanner-report" style="margin-left:10px; background-color:white; color:black;">
                    <i class="fas fa-solid fa-arrow-down fa-2x design"></i>Download Report
                </button>
                <button type="button" classs="button-primary btn-sm" ria-haspopup="true" aria-expanded="false"
                    id="contactBtn"
                    style="margin-left:10px; background-color:white; padding:2px; border:0.5px solid #2271b1; border-radius:3px"
                    href="admin.php?page=ezy_sc-contactUs"><a href="admin.php?page=ezy_sc-contactUs"
                        style="color:black; font-size:13px;" classs="button-primary btn-sm" ria-haspopup="true"
                        aria-expanded="false"><i class="fas fa-solid fa-info design" style="margin-left:10px;"></i> <?php
echo esc_html__("Get Help!", "ezy_sc-text");?></a>
                </button>

                <div id="progress_bar" class="progress-bar progress-bar-info progress-bar-striped active"
                    role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                    style="margin-top: 10px;width:100%;display:none;">
                    <span style="width: 100%">Internal Scan Progress</span>
                </div>
            </form>
            <div class="form-group" style="margin-top: 5px;">
                <label for="log" style="margin-top:22px; margin-left:6px;">Scan Activity Log:</label>
                <textarea class="form-control" rows="5" cols="80" id="log" style="resize: none; "
                    data-role="none"></textarea>
            </div>
        </div>
    </div>
    <div class="pannel">
        <div class="row3"
            style="margin-top: 24px;background-color: white;padding: 15px 7px;border-radius: 9px; box-shadow:0px 0px 1px #212529;">
            <div id="progress-pane" style="display:none;">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs"
                    style="background-color: #8c52ff; padding: 9px 26px;">
                    <li class="active sumdetec" style="
    margin-left: 20px; background:white;"><a href="#summary" data-toggle="tab" style="color: black;"><span id="hover"
                                style="margin-left:10px;color:black;">Summary</span></a></li>
                   
                    <li class="active sumdetec" style="
    margin-left: 20px; background:white;"><a href="#detected" data-toggle="tab"
                            style="margin-left: 12px; color: black;"><span id="hover" style="color:black;">Detected
                                Threats</span></a></li>
                    <!-- li><a href="#ignored" data-toggle="tab">Ignored Threats</a></li -->
                </ul>
                <div id="report-tab-content" class="tab-content">
                    <div class="tab-pane active" id="summary">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading" style="padding:10px;">Execution Summary:</div>
                            <!-- Table -->
                            <table class="table">
                                <tr>
                                    <td>Scan Start Time:</td>
                                    <td>
                                        <div id="scan_start_time"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Scanned:</td>
                                    <td>
                                        <div id="total_scanned_files"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Clean Files:</td>
                                    <td>
                                        <div id="scanned_clean_files"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Potentially Suspicious Files:</td>
                                    <td>
                                        <div id="scanned_pos_suspicious_files"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Suspicious Files:</td>
                                    <td>
                                        <div id="scanned_suspicious_files"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Malicious Files:</td>
                                    <td>
                                        <div id="scanned_malicious_files"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="detected">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Detected Threats:</div>
                            <div id="detected_threats_report"></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="ignored">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Ignored Threats:</div>
                            <div id="ignored_threats_report"></div>
                        </div>
                    </div>
                </div> <!-- tab content -->
            </div>
        </div>

    </div>