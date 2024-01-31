<?php $nonce = wp_create_nonce( 'EaZy Security' ); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

<script type="text/javascript">
var last_log_line = 0;
var initial_load = true;
var log_lines = Array();
var max_log_lines = 20;
var logs_refresh_timer_set = false;
var progress_bar_timer = 0;
var execution_status_reload = 1024 * 1024;
var status_reload_timer = 0;
var scanner_running = false;
// Start the activity log
var activityLog = [];



jQuery(document).ready(function($) {
    $.ajaxSetup({
        type: 'POST',
        async: true,
        url: ajaxurl,
        /* predefined WP value */
        complete: function(xhr, status) {
            if (status != 'success') {
                console.log("Failed to communicate with WP for " + ajaxurl + " status " + status);
            }
        }
    });


    $('#run-internal-scanner').click(function() {
        console.log("run-internal-scan clicked");
        /*
         * Check if internal scan is not running
         */
        ezyIsInternalScanRunning();
        console.log("Is scanner running " + scanner_running);

        if (scanner_running == true) {
            console.log("Internal scan already runing");
            return false;
        }

        scanner_running = true;
        ezyCleanExecutionLog();
        ezyRunHeurInternalScan(0);
        ezyShowEmptyThreatsReport();
        ezyShowProgressBar();
        ezyStartProgressBarTimer();
        ezyStartExecutionStatusReload(1024 * 1024 * 100);
        return false;
    });


    $('#clean-log').click(function() {
        ezyCleanExecutionLog();
    });


    $('#stop-internal-scanner').click(function() {
        console.log("stop_internal_scan");
        /*
         * Hide progress bar
         */
        ezyHideProgressBar();
        /*
         * Stop progress bar update timer
         */
        ezyStopProgressBarTimer();
        /*
         * Stop logs reading from remote
         */
        ezyStopExecutionStatusReload();

        jQuery.ajax({
            data: {
                action: 'scanner-stop_internal_scan',
                _wpnonce: '<?php echo $nonce; ?>',
            },
            success: function(r) {
                ezyLogMessage("INFO",
                    "Termination sent successfully. Waiting for scan job");
                ezyLogMessage("INFO", r);
                console.log(r);
            } //end of success function
        });
    });


    $('#get-scanner-report').click(function() {
        console.log("get_scanner_report");
        jQuery.ajax({
            data: {
                action: 'scanner-get_file_report',
                _wpnonce: '<?php echo $nonce; ?>',
            },

            success: function(r) {
                var data = r;
                data = data.replace(/</g, "&#60;");
                data = data.replace(/>/g, "&#62;");
                var win = window.open();
                win.document.body.innerHTML = decodeURIComponent(data).replace(
                    /(?:\r\n|\r|\n)/g, '<br />');
                win.focus();

                //Download Report
                var printBtn = document.createElement("BUTTON");
                var printText = document.createTextNode("Download Report");
                printBtn.appendChild(printText);
                printBtn.style.backgroundColor = "#212529";
                printBtn.style.color = "white";
                printBtn.style.height = "41px";
                printBtn.style.width = "130px";
                printBtn.style.marginTop = "20px";
                printBtn.style.pointer = "cursor";
                win.document.body.appendChild(printBtn);
                printBtn.addEventListener("click", function() {
                    win.print();
                });
            }
        });
    });


    // $('#contactBtn').click(function() {
    //     console.log("Contact_button");
    //     // $("#contactForm").toggle();
    //     $("#contact-form-wrapper").show();
    //         $.post("admin.php?page=ezy_sc-contactUs", function() {
    //             window.location.href = "admin.php?page=ezy_sc-contactUs";
    //         });
    // })



    $(document).ready(function($) {
        document.querySelector('#contact-form').addEventListener('submit', (e) => {
            e.preventDefault();
            e.target.elements.name.value = '';
            e.target.elements.email.value = '';
            e.target.elements.message.value = '';
        });
    });





    $('#stop-internal-scanner').click(function() {
        console.log("stop_internal_scan");
        /*
         * Hide progress bar
         */
        ezyHideProgressBar();
        /*
         * Stop progress bar update timer
         */
        ezyStopProgressBarTimer();
        /*
         * Stop logs reading from remote
         */
        ezyStopExecutionStatusReload();

        jQuery.ajax({
            data: {
                action: 'scanner-stop_internal_scan',
                _wpnonce: '<?php echo $nonce; ?>',
            },
            success: function(r) {
                ezyLogMessage("INFO",
                    "Termination sent successfully. Waiting for scan job"
                );
                ezyLogMessage("INFO", r);
                console.log(r);
            } //end of success function
        });
    });



    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
        $('#clean-log').click(function() {
            // code to execute when "Scan Activity Log" is clicked
        });
        $('#clean-ignore-list').click(function() {
            // code to execute when "Ignored Threats List" is clicked
        });
        $('#clean-files-white-list').click(function() {
            // code to execute when "Whitelisted Files List" is clicked
        });
        $('#clean-threats-white-list').click(function() {
            // code to execute when "Whitelisted Threats List" is clicked
        });
        $('#clear-clearlog').click(function() {
            // code to execute when "clear-clearlog" is clicked
        });
    });


    /*
     * Hook to catch bootstrap tabs switching
     */
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var currentTab = $(e.target).text(); // get current tab
        var LastTab = $(e.relatedTarget).text(); // get last tab
        //alert(currentTab);
        if (currentTab.indexOf("Detected") >= 0) {
            console.log("Detected Threats");
            ezyReloadDetectedThreatsReport();
        } else if (currentTab.indexOf("Summary") >= 0) {
            //alert("Summary");
            ezyReloadExecutionStatus();
        } else if (currentTab.indexOf("Ignored") >= 0) {
            //alert("Ignored Threats");
            ezyReloadIgnoredThreatsReport();
        }
    });


    $('#clean-ignore-list').click(function() {
        console.log("clean-ignore-list");
        jQuery.ajax({
            data: {
                action: 'scanner-clean_ignore_list',
                _wpnonce: '<?php echo $nonce; ?>',
            },
            success: function(r) {
                ezyLogMessage("INFO", "Ignore list cleaned successfully");
                ezyLogMessage("INFO", r);
                console.log(r);
                /*
                 * refresh list of detect threat and restore all threats removed from ignore list
                 */
                ezyReloadDetectedThreatsReport();
                ezyReloadIgnoredThreatsReport();
            } //end of success function
        });
    });


    $('#clean-files-white-list').click(function() {
        console.log("clean-files-white-list");
        jQuery.ajax({
            data: {
                action: 'scanner-clean_files_whitelist',
                _wpnonce: '<?php echo $nonce; ?>',
            },
            success: function(r) {
                ezyLogMessage("INFO",
                    "Files whitellist cleaned successfully");
                ezyLogMessage("INFO", r);
                console.log(r);
                /*
                 * refresh list of detect threat and restore all threats removed from ignore list
                 */
                ezyReloadDetectedThreatsReport();
            } //end of success function
        });
    });


    $('#clean-threats-white-list').click(function() {
        console.log("clean-threats-white-list");
        jQuery.ajax({
            data: {
                action: 'scanner-clean_threats_whitelist',
                _wpnonce: '<?php echo $nonce; ?>',
            },
            success: function(r) {
                ezyLogMessage("INFO",
                    "Threats whitellist cleaned successfully");
                ezyLogMessage("INFO", r);
                console.log(r);
                /*
                 * refresh list of detect threat and restore all threats removed from ignore list
                 */
                ezyReloadDetectedThreatsReport();
            } //end of success function
        });
    });

    /*
     * Clean last log line to retrieve an entire log
     */
    last_log_line = 0;

    /*
     * Show the hidden pane
     */
    $('#progress-pane').show();

    ezyIsInternalScanRunning();

    if (scanner_running == true) {
        console.log("EaZy Security internal scan already running");
        /*
         * retrieve log and execution statistics
         * and show progress bar
         */
        ezyStartExecutionStatusReload(1024 * 1024 * 100);
        ezyReloadExecutionStatus();
        ezyShowProgressBar();
        ezyStartProgressBarTimer();
    } else {
        console.log("EaZy Security internal scan is not running");
        /*
         * Reload status from remote
         */
        ezyReloadExecutionStatus();
        /*
         * just to start reload timer
         */
        ezyStartExecutionStatusReload(0);
    }

});


