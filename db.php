<script src="script.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<?php
// $ServerName = "localhost";
// $dbUserName = "root";
// $dbPassword = "";
// $dbName = "cib";
$ServerName = "sql309.infinityfree.com";
$dbUserName = "if0_35166212";
$dbPassword = "cI6pBsJFfUx";
$dbName = "if0_35166212_global";

$con = mysqli_connect($ServerName, $dbUserName, $dbPassword, $dbName);

if (!$con){
    die("connection Failed: " . mysqli_connect_error());
}

function getData($con){
    $sql = "SELECT * FROM `clients`;";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resutData = mysqli_stmt_get_result($stmt);
        $solution = array();
        while ($row = mysqli_fetch_assoc($resutData))
            {
                #print_r($row);
                array_push($solution,$row);
            }
        if($solution){
            return $solution;
        }
        else{
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
}

function getData2($con, $name){
    $sql = "SELECT * FROM `clients` WHERE `Owner` = ? OR `Web_Type` = ?;";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $name, $name);
        mysqli_stmt_execute($stmt);

        $resutData = mysqli_stmt_get_result($stmt);
        $solution = array();
        while ($row = mysqli_fetch_assoc($resutData))
            {
                #print_r($row);
                array_push($solution,$row);
            }
        if($solution){
            return $solution;
        }
        else{
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
}

function getParticularData($con,$mail,$pass){
    $sql = "SELECT * FROM `admin` WHERE `Mail`= ?;";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: #?Error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $mail);
    mysqli_stmt_execute($stmt);

    $resutData = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($resutData)){
        $db_pass_hashed = $row["Password"];
        $check_pass = password_verify($pass, $db_pass_hashed);
        mysqli_stmt_close($stmt);
        if($check_pass === false){
            header("location: login.php?WrongPassword");
            exit();
        }
        elseif($check_pass === true){
            session_start();
            $_SESSION['login'] = 'successful';
            header("location: admin_panel.php");
            exit();
        }
    }
    else{
        mysqli_stmt_close($stmt);
        header("location: login.php?WrongUser");
        exit();
    }
        
}

function changeData($con,$i,$type){
    $results = getData($con);
    $sql = "UPDATE `clients` SET `IsActive`='".$type."' WHERE `Mail_ID`='".$results[$i]['Mail_ID']."';";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
}

function AutoChangeData($con,$i,$type){
    $sql = "UPDATE `clients` SET `IsActive`='".$type."' WHERE `Mail_ID`='".$i."';";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
}

function AutoUpdateData($con,$mail,$pass){
    $sql = "UPDATE `admin` SET `Password`='".$pass."' WHERE `Mail`='".$mail."';";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
}

function multiChangeData($con,$i,$type){
    $sql = "UPDATE `clients` SET `IsActive`='".$type."' WHERE `Mail_ID`='".$i."';";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
}

function inserData($con,$owner,$website,$web_type,$status,$validity,$mail_id){
    $date = date('Y-m-d') . " 23:59:59";
    $ExDate = date('Y-m-d H:i:s', strtotime($date. ' + '.$validity.' months'));
    $sql = "INSERT INTO `clients`(`Owner`, `Website`, `Web_Type`, `IsActive`, `Date_Renewed`, `Date_Expires`, `Subscription_Validity(Months)`, `Mail_ID`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?, ?);";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: #?Error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssssss", $owner, $website, $web_type, $status, $ExDate, $validity, $mail_id);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        echo "<script type='text/JavaScript'>
        send_mail2('".(string)$owner."',"."'". (string)$website."',"."'". (string)$status."',"."'". (string)$ExDate."',"."'". (string)$validity."',"."'". (string)$mail_id."');
            </script>";
            print("Please Wait");
            ?><centre><img src="Loading.gif" id="myLoadingGif" style="width: 100vh; height: 100vh; margin-left : 50vh;"></centre><?php
            exit();
        return true;
    }
    return false;
}

function adminInserData1($con,$mail,$pass,$position){
    $sql = "INSERT INTO `admin`(`Mail`, `Password`, `Position`) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: #?Error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sss", $mail, $pass, $position);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        return true;
    }
    return false;
}

function adminInserData2($con,$mail,$pass){
    $sql = "INSERT INTO `admin`(`Mail`, `Password`) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: #?Error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $mail, $pass);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        return true;
    }
    return false;
}

function multiDeleteData($con,$Mail_ID){
    $sql = "DELETE FROM `clients` WHERE `Mail_ID` = ?;";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: #?Error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $Mail_ID);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        return true;
    }
    return false;
}

if(isset($_POST['Aindex'])) {
    AutoChangeData($con,$_POST['Aindex'],$_POST['type']);
}

if(isset($_POST['Dindex'])) {
    foreach ($_POST['Dindex'] as $value) {
        multiDeleteData($con,$value);
    }
}

if(isset($_POST['index'])) {
    changeData($con,$_POST['index'],$_POST['type']);
    echo($_POST['type']);
    echo($_POST['index']);
}

if(isset($_POST['Mindex'])) {
    foreach ($_POST['Mindex'] as $value) {
        multiChangeData($con,$value,$_POST['type']);
    }
}
