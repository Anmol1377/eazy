<?php

// include_once 'ezy_sc_sub_module.php';



if (!defined('ABSPATH')) {

    die('Page not found');

}



if (isset($_POST['ht-edit'])) {

    

    $fn = "../.htaccess";

    chmod($fn, 0777);

    $file = fopen($fn, "w+");

    fwrite($file, $_POST['htaccess']);

    fclose($file);

}



$htaccess = "../.htaccess";

if (!file_exists($htaccess)) {

    echo '<div class="callout callout-info">

			  <strong>.htaccess</strong> ' . esc_html__("file was not found on your website and will now be created in the website's root folder", "ezy_sc-text") . ' - <strong>' . $htaccess . '</strong> .

          </div>';

    $content = "";

    chmod($htaccess, 0777);

    $fp = fopen($htaccess, "w+");

    fwrite($fp, $content);

    fclose($fp);

}

?>

<div class="row">

				<div class="col-md-9">

				    <div class="card card-dark col-md-12">

						<div class="card-header" style="background-color:#8c52ff; color:white;">

							<h3 class="card-title"><?php

echo esc_html__(".htaccess Editor", "ezy_sc-text");

?></h3>

						</div>

						<div class="card-body">

                            <form method="post">

							<div class="row">

                                    <div class="col-md-8">

                                        <textarea class="form-control" name="htaccess" rows="20" type="text"><?php

$htaccess = "../.htaccess";

chmod($htaccess, 0777);

echo file_get_contents($htaccess);

?></textarea>

                                    </div>

                                    <div class="col-md-4">

                                    <p><?php

echo esc_html__("Please double check them before saving as a mistake could make your website inaccessible.", "ezy_sc-text");

?></p>

                                     <ul class="description">

                                         <li><a href="https://www.google.com/search?q=htaccess+tutorial" title="Search for htaccess tutorials" target="_blank">

                                             <img width="16px" src="http://google.com/favicon.ico" alt="google favicon"> htaccess tutorial</a>

                                         </li>

                                         <li><a href="https://httpd.apache.org/docs/current/howto/htaccess.html" title="Read about htaccess at apache.org" target="_blank">

                                             <img width="16px" src="http://apache.org/favicon.ico" alt="apache favicon"> htaccess</a>

                                         </li>

                                         <li><a href="https://httpd.apache.org/docs/current/mod/mod_rewrite.html" title="Read about mod_rewrite at apache.org" target="_blank">

                                             <img width="16px" src="https://apache.org/favicon.ico" alt="apache favicon"> mod_rewrite</a>

                                         </li>

                                     </ul>

                                    </div>

									</div>

                        </div>

                        <div class="card-footer text-right">

				            <input class="btn btn-flat btn-primary" type="submit" name="ht-edit" value="Save all changes">

				        </div>

                        </form>

                     </div>

					 <div class="card card-dark col-md-12">

						<div class="card-header" style="background-color:#8c52ff; color:white;">

							<h3 class="card-title"><?php

echo esc_html__("Common Usage", "ezy_sc-text");

?></h3>

						</div>

				        <div class="card-body">

<ul>

<li>• <strong><?php

echo esc_html__("Authorization, authentication", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__("A .htaccess file is often used to specify security restrictions for a directory, hence the filename \"access\". The .htaccess file is often accompanied by a .htpasswd file which stores valid usernames and their passwords.", "ezy_sc-text");

?>

<li>• <strong><?php

echo esc_html__("Rewriting URLs", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__("Servers often use .htaccess to rewrite long, overly comprehensive URLs to shorter and more memorable ones.", "ezy_sc-text");

?>

<li>• <strong><?php

echo esc_html__("Blocking", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__("Use allow/deny to block users by IP address or domain. Also, use to block bad bots, rippers and referrers. Often used to restrict access by Search Engine spiders", "ezy_sc-text");

?>

<li>• <strong><?php

echo esc_html__("SSI", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__("Enable server-side includes.", "ezy_sc-text");

?>

<li>• <strong><?php

echo esc_html__("Directory listing", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__("Control how the server will react when no specific web page is specified.", "ezy_sc-text");

?>

    <li>• <strong><?php

echo esc_html__("Customized error responses", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__("Changing the page that is shown when a server-side error occurs, for example HTTP 404 Not Found or, to indicate to a search engine that a page has moved, HTTP 301 Moved Permanently.", "ezy_sc-text");

?>

<li>• <strong><?php

echo esc_html__("MIME types", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__("Instruct the server how to treat different varying file types.", "ezy_sc-text");

?>

<li>• <strong><?php

echo esc_html__("Cache Control", "ezy_sc-text");

?></strong></li>

<?php

echo esc_html__(".htaccess files allow a server to control caching by web browsers and proxies to reduce bandwidth usage, server load, and perceived lag.", "ezy_sc-text");

?>

</ul>

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

echo esc_html__("A .htaccess (hypertext access) file is a directory-level configuration file supported by several web servers, that allows for decentralized management of web server configuration. They are placed inside the web tree, and are able to override a subset of the server's global configuration for the directory that they are in, and all sub-directories.", "ezy_sc-text");

?>

                        </div>

				     </div>

				</div>

				</div>