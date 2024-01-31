<?php
// Admin recipient email id
$toEmail = 'contact@bikswee.com';

$status = 0;
$statusMsg = 'Oops! Something went wrong! Please try again late.';
if(isset($_POST['contact_submit'])){
    // Get the submitted form data
    $email = $_POST['email'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    // $file = $_POST['file'];
    // $c_name = $_POST['c_name'];
    // $date = $_POST['date'];
    // $time = $_POST['time'];
    // $c_website = $_POST['c_website'];
    $message = $_POST['message'];
    
    // Check whether submitted data is not empty
    if(!empty($email) && !empty($name) && !empty($message)){
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $statusMsg = 'Please enter a valid email.';
        }else{
            $emailSubject = 'Eazy security Wordpress Help From '.$name;
            $htmlContent = '<h2>Help Request Submitted</h2>
                <h4>Name : '.$name.' </h4>
                <h4>Email : '.$email.'</h4>
                <h4>Number : '.$number.'</h4>
                <h4>Message : '.$message.'</h4>';
            
            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // Additional headers
            $headers .= 'From: '.$name.'<'.$email.'>'. "\r\n";
            
            // Send email
            $sendEmail = mail($toEmail, $emailSubject, $htmlContent, $headers);
            if($sendEmail){
                $status = 1;
                $statusMsg = 'Thanks! Your contact request has been submitted successfully.';
            }else{
                $statusMsg = 'Failed! Your contact request submission failed, please try again.';
            }
        }
    }else{
        $statusMsg = 'Please fill in all the mandatory fields.';
    }
}

$response = array(
    'status' => $status,
    'message' => $statusMsg
);
echo json_encode($response);
?>