<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
global $wpdb;
$table_name = $wpdb->prefix . 'config';

if (!isset($wpdb->dbh)) {
    echo "Error: Database connection not established";
    exit;
}

if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      value int(11) NOT NULL,
      PRIMARY KEY (id)
    );";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    // echo "Table created successfully.";
} else {
    // echo "Table already exists.";
}

$row = $wpdb->get_row("SELECT * FROM $table_name WHERE value = 1");
  
if ($row) {
    if ($row->value == 1) {
        echo "<script>window.location = '/wp-admin/admin.php?page=ezy_sc';</script>";
        exit;
    }
}

if (!$row) {
  $wpdb->insert($table_name, array('value' => 1));

} else {
}

?>
<?php
// Connect to the database
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
          $conn = @mysqli_connect($decrypted_host, $decrypted_username, $decrypted_password, $decrypted_db_name, $decrypted_port);

// Check for database connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Check if the form has been submitted
if (isset($_POST['logged_in'])) {
    // Get the form data
    $owner = mysqli_real_escape_string($conn, $_POST['owner']);
    $web_type = mysqli_real_escape_string($conn, $_POST['web_type']);
    $mail_id = mysqli_real_escape_string($conn, $_POST['mail_id']);

    // Check if the user exists in the database
    $sql = "SELECT * FROM clients WHERE owner='$owner' AND web_type='$web_type' AND mail_id='$mail_id'";
    $result = $conn->query($sql);

    // Check if the query returns a record
    if ($result->num_rows > 0) {
        $data = array(
            'value' => 1
        );
        $where = array(
            'id' => 1
        );
        $wpdb->update($table_name, $data, $where);        
        echo "<style>#popingup{display:none;}</style>
        <script>alert('Hey $owner, you are successfully Verified. ');</script>";

        echo "<script>window.location = '/wp-admin/admin.php?page=ezy_sc';</script>";
        // header("location:admin.php?page=ezy_sc");
                // header("location:  http://testbikswee.free.nf/wp-admin/admin.php");

    } else {
        echo "<style>#popingup{display:block;}</style><script>alert('you are not verified');</script>";
    }
}
}
?>

<html>

<head>
    <title>EaZY Security</title>
</head>

<body>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EaZY Security verification</h4>
            </div>
            <div class="modal-body" style="
    display: flex;
    flex-direction: row;
">

                <form id="verification-form" method="post" action="" style="padding-left: 51px;">
                    <div class="form-group">
                        <label>Owner</label>
                        <input type="text" name="owner" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="mail_id" required>
                    </div>
                    <div class="form-group">
                        <label>number</label>
                        <input type="number" name="web_type" required>
                    </div>
                    <input type="submit" name="logged_in" id="logged_in" value="Login" style="
    background: white;
    padding: 10px 20px 10px 20px;
    border-radius:10px;
">
                </form>
                <div id="content" style="
    padding: 76px;
">
                    <h2 style="color:blue;">EaZy Security!</h2>
                    <p>
                        hey user kindly verify your existence in our system, if you purchased recently
                        kindly wait 24 hour for reflect in our system
                        warm regards from eazy security powered by bikswee solutions
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>