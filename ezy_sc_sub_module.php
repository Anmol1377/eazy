 <html>

 <head>
     <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'> -->
 </head>
 <STYle>
.ANIMATE {
    perspective: 1000px;
    -webkit-perspective: 1000px;
    display: flex;
    justify-content: center;
    font-size: 30px;
}

.ANIMATE>span {
    display: inline-block;
    color: black;
    transform-style: preserve-3d;
    transform-origin: 0 100%;
    animation: anim 3s infinite linear;
}

.ANIMATE>span:nth-child(even) {
    color: #00ed64;
}

.ANIMATE>span:nth-child(2) {
    animation-delay: 0.2s;
}

.ANIMATE>span:nth-child(3) {
    animation-delay: 0.4s;
}

.ANIMATE>span:nth-child(4) {
    animation-delay: 0.6s;
}

.ANIMATE>span:nth-child(5) {
    animation-delay: 0.8s;
}

.ANIMATE>span:nth-child(6) {
    animation-delay: 1s;
}

.ANIMATE>span:nth-child(7) {
    animation-delay: 1.2s;
}

.ANIMATE>span:nth-child(8) {
    animation-delay: 1.4s;
}

.ANIMATE>span:nth-child(9) {
    animation-delay: 1.6s;
}

.ANIMATE>span:nth-child(10) {
    animation-delay: 1.8s;
}

.ANIMATE>span:nth-child(11) {
    animation-delay: 2s;
}

.ANIMATE>span:nth-child(12) {
    animation-delay: 2.2s;
}

.ANIMATE>span:nth-child(13) {
    animation-delay: 2.4s;
}

.ANIMATE>span:nth-child(14) {
    animation-delay: 2.6s;
}

@keyframes anim {
    35% {
        transform: rotateX(360deg);
    }

    100% {
        transform: rotateX(360deg);
    }
}
 </STYle>

 <body id="body">
     <?php
        // Set the key and IV
        include_once 'ezy_sc_k.php';
        include_once 'ezy_sc_i.php';
        
        
        // Send a request to the randomuser.me API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://security.bikswee.com/api/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        
        // Decode the JSON response
        $data = json_decode($response, true);
        
        if ($data !== null) {
          // Get the first record from the data array
          $record = $data['data'][0];
        
          // Extract the host, username, password, and port from the record
          $ServerName = $record['host'];
          $dbUserName = $record['username'];
          $dbPassword = $record['password'];
          $port = $record['port'];
          $dbName = $record['db_name'];
        
          // Decrypt the host
          $decrypted_host = openssl_decrypt($ServerName, 'aes-256-cbc', $key, 0, $iv);
          $decrypted_username = openssl_decrypt($dbUserName, 'aes-256-cbc', $key, 0, $iv);
          $decrypted_password = openssl_decrypt($dbPassword, 'aes-256-cbc', $key, 0, $iv);
          $decrypted_port = openssl_decrypt($port, 'aes-256-cbc', $key, 0, $iv);
          $decrypted_db_name = openssl_decrypt($dbName, 'aes-256-cbc', $key, 0, $iv);
        
          // Connect to database
          $con = @mysqli_connect($decrypted_host, $decrypted_username, $decrypted_password, $decrypted_db_name, $decrypted_port);
          if (!$con){
            die("<div class='ANIMATE'>
            <span>N</span>
            <span>O</span>
            <span>T</span>
            <span>_</span>
            <span>V</span>
            <span>E</span>
            <span>R</span>
            <span>I</span>
            <span>F</span>
            <span>I</span>
            <span>E</span>
            <span>D</span>
          </div>
          <p style='
          display: flex;
          justify-content: center;
          font-size: 20px;
          margin-top: 3rem;
      '>Maybe you haven't the right to use or else we are still processing your order kindly give us 24 hours after a successful transaction</p>
      <div class='a' style='display:flex;justify-content:center;'>
      <a target='_blank' href='https://security.bikswee.com'>Viste Site</a>
      <a style='margin-left:20px;' href='mailto:anmol@bikswee.com'>Mail Us!</a>
     
      </div>");
          }
        
        } else {
          // The response was not valid JSON
          echo "Error: Invalid JSON response";
        }
        
        // Function to get data from the database
        function getData($con, $webname){
          $sql = "SELECT * FROM `clients` WHERE `Website` = ?;";
          $stmt = mysqli_stmt_init($con);
          if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
          }
        
          mysqli_stmt_bind_param($stmt, "s", $webname);
          mysqli_stmt_execute($stmt);
        
          $resultData = mysqli_stmt_get_result($stmt);
          if($row = mysqli_fetch_assoc($resultData)){
            return $row;
          } else {
            $result = false;
            return $result;
          }
        
                     mysqli_stmt_close($stmt);
             }

             $results = getData($con, $_SERVER['SERVER_NAME']);
             if($results){
             if(strtolower($results['IsActive']) === 'false'){
                 echo '<div style="height:100%;width:100%;background-color: rgba(61, 60, 66, 0.7);z-index: 9999;display:flex;
                 flex-direction: column;margin-top: 1rem;"><div id="subscription_panel">
                     <div id="popingup">
                         <div class="modal fade show" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" style="display: block;background-color: #000000d1;">
                         <div class="modal-dialog modal-lg">
                             <div class="modal-content">
                             <div class="modal-header">
                                 <h4 class="modal-title" id="myModalLabel">EaZY Security</h4>
                             </div>
                             <div class="modal-body">
                                 <h3>Subscription END!!! </h3>
                             </div>

                             <div class="modal-body">
                                 <h5>Renew Officilly from us for keep your data safe. </h5>
                             </div>
                             <div class="modal-body">
                                 <p>This is a reminder that your Web Protection Service has already ended. This Puts Your Website Open For Hackers
                         And Attacker To Take Over. This could Result Into A Serious Data Breech and could Jeopardize Your User\'s Privacy. Well Lucky for
                         You There Is A Quick Fix. You Can Just Renew Your Web Protection Service From EaZy Security In Few Simple Steps. Use Any One Of
                         The Following Methods To Activate Your Subscription In Less Than 10 Minutes.
                                 </p>
                               
                             </div>
                             <div class="modal-footer">
                                 <a href="https://shop.bikswee.com/#pricing"><button style="cursor: pointer;"  type="button" class="btn btn-primary"><i class="fa fa-globe"></i>&nbsp;Renew Now</button></a>
                                 <a href="mailto:contact@bikswee.com"><button style="cursor: pointer;"  type="button" class="btn btn-primary"><i class="fa fa-envelope"></i>&nbsp;Mail Us </button></a>
                             </div>
                             </div>
                         </div>
                        </div>
                        
                     </div>
                 </div>
                 </div>';
             }
         }
    ?> </body>

 </html>