function ezyStartExecutionStatusReload(count) {
    execution_status_reload = count;
    if (status_reload_timer == 0) {
        status_reload_timer = setInterval(ezyReloadExecutionStatusTimer,
            40000);
    }
}


function ezyStopExecutionStatusReload() {
    execution_status_reload = 5;
}


function ezyStartProgressBarTimer() {
    console.log("ezyStartProgressBarTimer called");
    if (progress_bar_timer == 0) {
        progress_bar_timer = setInterval(ezyUpdateProgressBar,
            20000);
    }
}


function ezyStopProgressBarTimer() {
    if (progress_bar_timer) {
        clearInterval(progress_bar_timer);
        progress_bar_timer = 0;
    }
}

function ezyShowProgressBar() {
    console.log("ezyShowProgressBar called");
    document.getElementById("progress_bar").style.display = 'block';
    progress_bar.animate({
        width: newValue + "%"
    }, {
        duration: 1000
    });

    function progress() {
        var val = ezyShowProgressBar.ezyShowProgressBar("value");
        if (val < 99) {
            setTimeout(ezyShowProgressBar, 80);
        }
    }

    setTimeout(ezyShowProgressBar, 2000);

}

function ezyHideProgressBar() {
    console.log("ezyHideProgressBar called");
    document.getElementById("progress_bar").style.display = 'none';
}

