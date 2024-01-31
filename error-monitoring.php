<?php
include_once 'ezy_sc_sub_module.php';
//  ;

if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_POST['ersave'])) {
    $ereporting = sanitize_text_field($_POST['erselect']);
    $derrors    = sanitize_text_field($_POST['deselect']);
    
    update_option('wpg_error_reporting', $ereporting);
    update_option('wpg_display_errors', $derrors);
}
?>
<div class="row">
				<div class="col-md-9">
				        <div class="card card-dark col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Settings", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
                            <form method="post">
							<div class="row">
							<div class="col-md-6">
							    <label><i class="fas fa-bug"></i> <?php
echo esc_html__("Error Reporting", "ezy_sc-text");
?></label>
								<select class="form-control" name="erselect" style="width: 100%;">
                                    <option value="1" <?php
if (get_option('wpg_error_reporting') == 1)
    echo 'selected="selected" ';
?>><?php
echo esc_html__("Turned Off", "ezy_sc-text");
?></option>
                                    <option value="2" <?php
if (get_option('wpg_error_reporting') == 2)
    echo 'selected="selected" ';
?>><?php
echo esc_html__("Report simple running errors", "ezy_sc-text");
?></option>
                                    <option value="3" <?php
if (get_option('wpg_error_reporting') == 3)
    echo 'selected="selected" ';
?>><?php
echo esc_html__("Report simple running errors + notices", "ezy_sc-text");
?></option>
                                    <option value="4" <?php
if (get_option('wpg_error_reporting') == 4)
    echo 'selected="selected" ';
?>><?php
echo esc_html__("Report all errors except notices", "ezy_sc-text");
?></option>
                                    <option value="5" <?php
if (get_option('wpg_error_reporting') == 5)
    echo 'selected="selected" ';
?>>Report all PHP errors</option>
                                </select>
								</div>
		                        <div class="col-md-6">
								<label><i class="fas fa-eye"></i> <?php
echo esc_html__("Errors Visibility", "ezy_sc-text");
?></label>
								<select class="form-control" name="deselect" width="100%">
                                    <option value="0" <?php
if (get_option('wpg_display_errors') == 0)
    echo 'selected="selected" ';
?>><?php
echo esc_html__("Hide Errors", "ezy_sc-text");
?></option>
									<option value="1" <?php
if (get_option('wpg_display_errors') == 1)
    echo 'selected="selected" ';
?>><?php
echo esc_html__("Display Errors", "ezy_sc-text");
?></option>
                                </select>
		                        </div>
								</div>
								<br />
		                        <input class="btn btn-primary btn-block btn-flat" type="submit" name="ersave" value="Save" />
		                    </form>
						</div>
						</div>
			    
				        <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Error Monitoring", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
<?php
$log_errors = ini_get('log_errors');

if (!$log_errors)
    echo '<p>' . esc_html__("Error Logging is disabled on your server", "ezy_sc-text") . '</p>';

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$error_log = ini_get('error_log');
$logs      = array(
    $error_log
);
$count     = 10000;
$lines     = array();

foreach ($logs as $log) {
    if (is_readable($log)) {
        $lines = array_merge($lines, last_lines($log, $count));
	}
}

$lines = array_map('trim', $lines);
$lines = array_filter($lines);

foreach ($lines as $key => $line) {
    if (false != strpos($line, ']'))
        list($time, $error) = explode(']', $line, 2);
    else
        list($time, $error) = array(
            '',
            $line
        );
    
    $time        = trim($time, '[]');
    $error       = trim($error);
    $lines[$key] = compact('time', 'error');
}
?>
        <table id="dt-basic" class="table table-bordered table-hover table-sm" cellspacing="0" width="100%">
        <thead>
			<tr>
				<th><i class="fas fa-calendar"></i> <?php
echo esc_html__("Date & Time", "ezy_sc-text");
?></th>
				<th><i class="fas fa-exclamation-circle"></i> <?php
echo esc_html__("Error", "ezy_sc-text");
?></th>
			</tr>
		</thead>
        <tbody>
        <?php
foreach ($lines as $line) {
    $error = esc_html($line['error']);
    $time  = esc_html($line['time']);
    
    if (!empty($error))
        echo ("<tr><td>{$time}</td><td>{$error}</td></tr>");
}
?>
            </tbody>
        </table> 
        <?php

// Compare callback for freeform date/time strings.
function time_field_compare($a, $b)
{
    if ($a == $b)
        return 0;
    return (strtotime($a['time']) > strtotime($b['time'])) ? -1 : 1;
}

// Reads lines from end of file. Memory-safe.
function last_lines($path, $line_count, $block_size = 512)
{
    $lines = array();
    
    // we will always have a fragment of a non-complete line
    // keep this in here till we have our next entire line.
    $leftover = '';
    
    $fh = fopen($path, 'r');
    // go to the end of the file
    fseek($fh, 0, SEEK_END);
    
    do {
        // need to know whether we can actually go back
        // $block_size bytes
        $can_read = $block_size;
        
        if (ftell($fh) <= $block_size)
            $can_read = ftell($fh);
        
        if (empty($can_read))
            break;
        
        // go back as many bytes as we can
        // read them to $data and then move the file pointer
        // back to where we were.
        fseek($fh, -$can_read, SEEK_CUR);
        $data = fread($fh, $can_read);
        $data .= $leftover;
        fseek($fh, -$can_read, SEEK_CUR);
        
        // split lines by \n. Then reverse them,
        // now the last line is most likely not a complete
        // line which is why we do not directly add it, but
        // append it to the data read the next time.
        $split_data = array_reverse(explode("\n", $data));
        $new_lines  = array_slice($split_data, 0, -1);
        $lines      = array_merge($lines, $new_lines);
        $leftover   = $split_data[count($split_data) - 1];
    } while (count($lines) < $line_count && ftell($fh) != 0);
    
    if (ftell($fh) == 0)
        $lines[] = $leftover;
    
    fclose($fh);
    // Usually, we will read too many lines, correct that here.
    return array_slice($lines, 0, $line_count);
}

?>
                              </div>
						   </div>
                        </div>
						<div class="col-md-3">
							<div class="card card-dark col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Information & Tips", "ezy_sc-text");
?></h3>
						</div>
						<div class="card-body">
									<?php
echo esc_html__("Logging errors is recommended best practice, even for production site. Checking those logs however might seem like a chore. The error monitoring brings all entries from error log on this page.", "ezy_sc-text");
?><br /><br />
                                    <ul>
                                    <li><?php
echo esc_html__("The log file is detected automatically from the configuration of the server", "ezy_sc-text");
?></li>
                                    <li><?php
echo esc_html__("Only the end of file is read - no memory overflow issues, safe for large logs", "ezy_sc-text");
?></li>
                                    <li><?php
echo esc_html__("Optimized to work card card-body bg-light even with very large log files", "ezy_sc-text");
?></li>    
                                    </ul>
                            </div>
						   </div>
						</div>
</div>
