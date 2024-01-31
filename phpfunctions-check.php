<?php
include_once 'ezy_sc_sub_module.php';
//  ;


if (!defined('ABSPATH')) {
    die('Page not found');
}
?>
<div class="row">
				<div class="col-md-8">
							    <div class="card col-md-12">
								<div class="card-header">
								<ul class="nav nav-tabs card-header-tabs">
									<li class="nav-item active">
										<a href="#f1" data-toggle="tab" class="nav-link active text-center"><?php
echo esc_html__("Command Execution", "ezy_sc-text");
?></a>
									</li>
									<li class="nav-item">
										<a href="#f2" data-toggle="tab" class="nav-link text-center"><?php
echo esc_html__("PHP Code Execution", "ezy_sc-text");
?></a>
									</li>
									<li class="nav-item">
										<a href="#f3" data-toggle="tab" class="nav-link text-center"><?php
echo esc_html__("Information Disclosure", "ezy_sc-text");
?></a>
									</li>
									<li class="nav-item">
										<a href="#f4" data-toggle="tab" class="nav-link text-center"><?php
echo esc_html__("Filesystem Functions", "ezy_sc-text");
?></a>
									</li>
									<li class="nav-item">
										<a href="#f5" data-toggle="tab" class="nav-link text-center"><?php
echo esc_html__("Other", "ezy_sc-text");
?></a>
									</li>			
								</ul>
								</div>
								<div class="card-body">
								<div class="tab-content">
									<div id="f1" class="tab-pane fade active show">
									    <div class="card col-md-12 card-body bg-light"><?php
echo esc_html__("Executing commands and returning the complete output", "ezy_sc-text");
?></div><br />
										    <div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> exec &nbsp;&nbsp;