function ezyUpdateProgressBar() {
    console.log("ezyUpdateProgressBar called");
    if (execution_status_reload > 0) {
        ezyIsInternalScanRunning();
        console.log("Is scanner running " + scanner_running);
        if (scanner_running == true) {
            ezyShowProgressBar();
        } else {
            ezyHideProgressBar();
        }
    } else {
        console.log("ezyUpdateProgressBar: scanner is not running");
    }
}

function ezyIsInternalScanRunning() {
    jQuery.ajax({
        data: {
            action: 'scanner-is_internal_scan_running',
            _wpnonce: '<?php echo $nonce; ?>',
        },
        async: false,
        success: function(r) {
            console.log(r);
            if (r == "yes") {
                //console.log("Scanner is running");
                scanner_running = true;
                return true;
            } else {
                //console.log("Scanner is not running");
                scanner_running = false;
                return false;
            }
        } //end of success function
    });

    return scanner_running;
};


function ezyReloadExecutionStatusTimer() {
    if (!scanner_running) {
        /*
         * Check if internal scan done
         */
        if (execution_status_reload > 3) {
            /*
             * Yes, it seems that internal scan terminated,
             * Stop status reload after a minute
             */
            execution_status_reload = 3
        }
    }

    if (execution_status_reload > 0) {
        execution_status_reload -= 1;
        ezyReloadExecutionStatus();
    }
}


function ezyReloadExecutionStatus() {
    ezyReloadExecutionLog();
    ezyReloadExecutionStats();
}


function ezyCleanExecutionLog() {
    console.log("ezyCleanExecutionLog called");
    document.getElementById("log").value = "";
    last_log_line = 0;

    jQuery.ajax({
        data: {
            action: 'scanner-clean_log',
            _wpnonce: '<?php echo $nonce; ?>',
        },
        success: function(r) {
            //console.log(r);
        }
    });
}


function ezyReloadExecutionLog() {
    console.log("ezyReloadExecutionLog called");
    jQuery.ajax({
        data: {
            action: 'scanner-get_log_lines',
            _wpnonce: '<?php echo $nonce; ?>',
            start_line: last_log_line,
        },
        success: function(r) {
            //console.log(r);
            //alert(r);
            //return;
            //
            var log_lines = jQuery.parseJSON(r);
            if (!Array.isArray(log_lines)) {
                console.log("Invalid input: " + log_lines);
                return;
            }

            if (log_lines) {
                ezyLogMessages(log_lines);
            }
        } //end of success function
    });
}

function ezyReloadExecutionStats() {
    jQuery.ajax({
        data: {
            action: 'scanner-get_stats',
            _wpnonce: '<?php echo $nonce; ?>',
        },
        success: function(r) {
            var counters = jQuery.parseJSON(r);
            ezyUpdateExecutionStats(counters);
        } //end of success function
    });

}


