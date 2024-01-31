<script type="text/javascript">

    var last_log_line   = 0;
    var initial_load    = true;
    var log_lines       = Array();
    var max_log_lines   = 100;

    jQuery(document).ready(function($) {
        $.ajaxSetup({
            type: 'POST',
            url: ajaxurl, /* predefined WP value */
            complete: function(xhr,status) {
                if ( status != 'success' ) {
                    //alert("Failed to communicate with WP");
                }
            }
        });

        /*
        $('#run-scanner').click( function() {
            var url             = $('#url_name').val();
            var ezy_srv_name    = $('#ezy_srv_name').val();
                
            $.ajaxSetup({
                type: 'POST',
                url: ajaxurl, // predefined WP value 
                complete: function(xhr,status) {
                    if ( status != 'success' ) {
                        //alert("Failed to communicate with WP");
                    }
                }
            });
            run_scan(url,ezy_srv_name);
            $('#run-scanner').hide();
            return false;
        });*/


        $('#run-internal-scanner').click( function() {
            alert("run-internal-scan clicked");
            clean_log();
            run_internal_scan( 0 );
            //$('#run-internal-scanner').hide();
            return false;
        });


        $('#clean-log').click( function() {
            clean_log();
        });



        $('#stop-internal-scanner').click( function() {
            console.log("stop_internal_scan"); 
            jQuery.ajax({
                data: {
                    action: 'scanner-stop_internal_scan',
                }, 
                success: function(r) {
                    log("INFO", "Termination sent successfully");
                    log("INFO", r );
                    console.log(r);
                }//end of success function
            });
        });

        /*
         * Hook to catch bootstrap tabs switching
         */ 
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
             var currentTab = $(e.target).text(); // get current tab
             var LastTab = $(e.relatedTarget).text(); // get last tab
             //alert(currentTab);
             if( currentTab.indexOf("Detected") >= 0 ){
                 console.log("Detected Threats");
                 get_detected_threats();
             }else if( currentTab.indexOf("Summary") >= 0 ){
                 //alert("Summary");
                 UpdateStatus();
             }else if( currentTab.indexOf("Ignored") >= 0 ){
                 //alert("Ignored Threats");
                 get_ignored_list();
             }
        });


        $('#clean-ignore-list').click( function() {
            console.log("clean-ignore-list"); 
            jQuery.ajax({
                data: {
                    action: 'scanner-clean_ignore_list',
                }, 
                success: function(r) {
                    log("INFO", "Ignore list cleaned successfully");
                    log("INFO", r );
                    console.log(r);
                    /*
                     * refresh list of detect threat and restore all threats removed from ignore list
                     */
                    get_detected_threats();
                }//end of success function
            });
        });


        $('#clean-files-white-list').click( function() {
            console.log("clean-files-white-list"); 
            jQuery.ajax({
                data: {
                    action: 'scanner-clean_files_whitelist',
                }, 
                success: function(r) {
                    log("INFO", "Files whitellist cleaned successfully");
                    log("INFO", r );
                    console.log(r);
                    /*
                     * refresh list of detect threat and restore all threats removed from ignore list
                     */
                    get_detected_threats();
                }//end of success function
            });
        });


        $('#clean-threats-white-list').click( function() {
            console.log("clean-threats-white-list"); 
            jQuery.ajax({
                data: {
                    action: 'scanner-clean_threats_whitelist',
                }, 
                success: function(r) {
                    log("INFO", "Threats whitellist cleaned successfully");
                    log("INFO", r );
                    console.log(r);
                    /*
                     * refresh list of detect threat and restore all threats removed from ignore list
                     */
                    get_detected_threats();
                }//end of success function
            });
        });

        /*
         * Clean last log line to retrieve an entire log
         */
        last_log_line = 0;
        /*
         * retrieve log and execution statistics
         */
        UpdateStatus();
        /*
         * Show the hidden pane
         */
        $('#progress-pane').show();
    }); 



    function UpdateStatus( ){

        update_logs( );

        get_stats();

        setTimeout( UpdateStatus, 1000 );
    }

    /*
     * URL validation procedure
     */
    /*
    function validateURL(textval) {
         var urlregex = new RegExp(
            "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2,12}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
         return urlregex.test(textval);
    }*/

    /*
     * Domain validation procedure
     */
    /*
    function validateDomain(domain) { 
        //var re = new RegExp(/^[a-zA-Z0-9][a-zA-Z0-9-_]{0,61}[a-zA-Z0-9]{0,1}\.([a-zA-Z]{1,6}|[a-zA-Z0-9-]{1,30}\.[a-zA-Z]{2,10})$/); 
        var d = domain.trim();
        var re = new RegExp(/^(www\.)?([a-zA-Z0-9][a-zA-Z0-9-_]{0,45}[a-zA-Z0-9]\.)+[a-zA-Z]{2,10}$/);
        return d.match(re);
    }*/  

    /*
    function scroll_log($)
    {
        $("#log").animate({ scrollTop: $("#log")[0].scrollHeight - $("#log").height() });
    }*/

    function clean_log( )
    {
        console.log("clean_log called");
        document.getElementById("log").value = "";
        last_log_line = 0;

        jQuery.ajax({
            data: {
                action: 'scanner-clean_log',
            }, 
            success: function(r) {
                //console.log(r);
            }
        });

        setTimeout( UpdateStatus, 1000 );
    }


    function update_logs ( )
    {
        console.log("update_logs");

        jQuery.ajax({
            data: {
                action: 'scanner-get_log_lines',
                start_line: last_log_line,
            }, 
            success: function(r) {
                //console.log(r);
                //alert(r);
                //return;
                //
                var log_lines = jQuery.parseJSON(r);
                if( !Array.isArray(log_lines) ){
                    console.log ("Invalid input: " + log_lines );
                    return;
                }

                if( log_lines )
                {
                    for( var i = 0 ; i < log_lines.length ; i++ )
                    {
                        var index       = 0;    
                        var severity    = null;
                        var message     = null;

                        if( log_lines[i].length >=1 ){
                            index = log_lines[i][0];
                        }
                        if( log_lines[i].length >= 2 ){
                            severity = log_lines[i][1];
                        }
                        if( log_lines[i].length >= 3 ){
                            message = log_lines[i][2];
                        }

                        //alert(message);
                        if( index > last_log_line )
                        {
                            log(severity,message);
                            last_log_line = index; 
                        }
                    }
                }
            }//end of success function
        });
    }

    function get_stats ( )
    {
        jQuery.ajax({
            data: {
                action: 'scanner-get_stats',
            }, 
            success: function(r) {
                var counters = jQuery.parseJSON(r);
                update_stats( counters );
            }//end of success function
        });

    }


    function get_detected_threats ( )
    {
        jQuery.ajax({
            data: {
                action: 'scanner-get_detected_threats',
            }, 
            success: function(r) 
            {
                var threats = jQuery.parseJSON(r);

                if( Array.isArray(threats) ){
                    clean_detected_threats_list();
                    threats_to_show = 100;

                    if( threats_to_show > threats.length ){
                        threats_to_show = threats.length;
                    }

                    if( threats_to_show != 0 )
                    {
                        for(var i = 0; i < threats_to_show; i++ )
                        {
                            append_detected_threats_report( threats[i] );
                        }
                    }
                    else
                    {
                        console.log("Threats arry is clean");
                        show_empty_threats_report();
                    }
                    //
                }else{
                    console.log("Retrieved invalid output: " + r);
                }
            }//end of success function
        });
    }


    function show_empty_threats_report ( )
    {
        document.getElementById("detected_threats_report").innerHTML = "<center><p>No entries have been found</p></center>";
    }


    function clean_detected_threats_list ( )
    {
        document.getElementById("detected_threats_report").innerHTML = "";
    }

    function append_detected_threats_report( report )
    {
        var alert_type = "alert alert-info";
        var severity   = report["SEVERITY"].toLowerCase();

        if( severity.indexOf("malicious") >= 0 ){
            alert_type = "alert alert-danger";
        }else if( severity.indexOf("susp") >= 0 ){
            alert_type = "alert alert-warning";
        }

        var threat      = report["THREAT"].substr(0,20); 
        var filename    = strip_file_path(report["FILE"],60);
        var file_md5    = report["FILE_MD5"];
        var threat_sig  = report["THREAT_SIG"];

        document.getElementById("detected_threats_report").innerHTML += 
        "</br>\n" +
        "<div class='" + alert_type + "'>\n"+
            "<table class='table'>\n" +
                "<tr><td>Severity: </td><td> " + report["SEVERITY"] + "</td></tr>\n" +
                "<tr><td>File: </td><td> " + filename + "</td></tr>\n" +
                "<tr><td>File signature: </td><td> " + report["FILE_MD5"] + "</td></tr>\n" +
                "<tr><td>Threat signature: </td><td> " + report["THREAT_SIG"] + "</td></tr>\n" +
                "<tr><td>Threat name: </td><td> " + report["THREAT_NAME"] + "</td></tr>\n" +
                "<tr><td>Threat: </td><td> " + threat  + "</td></tr>\n" +
                "<tr><td>Details: </td><td> " + report["DETAILS"] + "</td></tr>\n" +
            "</table>\n" + 
            "<div class='btn-group btn-group-xs'>\n" + 
            "<button type='button' class='btn btn-primary' onclick='add_to_ignore_list(\"" + file_md5 + "\",\"" + threat_sig + "\")'>Ignore Threat</button>\n" +
            "<button type='button' class='btn btn-primary' onclick='whitelist_file(\"" + file_md5 + "\")'>WhiteList File</button>\n" +
            "<button type='button' class='btn btn-primary' onclick='whitelist_threat(\"" + file_md5 + "\",\"" + threat_sig + "\")'>Not a Threat</button>\n" +
            "</div>\n"+
       "</div>\n";
    }



    function append_ignored_threats_report( report )
    {
        var alert_type = "alert alert-info";
        var severity   = report["SEVERITY"].toLowerCase();

        if( severity.indexOf("malicious") >= 0 ){
            alert_type = "alert alert-danger";
        }else if( severity.indexOf("susp") >= 0 ){
            alert_type = "alert alert-warning";
        }

        var threat      = report["THREAT"].substr(0,20); 
        var filename    = strip_file_path(report["FILE"],60);
        var file_md5    = report["FILE_MD5"];
        var threat_sig  = report["THREAT_SIG"];

        document.getElementById("ignored_threats_report").innerHTML += 
            "</br>\n" +
            "<div class='" + alert_type + "'>\n"+
                "<table class='table'>\n" +
                    "<tr><td>Severity: </td><td> " + report["SEVERITY"] + "</td></tr>\n" +
                    "<tr><td>File: </td><td> " + filename + "</td></tr>\n" +
                    "<tr><td>File signature: </td><td> " + report["FILE_MD5"] + "</td></tr>\n" +
                    "<tr><td>Threat signature: </td><td> " + report["THREAT_SIG"] + "</td></tr>\n" +
                    "<tr><td>Threat name: </td><td> " + report["THREAT_NAME"] + "</td></tr>\n" +
                    "<tr><td>Threat: </td><td> " + threat  + "</td></tr>\n" +
                    "<tr><td>Details: </td><td> " + report["DETAILS"] + "</td></tr>\n" +
                "</table>\n" + 
                "<div class='btn-group btn-group-xs'>\n" + 
                "<button type='button' class='btn btn-primary' onclick='remove_from_ignore_list(\"" + file_md5 + "\",\"" + threat_sig + "\")'>Remove from Ignore List</button>\n" +
                "</div>\n";
           "</div>\n";
    }



    function get_ignored_list ( )
    {
        console.log("get_ignored_list");

        jQuery.ajax({
            data: {
                action: 'scanner-get_ignored_threats',
            }, 
            success: function(r) {
                //console.log(r);
                var threats = jQuery.parseJSON(r);

                if( Array.isArray(threats) ){
                    clean_ignored_threats_list();
                    threats_to_show = 100;

                    if( threats_to_show > threats.length ){
                        threats_to_show = threats.length;
                    }

                    if( threats_to_show != 0 )
                    {
                        for(var i = 0; i < threats_to_show; i++ )
                        {
                            append_ignored_threats_report( threats[i] );
                        }
                    }
                    else
                    {
                        console.log("Ignored list is clean");
                        show_empty_ignored_list();
                    }
                }else{
                    console.log("Retrieved invalid output: " + r);
                }
            }//end of success function
        });
    }


    function whitelist_file( file_sig )
    {
         jQuery.ajax({
            data: {
                action: 'scanner-whitelist_file',
                FILE_MD5: file_sig,
            }, 
            success: function(r) {
                console.log(r);
                console.log("whitelist_file operation succeeded");
                get_detected_threats ( );
            }//end of success function
        });
       
    }

    function whitelist_threat(file,threat)
    {
        jQuery.ajax({
            data: {
                action: 'scanner-whitelist_threat',
                FILE_MD5: file,
                THREAT_SIG: threat,
            }, 
            success: function(r) {
                console.log(r);
                console.log("whitelist_threat: operation succeeded" );
                get_detected_threats ( );
            }//end of success function
        });
    }



    function show_empty_ignored_list ( )
    {
        document.getElementById("ignored_threats_report").innerHTML = "<center><p>No entries have been found</p></center>";
    }


    function clean_ignored_threats_list ( )
    {
        document.getElementById("ignored_threats_report").innerHTML = "";
    }


    function add_to_ignore_list(file,threat)
    {
        jQuery.ajax({
            data: {
                action: 'scanner-ignore_threat',
                FILE_MD5: file,
                THREAT_SIG: threat,
            }, 
            success: function(r) {
                /* 
                 * refresh content of the tab
                 */
                get_detected_threats ( );
            }//end of success function
        });
    }


    function remove_from_ignore_list(file,threat)
    {
        jQuery.ajax({
            data: {
                action: 'scanner-unignore_threat',
                FILE_MD5: file,
                THREAT_SIG: threat,
            }, 
            success: function(r) {
                /* 
                 * refresh content of the tab
                 */
                get_ignored_list();
            }//end of success function
        });
    }


    run_internal_scan = function( level ) 
    {
        log("INFO","Submitting internal scan request");

        jQuery.ajax({
            data: {
                action: 'scanner-run_internal_scan',
            }, 


            timeout: 3000, // sets timeout to 3 seconds

            error: function(jqXHR, textStatus){
                log("INFO","Internal scan request submitted");
            },
            success: function(r) {
                log("INFO","Operation succeeded. Internal scan started");
            }//end of success function
        });

        UpdateStatus();
    };

    /*
    run_scan = function(this_url,ezy_url,level) {
        if( !validateDomain(this_url) ){
	        hide_all();
            var curr_time = new Date().getTime();
            show_investigation_status( {    "state" : "Provided name of this web-site is invalid", 
                                            "age"   : curr_time,
                                            "url"   : "<invalid>"
                                       });
	        return;
	    }

        if( !validateURL(ezy_url) ){
    	    hide_all();
            var curr_time = new Date().getTime();
            show_investigation_status({ "state" : "Provided name of Qutter web malware scanner is invalid", 
                                        "age"   : curr_time,
                                        "url"   : "<invalid>" });
    	    return;
	    }

        if( !level )
        {
            hide_all();
            var curr_time = new Date().getTime();
            show_investigation_status( {    "state" : "starting", 
                                            "age"   : curr_time,
                                            "url"   : this_url });
        }

        jQuery.ajax({
            data: {
                action: 'scanner-run_scan',
                _this: this_url,
                _ezy_url: ezy_url
            }, 
            success: function(r) {
                var res = jQuery.parseJSON(r);
                var state = res.content.state.toLowerCase();
                
                if ( state == 'new' )
                {
                    show_investigation_status({ "state" : "Waiting for free web malware scanner slot.",
                                                "age"   : res.content.age,
                                                "url"   : res.content.url,
                                                "priority" : res.content.priority });

                    run_scan(this_url,ezy_url,1); //recursive call
                }
                else if( state == 'download')
                {
                    show_investigation_status({ "state" : "Website content is being downloaded for investigation.", 
                                                "age"   : res.content.age,
                                                "url"   : res.content.url,
                                                "priority" : res.content.priority,
                                                "processed_files": res.content.processed_files  });

                    run_scan(this_url,ezy_url,1); //recursive call
                }
                else if( state =='downloaded' )
                {
                    show_investigation_status({ "state" : "Website content has been downloaded and is waiting for scanner.", 
                                                "age"   : res.content.age,
                                                "url"   : res.content.url,
                                                "priority" : res.content.priority });

                    run_scan(this_url,ezy_url,1); //recursive call
                }
                else if( state =='scan' || state =='scanned' )
                {
                    show_investigation_status({ "state" : "website content is being scanned", 
                                                "age"   : res.content.age,
                                                "url"   : res.content.url,
                                                "priority" : res.content.priority,
                                                "processed_files": res.content.processed_files });

                    run_scan(this_url,ezy_url,1); //recursive call
                }
                else if( state == 'clean' )
                {
                    show_investigation_report(res.content);
                }
                else if( state=='potentially suspicious' || state=='potentially unsafe' )
                {
                    show_investigation_report(res.content);
                }
                else if (state=='suspicious' || state=='unsafe')
                {
                    show_investigation_report(res.content);                
                }
                else if (state=='malicious')
                {
                    show_investigation_report(res.content);                
                }
                else
                {
                    show_investigation_error(res.content);
                }                
            }//end of success function
        });
    };


    show_investigation_error = function( status ){
        var urlDate     = new Date();
        var currentdate = urlDate.toLocaleString();

        jQuery('#investigation_error').empty();
            var str =   "<b>State</b>: <font color='red'>"   + status.state  + "</font></br>" +
                        "<b>Time</b>: "    + currentdate   + "</br>" +
                        "<b>URL</b>: "     + status.url;
        //alert("Status: " + str );
        hide_all();
        jQuery('#investigation_error').append("<p>" + str + "</p>");
        jQuery('#investigation_error').show();
        jQuery('#run-scanner').show();
    }*/
   
    /*
     * status comprised from fields:
     *      url  
     *      priority
     *      state  
     *      age   
     *      processed_files
     */
    /*  
    show_investigation_status = function ( status ){
        hide_all();
        var urlDate     = new Date();
        var currentdate = urlDate.toLocaleString();

        jQuery('#investigation_progress').empty();
        var str = "<b>State</b>: <b><font color='green'>" + status.state  + "</font></b></br>" +
                  "<b>Time</b>: "  + currentdate   + "</br>" +
                  "<b>URL</b>: "   + status.url    + "</br>";

        if( status.priority )
        {
            str += "<b>Investigation priority</b>: " + status.priority + "</br>";
        }

        if( status.processed_files )
        {
            str += "<b>Processed files</b>: " + status.processed_files + "</br>";
        }
        
        jQuery('#investigation_progress').append("<p>" + str + "</p>");
        jQuery('#investigation_progress').show();
    };
   
 
    show_investigation_report = function ( scan_report ){
        hide_all();
        jQuery('#investigation_result').empty();
        jQuery('#investigation_result').append('<H2>Website Malware Investigation Report</H2><hr>');
        jQuery('#investigation_result').append('<a href="http://ezy_sc.com/article/about-ezy_sc-malware-scan-report" target="_blank">Understanding security reports</a>');
                
        var clean_files             = 0;
        var pot_suspicious_files    = 0;
        var suspicious_files        = 0;
        var malicious_files         = 0;
        
        for( var i = 0; i < scan_report.report.length; i ++ )
        {
            var threat = scan_report.report[i].threat.toLowerCase();
            if( threat == "malicious" ){
                malicious_files         += 1;
            }else if( threat == "suspicious" ){
                suspicious_files        +=1;
            }else if( threat == "potentially suspicious"){
                pot_suspicious_files    += 1;
            }else{
                clean_files             += 1;
            }
        }

        var summary =   "<table>" +
                        "<tr><td align='left'><b>Server IP:</b></td>" +
                             "<td align='left'><b>" + scan_report.ipaddr + "</b></td></tr>" +

                        "<tr><td align='left'><b>Location:</b></td>" +
                             "<td align='left'><b>" + scan_report.country + "</b></td></tr>" +

                        "<tr><td align='left'><b>Web Server:</b></td>" +
                             "<td align='left'><b>" + scan_report.http_server + "</b></td></tr>" +

                        "<tr><td align='left'><font color='green'><b>Clean files: </b></font></td>"+
                            "<td align='left'><font color='green'><b>"  + clean_files + "</b></font></td></tr>" +

                        "<tr><td align='left'><font color='orange'><b>Potentially Suspicious files: </b></font></td>"+
                            "<td align='left'><font color='orange'><b>" + pot_suspicious_files + "</b></font></td></tr>" +

                        "<tr><td align='left'><font color='red'><b>Suspicious files: </b></font></td>"+
                            "<td align='left'><font color='red'><b>" + suspicious_files + "</b></font></td></tr>" +

                        "<tr><td align='left'><font color='#780000'><b>Malicious files: </b></font></td>" +
                            "<td align='left'><font color='#780000'><b>"    + malicious_files + "</b></font></td></tr>";


        if(  scan_report.is_blacklisted )
        {
            if(  scan_report.is_blacklisted &&  scan_report.is_blacklisted.toLowerCase() == "no" )
            {
                summary +=  "<tr><td align='left'><font color='green'><b>Blacklisted: </b></font></td>"+
                                    "<td align='left'><font color='green'><b>"  + scan_report.is_blacklisted + "</b></font></td></tr>";
            }
            else
            {
                summary +=  "<tr><td align='left'><font color='red'><b>Blacklisted: </b></font></td>"+
                                    "<td align='left'><font color='red'><b>"  + scan_report.is_blacklisted + "</b></font></td></tr>";
            }
        }

        summary +=      "<tr><td align='left'><b>External links:</b></td>" +
                             "<td align='left'><b>" + scan_report.links_count + "</b></td></tr>" +

                        "<tr><td align='left'><b>Detected iframes:</b></td>" +
                             "<td align='left'><b>" + scan_report.iframes_count + "</b></td></tr>" +

                        "<tr><td align='left'><b>External domains:</b></td>" +
                             "<td align='left'><b>" + scan_report.domains_count + "</b></td></tr>" +
 
                        "</table>" + 
                        "<hr/>";

        jQuery('#investigation_result').append(summary);
        
        var scanner_server = document.getElementById('ezy_srv_name').value;
        var domain_name    = document.getElementById('url_name').value;
        //var full_url       = scanner_server + "/detailed_report/" + domain_name;
        var full_url       = "https://ezy_sc.com/detailed_report/" + domain_name;
        jQuery('#investigation_result').append("<form method='get' action='" + full_url + "' target='new'>" +
                "<input type='submit' class='button-primary' value='Full Investigation Report' style='font-weight: bold;'/></form>");
        
        jQuery('#investigation_report_info').show();
        jQuery('#run-scanner').show();
        jQuery('#investigation_result').show();       
    };
    
    
    function hide_all( )
    {
        jQuery('#investigation_result').hide();
        jQuery('#investigation_error').hide();
        jQuery('#investigation_progress').hide();    
        jQuery('#ezy_sc_detected_malicious_content').hide();    
    }*/


    function log(severity,message)
    {
        if( !severity || !message ){
            return ;
        }

        var log_line = severity + "\t" + message;

        if( log_lines.length >= max_log_lines ){
            /*
             * removes first line from front
             */ 
            log_lines.shift();
        }

        log_lines.push( log_line );

        document.getElementById("log").value = '';
        for( var i = 0; i < log_lines.length; i++ ){
            document.getElementById("log").value += log_lines[i] + "\n";
        }

        document.getElementById("log").scrollTop = document.getElementById("log").scrollHeight;
    }


    function update_stats( counters )
    {
        var start = new Date( counters["START_TIME"] * 1000 );

        document.getElementById("scan_start_time").innerHTML                = start.toTimeString();
        document.getElementById("total_scanned_files").innerHTML            = counters["TOTAL"];
        document.getElementById("scanned_clean_files").innerHTML            = counters["CLEAN"];
        document.getElementById("scanned_pos_suspicious_files").innerHTML   = counters["POT_SUSPICIOUS"];
        document.getElementById("scanned_suspicious_files").innerHTML       = counters["SUSPICIOUS"];
        document.getElementById("scanned_malicious_files").innerHTML        = counters["MALICIOUS"];
    }


    function strip_file_path( path,maxlen ){
        if( path.length <= maxlen ){
            return path;
        }

        name_pos = path.lastIndexOf("/");
        name = path.substring( name_pos );
        path_part_end = maxlen - name.length - 5;
        path_part = path.substring(0,path_part_end) + "/..." + name;
        return path_part;
    }
</script>