<?php
if (function_exists('exec')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Returns last line of commands output", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> passthru &nbsp;&nbsp;
<?php
if (function_exists('passthru')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Passes commands output directly to the browser", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> system &nbsp;&nbsp;
<?php
if (function_exists('system')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Passes commands output directly to the browser and returns last line", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> shell_exec &nbsp;&nbsp;
<?php
if (function_exists('shell_exec')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Returns commands output", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> popen &nbsp;&nbsp; 
<?php
if (function_exists('popen')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Opens read or write pipe to process of a command", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> proc_open &nbsp;&nbsp; 
<?php
if (function_exists('proc_open')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Similar to popen() but greater degree of control", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> pcntl_exec &nbsp;&nbsp; 
<?php
if (function_exists('pcntl_exec')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Executes a program", "ezy_sc-text");
?></pre></h5>
									    	</div>
									</div>
									
									<div id="f2" class="tab-pane fade">
										<div class="card col-md-12 card-body bg-light"><?php
echo esc_html__("Apart from eval there are other ways to execute PHP code: include/require can be used for remote code execution in the form of Local File Include and Remote File Include vulnerabilities", "ezy_sc-text");
?>.</div><br />
										    <div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> eval &nbsp;&nbsp; 
                                                <span class="badge badge-danger"><?php echo esc_html__("Not Disabled", "ezy_sc-text"); ?></span>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Evaluate a string as PHP code", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> assert &nbsp;&nbsp; 
<?php
if (function_exists('assert')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                 <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Identical to eval()", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> allow_url_fopen &nbsp;&nbsp; 
<?php
if (function_exists('allow_url_fopen')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("This option enables the URL-aware fopen wrappers that enable accessing URL object like files - File inclusion vulnerability", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> allow_url_include &nbsp;&nbsp; 
<?php
if (function_exists('allow_url_include')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("This option allows the use of URL-aware fopen wrappers with the following functions: include, include_once, require, require_once - File inclusion vulnerability", "ezy_sc-text");
?></pre></h5>
									    	</div>
									</div>
									
									<div id="f3" class="tab-pane fade">
									    <div class="card col-md-12 card-body bg-light"><?php
echo esc_html__("Most of these function calls are not sinks. But rather it maybe a vulnerability if any of the data returned is viewable to an attacker. If an attacker can see phpinfo() it is definitely a vulnerability", "ezy_sc-text");
?>.</div><br />
										    <div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> phpinfo &nbsp;&nbsp; 
<?php
if (function_exists('phpinfo')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                              
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Outputs information about PHP's configuration", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> expose_php &nbsp;&nbsp; 
<?php
if (function_exists('expose_php')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                  
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Adds your PHP version to the response headers and this could be used for security exploits", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> display_errors &nbsp;&nbsp; 
<?php
if (function_exists('display_errors')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Shows PHP errors to the client and this could be used for security exploits", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> display_startup_errors &nbsp;&nbsp; 
<?php
if (function_exists('display_startup_errors')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Shows PHP startup sequence errors to the client and this could be used for security exploits", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> posix_getlogin &nbsp;&nbsp; 
<?php
if (function_exists('posix_getlogin')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Return login name", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> posix_ttyname &nbsp;&nbsp; 
<?php
if (function_exists('posix_ttyname')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Determine terminal device name", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> getenv &nbsp;&nbsp; 
<?php
if (function_exists('getenv')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets the value of an environment variable", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> get_current_user &nbsp;&nbsp; 
<?php
if (function_exists('get_current_user')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets the name of the owner of the current PHP script", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> proc_get_status &nbsp;&nbsp; 
<?php
if (function_exists('proc_get_status')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Get information about a process opened by proc_open()", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> get_cfg_var &nbsp;&nbsp; 
<?php
if (function_exists('get_cfg_var')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets the value of a PHP configuration option", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> getcwd &nbsp;&nbsp; 
<?php
if (function_exists('getcwd')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets the current working directory", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> getmygid &nbsp;&nbsp; 
<?php
if (function_exists('getmygid')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Get PHP script owner's GID", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> getmyinode &nbsp;&nbsp; 
<?php
if (function_exists('getmyinode')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets the inode of the current script", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> getmypid &nbsp;&nbsp; 
<?php
if (function_exists('getmypid')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets PHP's process ID", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> getmyuid &nbsp;&nbsp; 
<?php
if (function_exists('getmyuid')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets PHP script owner's UID", "ezy_sc-text");
?></pre></h5>
									    	</div>
									</div>
									
									<div id="f4" class="tab-pane fade">
									    <div class="card col-md-12 card-body bg-light"><?php
echo esc_html__("According to RATS all filesystem functions in PHP are nasty. Some of these don't seem very useful to the attacker. Others are more useful than you might think. For instance if allow_url_fopen=On then a url can be used as a file path, so a call to copy(x, y); can be used to upload a PHP script anywhere on the system. Also if a website is vulnerable to a request send via GET everyone of those file system functions can be abused to channel and attack to another host through your server", "ezy_sc-text");
?>.</div><br />
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> chgrp &nbsp;&nbsp; 
<?php
if (function_exists('chgrp')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Changes file group", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> chmod &nbsp;&nbsp; 
<?php
if (function_exists('chmod')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Changes file mode", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> chown &nbsp;&nbsp; 
<?php
if (function_exists('chown')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Changes file owner", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> lchgrp &nbsp;&nbsp; 
<?php
if (function_exists('lchgrp')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Changes group ownership of symlink", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> lchown &nbsp;&nbsp; 
<?php
if (function_exists('lchown')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Changes user ownership of symlink", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> link &nbsp;&nbsp; 
<?php
if (function_exists('link')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Create a hard link", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> symlink &nbsp;&nbsp; 
<?php
if (function_exists('symlink')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Creates a symbolic link", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> tempnam &nbsp;&nbsp; 
<?php
if (function_exists('tempnam')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Create file with unique file name", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> touch &nbsp;&nbsp; 
<?php
if (function_exists('touch')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Sets access and modification time of file", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> ftp_get &nbsp;&nbsp; 
<?php
if (function_exists('ftp_get')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Downloads a file from the FTP server", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> ftp_nb_get &nbsp;&nbsp; 
<?php
if (function_exists('ftp_nb_get')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Read from filesystem", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> ftp_put &nbsp;&nbsp; 
<?php
if (function_exists('ftp_put')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Uploads a file to FTP server", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> ftp_nb_put &nbsp;&nbsp; 
<?php
if (function_exists('ftp_nb_put')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Stores a file on FTP server (non-blocking)", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> filegroup &nbsp;&nbsp; 
<?php
if (function_exists('filegroup')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets file group", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> fileinode &nbsp;&nbsp; 
<?php
if (function_exists('fileinode')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets file inode", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> fileowner &nbsp;&nbsp; 
<?php
if (function_exists('fileowner')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets file owner", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> fileperms &nbsp;&nbsp; 
<?php
if (function_exists('fileperms')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets file permissions", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> linkinfo &nbsp;&nbsp; 
<?php
if (function_exists('linkinfo')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gets information about a link", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> stat &nbsp;&nbsp; 
<?php
if (function_exists('stat')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gives information about a file", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> fstat &nbsp;&nbsp; 
<?php
if (function_exists('fstat')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gives information about a file", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> lstat &nbsp;&nbsp; 
<?php
if (function_exists('lstat')) {
    echo '<span class="badge badge-warning">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Gives information about a file or symbolic link", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> readlink &nbsp;&nbsp; 
<?php
if (function_exists('readlink')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Returns target of a symbolic link", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> bzopen &nbsp;&nbsp; 
<?php
if (function_exists('bzopen')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Opens a bzip2 compressed file", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> gzopen &nbsp;&nbsp; 
<?php
if (function_exists('gzopen')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Open gz-file", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> gzfile &nbsp;&nbsp; 
<?php
if (function_exists('gzfile')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Read entire gz-file into an array", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> readgzfile &nbsp;&nbsp; 
<?php
if (function_exists('readgzfile')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Output a gz-file", "ezy_sc-text");
?></pre></h5>
									    	</div>
									</div>
									
									<div id="f5" class="tab-pane fade">
									     <br />
										    <div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> extract &nbsp;&nbsp; 
<?php
if (function_exists('extract')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Opens the door for register_globals attacks", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> putenv &nbsp;&nbsp; 
<?php
if (function_exists('putenv')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Sets value of an environment variable", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> proc_nice &nbsp;&nbsp; 
<?php
if (function_exists('proc_nice')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Change the priority of current process", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> proc_terminate &nbsp;&nbsp; 
<?php
if (function_exists('proc_terminate')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Kills a process opened by proc_open", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> proc_close &nbsp;&nbsp; 
<?php
if (function_exists('proc_close')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Close a process opened by proc_open() and return the exit code of that process", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> apache_child_terminate &nbsp;&nbsp; 
<?php
if (function_exists('apache_child_terminate')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Terminate apache process after request", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> posix_kill &nbsp;&nbsp; 
<?php
if (function_exists('posix_kill')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Send a signal to a process", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> posix_setpgid &nbsp;&nbsp; 
<?php
if (function_exists('posix_setpgid')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Set process group id for job control", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> posix_setsid &nbsp;&nbsp; 
<?php
if (function_exists('posix_setsid')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Make current process a session leader", "ezy_sc-text");
?></pre></h5>
									    	</div>
											<div class="callout callout-default">
									    		<h5><i class="fas fa-code"></i> posix_setuid &nbsp;&nbsp; 
<?php
if (function_exists('posix_setuid')) {
    echo '<span class="badge badge-danger">' . esc_html__("Not Disabled", "ezy_sc-text") . '</span>';
} else {
    echo '<span class="badge badge-success">' . esc_html__("Disabled", "ezy_sc-text") . '</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" style="font-size: 14px;"><?php
echo esc_html__("Set UID of current process", "ezy_sc-text");
?></pre></h5>
									    	</div>
									</div>
								</div>
							    </div>
                        </div>
                </div>
                    
				<div class="col-md-4">
				     <div class="card col-md-12">
						<div class="card-header"style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("Information & Tips", "ezy_sc-text");
?></h3>
						</div>
				        <div class="card-body">
							  <?php
echo esc_html__("On this page you can see which vulnerable PHP Functions are enabled on your host.", "ezy_sc-text");
?><br />
				              <?php
echo esc_html__("If you decide you can disable them from the php.ini file on your host.", "ezy_sc-text");
?>	
                        </div>
				     </div>
                     <div class="card col-md-12">
						<div class="card-header" style="background-color:#8c52ff; color:white;">
							<h3 class="card-title"><?php
echo esc_html__("How to Disable PHP Functions", "ezy_sc-text");
?></h3>
						</div>
				        <div class="card-body">
							  <ol>
									<li><?php
echo esc_html__("Open the php.ini file of your website", "ezy_sc-text");
?></li>
									<li><?php
echo esc_html__("Find disable_functions variable and set it as follows for example", "ezy_sc-text");
?>: <br /><br /><pre class="breadcrumb" style="font-size: 14px;">disable_functions = exec,passthru,shell_exec,system,proc_open,popen</pre></li>
									<li><?php
echo esc_html__("Save and close the file. Restart the HTTPD Server (Apache)", "ezy_sc-text");
?></li>
				             </ol>		
                        </div>
				     </div>
				</div>
</div>