var nonce = '<?php echo $nonce; ?>';

function ezyReloadDetectedThreatsReport() {
    jQuery.ajax({
        data: {
            action: 'scanner-get_detected_threats',
            _wpnonce: nonce,
        },
        success: function(r) {
            console.log(r);

            var threats = jQuery.parseJSON(r);

            if (Array.isArray(threats)) {
                ezyCleanDetectedThreatsReport();
                threats_to_show = 100;

                if (threats_to_show > threats.length) {
                    threats_to_show = threats.length;
                }

                if (threats_to_show != 0) {
                    for (var i = 0; i < threats_to_show; i++) {
                        ezyAddToDetectedThreatsReport(threats[i]);
                    }
                } else {
                    console.log("Threats arry is clean");
                    ezyShowEmptyThreatsReport();
                }
                //
            } else {
                console.log("Retrieved invalid output: " + r);
            }
        } //end of success function
    });
}





function ezyShowEmptyThreatsReport() {
    document.getElementById('detected_threats_report').style.display = 'none';
    document.getElementById('detected_threats_report').style.display = 'block';
    document.getElementById("detected_threats_report").innerHTML =
        "<center><p>No entries have been found</p></center>";
}


function ezyCleanDetectedThreatsReport() {
    document.getElementById("detected_threats_report").innerHTML = "";
}



function ezyAddToDetectedThreatsReport( report )
    {
        var alert_type = "alert alert-info";
        var severity   = report["SEVERITY"].toLowerCase();

        if( severity.indexOf("malicious") >= 0 ){
            alert_type = "alert alert-danger";
        }else if( severity.indexOf("susp") >= 0 ){
            alert_type = "alert alert-warning";
        }

        var threat      = report["THREAT"].substr(0,20); 
        var filename    = ezyStripFilePath(report["FILE"],60);
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
                    /* "<button type='button' class='button-primary btn-sm' onclick='ezyIgnoreThreat(\"" + file_md5 + "\",\"" + threat_sig + "\")'>Ignore Threat</button>\n" + */
                    "<button type='button' class='button-primary btn-sm' id=\"" + file_md5 + "\" onclick='ezyWhitelistFile(\"" + file_md5 + "\")'>WhiteList</button>\n" +
                    /* "<button type='button' class='button-primary btn-sm' onclick='ezyWhitelistThreat(\"" + file_md5 + "\",\"" + threat_sig + "\")'>Not a Threat</button>\n" + */
                    "<button type='button' class='button-primary btn-sm' id=\"" + file_md5 + "-ShowFile\" onclick='ezyShowFile(\"" + report["FILE"] + "\")'>Show File</button>\n" +
                "</div>\n";
           "</div>\n";
    }

// function ezyAddToDetectedThreatsReport(report) {
//     if (!report || typeof report !== "object") {
//         console.error("Error: Invalid report object");
//         return;
//     }

//     var alert_type = "alert alert-info";
//     var severity = report["SEVERITY"] ? report["SEVERITY"].toLowerCase() : "";
//     var threat = report["THREAT"] ? report["THREAT"].substr(0, 20) : "";
//     var filename = report["FILE"] ? ezyStripFilePath(report["FILE"], 60) : "";
//     var file_md5 = report["FILE_MD5"] || "";
//     var threat_sig = report["THREAT_SIG"] || "";
//     var threat_name = report["THREAT_NAME"] || "";
//     var details = report["DETAILS"] || "";

//     if (severity.indexOf("malicious") >= 0) {
//         alert_type = "alert alert-danger";
//     } else if (severity.indexOf("susp") >= 0) {
//         alert_type = "alert alert-warning";
//     }

//     var container = document.getElementById("detected_threats_report");
//     if (!container) {
//         console.error("Error: Could not find container element");
//         return;
//     }

//     var div = document.createElement("div");
//     div.className = alert_type;

//     var table = document.createElement("table");
//     table.className = "table";

//     var tbody = document.createElement("tbody");

//     var tr1 = document.createElement("tr");
//     var td1_1 = document.createElement("td");
//     var td1_2 = document.createElement("td");
//     td1_1.innerHTML = "Severity:";
//     td1_2.innerHTML = report["SEVERITY"];
//     tr1.appendChild(td1_1);
//     tr1.appendChild(td1_2);
//     tbody.appendChild(tr1);

//     var tr2 = document.createElement("tr");
//     var td2_1 = document.createElement("td");
//     var td2_2 = document.createElement("td");
//     td2_1.innerHTML = "File:";
//     td2_2.innerHTML = filename;
//     tr2.appendChild(td2_1);
//     tr2.append
//     tr2.appendChild(td2_2);
//     tbody.appendChild(tr2);

//     var tr3 = document.createElement("tr");
//     var td3_1 = document.createElement("td");
//     var td3_2 = document.createElement("td");
//     td3_1.innerHTML = "File signature:";
//     td3_2.innerHTML = file_md5;
//     tr3.appendChild(td3_1);
//     tr3.appendChild(td3_2);
//     tbody.appendChild(tr3);

//     var tr4 = document.createElement("tr");
//     var td4_1 = document.createElement("td");
//     var td4_2 = document.createElement("td");
//     td4_1.innerHTML = "Threat signature:";
//     td4_2.innerHTML = threat_sig;
//     tr4.appendChild(td4_1);
//     tr4.appendChild(td4_2);
//     tbody.appendChild(tr4);

//     var tr5 = document.createElement("tr");
//     var td5_1 = document.createElement("td");
//     var td5_2 = document.createElement("td");
//     td5_1.innerHTML = "Threat name:";
//     td5_2.innerHTML = threat_name;
//     tr5.appendChild(td5_1);
//     tr5.appendChild(td5_2);
//     tbody.appendChild(tr5);

//     var tr6 = document.createElement("tr");
//     var td6_1 = document.createElement("td");
//     var td6_2 = document.createElement("td");
//     td6_1.innerHTML = "Threat:";
//     td6_2.innerHTML = threat;
//     tr6.appendChild(td6_1);
//     tr6.appendChild(td6_2);
//     tbody.appendChild(tr6);

//     var tr7 = document.createElement("tr");
//     var td7_1 = document.createElement("td");
//     var td7_2 = document.createElement("td");
//     td7_1.innerHTML = "Details:";
//     td7_2.innerHTML = details;
//     tr7.appendChild(td7_1);
//     tr7.appendChild(td7_2);
//     tbody.appendChild(tr7);

//     table.appendChild(tbody);
//     div.appendChild(table);

//     var btnGroup = document.createElement("div");
//     btnGroup.className = "btn-group btn-group-xs";

//     var whitelistBtn = document.createElement("button");
//     whitelistBtn.type = "button";
//     whitelistBtn.className = "button-primary btn-sm";
//     whitelistBtn.id = file_md5;
//     whitelistBtn.innerHTML = "Whitelist";
//     whitelistBtn.setAttribute("onclick", `ezyWhitelistFile("${file_md5}")`);
//     btnGroup.appendChild(whitelistBtn);

//     var showFileBtn = document.createElement("button");
//     showFileBtn.type = "button";
//     showFileBtn.className = "button-primary btn-sm";
//     showFileBtn.id = "-ShowFile";
//     showFileBtn.innerHTML = "Show File";
//     showFileBtn.setAttribute("onclick", `showFile("${filename}")`);
//     btnGroup.appendChild(showFileBtn);

//     div.appendChild(btnGroup);
//     container.appendChild(div);
// }


/*

            <button type="button" class="button-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="stop-internal-scanner">
                Stop Scanner
            </button>
*/

function ezyAddToIgnoredThreatsReport(report) {
    var alert_type = "alert alert-info";
    var severity = report["SEVERITY"].toLowerCase();

    if (severity.indexOf("malicious") >= 0) {
        alert_type = "alert alert-danger";
    } else if (severity.indexOf("susp") >= 0) {
        alert_type = "alert alert-warning";
    }

    var threat = report["THREAT"].substr(0, 20);
    var filename = ezyStripFilePath(report["FILE"], 60);
    var file_md5 = report["FILE_MD5"];
    var threat_sig = report["THREAT_SIG"];

    document.getElementById("ignored_threats_report").innerHTML +=
        "</br>\n" +
        "<div class='" + alert_type + "'>\n" +
        "<table class='table'>\n" +
        "<tr><td>Severity: </td><td> " + report["SEVERITY"] + "</td></tr>\n" +
        "<tr><td>File: </td><td> " + filename + "</td></tr>\n" +
        "<tr><td>File signature: </td><td> " + report["FILE_MD5"] + "</td></tr>\n" +
        "<tr><td>Threat signature: </td><td> " + report["THREAT_SIG"] + "</td></tr>\n" +
        "<tr><td>Threat name: </td><td> " + report["THREAT_NAME"] + "</td></tr>\n" +
        "<tr><td>Threat: </td><td> " + threat + "</td></tr>\n" +
        "<tr><td>Details: </td><td> " + report["DETAILS"] + "</td></tr>\n" +
        "</table>\n" +
        "<div class='btn-group btn-group-xs'>\n" +
        "<button type='button' class='button-primary btn-sm' onclick='ezyRemoveFromIgnoreList(\"" +
        file_md5 + "\",\"" +
        threat_sig + "\")'>Remove from Ignore List</button>\n" +
        "</div>\n";
    "</div>\n";
}



function ezyReloadIgnoredThreatsReport() {
    console.log("ezyReloadIgnoredThreatsReport");

    ezyShowEmptyIgnoreList();

    jQuery.ajax({
        data: {
            action: 'scanner-get_ignored_threats',
            _wpnonce: '<?php echo $nonce; ?>',
        },
        success: function(r) {
            //console.log(r);
            var threats = jQuery.parseJSON(r);

            if (Array.isArray(threats)) {
                ezyCleanIgnoreThreatsReport();
                threats_to_show = 100;

                if (threats_to_show > threats.length) {
                    threats_to_show = threats.length;
                }

                if (threats_to_show != 0) {
                    for (var i = 0; i < threats_to_show; i++) {
                        ezyAddToIgnoredThreatsReport(threats[i]);
                    }
                } else {
                    console.log("Ignored list is clean");
                    ezyShowEmptyIgnoreList();
                }
            } else {
                console.log("Retrieved invalid output: " + r);
            }
        } //end of success function
    });
}


function ezyWhitelistFile(file_sig) {
    document.getElementById(file_sig).innerHTML = "<center>Working</center>";
    jQuery.ajax({
        data: {
            action: 'scanner-whitelist_file',
            _wpnonce: '<?php echo $nonce; ?>',
            FILE_MD5: file_sig,
        },
        success: function(r) {
            console.log(r);
            console.log("ezyWhitelistFile operation succeeded");
            ezyReloadDetectedThreatsReport();
        } //end of success function
    });

}

function ezyWhitelistThreat(file, threat) {
    jQuery.ajax({
        data: {
            action: 'scanner-whitelist_threat',
            _wpnonce: '<?php echo $nonce; ?>',
            FILE_MD5: file,
            THREAT_SIG: threat,
        },
        success: function(r) {
            console.log(r);
            console.log("ezyWhitelistThreat: operation succeeded");
            ezyReloadDetectedThreatsReport();
        } //end of success function
    });
}



function ezyShowEmptyIgnoreList() {
    /*
     * First two lines used to refresh element if it is shown
     */
    /*
    document.getElementById('ignored_threats_report').style.display = 'none';
    document.getElementById('ignored_threats_report').style.display = 'block';
    document.getElementById("ignored_threats_report").innerHTML = "<center><p>No entries have been found</p></center>";
    */
}


function ezyCleanIgnoreThreatsReport() {
    document.getElementById("ignored_threats_report").innerHTML = "";
}


function ezyIgnoreThreat(file, threat) {
    jQuery.ajax({
        data: {
            action: 'scanner-ignore_threat',
            _wpnonce: '<?php echo $nonce; ?>',
            FILE_MD5: file,
            THREAT_SIG: threat,
        },
        success: function(r) {
            /* 
             * refresh content of the tab
             */
            ezyReloadDetectedThreatsReport();
        } //end of success function
    });
}


function ezyRemoveFromIgnoreList(file, threat) {
    jQuery.ajax({
        data: {
            action: 'scanner-unignore_threat',
            _wpnonce: '<?php echo $nonce; ?>',
            FILE_MD5: file,
            THREAT_SIG: threat,
        },
        success: function(r) {
            /* 
             * refresh content of the tab
             */
            ezyReloadIgnoredThreatsReport();
        } //end of success function
    });
}


function ezyRunHeurInternalScan(level) {
    ezyLogMessage("INFO", "Submitting high sensitive internal scan request");

    jQuery.ajax({
        data: {
            action: 'scanner-run_heur_internal_scan',
            _wpnonce: '<?php echo $nonce; ?>',
        },


        timeout: 3000, // sets timeout to 3 seconds

        error: function(jqXHR, textStatus) {
            ezyLogMessage("INFO", "High sensitive internal scan request submitted");
        },
        success: function(r) {
            ezyLogMessage("INFO",
                "Operation succeeded. High sensitive internal scan started");
        } //end of success function
    });

    ezyReloadExecutionStatus();
};

function ezyShowFile(path) {
    ezyLogMessage("INFO", "show file " + path);

    jQuery.ajax({
        data: {
            action: 'scanner-show_file',
            FILE_PATH: path,
            _wpnonce: '<?php echo $nonce; ?>',
        },

        timeout: 60000, // sets timeout to 60 seconds

        error: function(jqXHR, textStatus) {
            ezyLogMessage("INFO", "Show file request submitted but failed");
        },
        success: function(r) {
            //console.log(r);
            var data = r;
            var winPrint = window.open('', '',
                'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=1,status=0');
            winPrint.document.write(
                "<script src=\"https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js\"><\/script>"
            );
            data = data.replace(/</g, "&lt;");
            data = data.replace(/>/g, "&gt;");
            //console.log(data);
            winPrint.document.write("<pre class=\"prettyprint\"><code>\r\n" + data +
                "\r\n</code></pre>");
            winPrint.document.close();
        } //end of success function
    });
}

function ezyLogMessages(messages) {
    var body = "";
    for (var i = 0; i < messages.length; i++) {
        /* index 0 is line number */
        var line = messages[i][1] + "\t" + messages[i][2] + "\n";
        if (log_lines.length >= max_log_lines) {
            /*
             * removes first line from front
             */
            log_lines.shift();
        }
        log_lines.push(line);
        body += line;
    }

    document.getElementById("log").value = body;
    document.getElementById("log").scrollTop = document.getElementById("log").scrollHeight;
}


function ezyLogMessage(severity, message) {
    if (!severity || !message) {
        return;
    }

    var log_line = severity + "\t" + message;

    if (log_lines.length >= max_log_lines) {
        /*
         * removes first line from front
         */
        log_lines.shift();
    }

    log_lines.push(log_line);

    var body = "";
    for (var i = 0; i < log_lines.length; i++) {
        body += log_lines[i] + "\n";
    }

    document.getElementById("log").value = body;
    document.getElementById("log").scrollTop = document.getElementById("log").scrollHeight;
}


function ezyUpdateExecutionStats(counters) {
    var start = new Date(counters["START_TIME"] * 1000);
    var ds = start.toDateString();
    var ts = start.toTimeString();
    document.getElementById("scan_start_time").innerHTML = ds + " " + ts; //start.toTimeString();
    document.getElementById("total_scanned_files").innerHTML = counters["TOTAL"];
    document.getElementById("scanned_clean_files").innerHTML = counters["CLEAN"];
    document.getElementById("scanned_pos_suspicious_files").innerHTML = counters["POT_SUSPICIOUS"];
    document.getElementById("scanned_suspicious_files").innerHTML = counters["SUSPICIOUS"];
    document.getElementById("scanned_malicious_files").innerHTML = counters["MALICIOUS"];
}


/**
 * @brief       cut off too long parts of path to shorter form with dots
 * @param[in]   path    - path to convert
 * @param[in]   maxlen  - maximal permitted length
 * @return      converted path
 */
function ezyStripFilePath(path, maxlen) {
    if (path.length <= maxlen) {
        return path;
    }

    name_pos = path.lastIndexOf("/");
    name = path.substring(name_pos);
    path_part_end = maxlen - name.length - 5;
    path_part = path.substring(0, path_part_end) + "/..." + name;
    return path_part;
}
</script>