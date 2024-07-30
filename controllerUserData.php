<?php 
session_start();
require "connection.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$email = "";
$name = "";
$phone = "";
$errors = array();

//if user signup button
if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "Confirm password not matched!";
    }
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);
    if(mysqli_num_rows($res) > 0){
        $errors['email'] = "Email that you have entered is already exist!";
    }
    if(count($errors) === 0){
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
        $insert_data = "INSERT INTO usertable (name, email, phone, password, code, status)
                        values('$name', '$email', '$phone', '$encpass', '$code', '$status')";

        $name_parts = explode(" ", $name);
        $first_name = $name_parts[0];

        $data_check = mysqli_query($con, $insert_data);
        if($data_check){
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'techsparedhswd@gmail.com'; // Your Gmail address
                $mail->Password   = 'sdps dpcm ghzb vahu'; // Your Gmail password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('techsparedhswd@gmail.com', 'HSWD TECHSPARD TRAVELS');
                $mail->addAddress($email, $name);

                // Content
                $mail->isHTML(true);                     // Set email format to HTML
                $mail->Subject = 'Email Verification Code';
                $mail->isHTML(true);                     // Set email format to HTML                
                $mail->Body = "
                <div style='background-image: url(https://img.freepik.com/free-photo/plant-against-blue-wall-background-with-copy-space_53876-98324.jpg); background-size: cover; padding: 20px; border-radius: 10px;'>
        
                <div class='card' style='width: 80%; margin: auto;'>
                <div style='background-color: #234652; color: white; padding: 20px; border-radius: 10px 10px 0 0;'>
                    <h4>Dear $first_name </h4>
                    <h4> Welcome to the HSWD TECHSPARD TRAVELS</h4>
                </div>
                <div class='card-body' style='padding: 20px; background-color: white; border-radius: 0; border-top: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                    <div style='margin-bottom: 20px;'>    
                        <p style=' font-family: Arial, sans-serif;'>Your verification code is <span style='color: #A020F0; font-weight: bold;'>$code</span>.</p>
                        <p style=' font-family: Arial, sans-serif;'>Please don't share your OTP with anyone.</p>
                    </div>
                </div>
                <div style='background-color: white; color:#808080; padding: 20px; border-radius: 0 0 10px 10px;'>
                    <small>Thank you.</small><br>
                    <small>HSWD TECHSPARD TRAVELS.</small><br>
                    <small>Manager of CET.</small>
                </div>
                </div>
            
        
                
                </div>";
                
            

                $mail->send();
                
                $info = "We've sent a verification code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            } catch (Exception $e) {
                $errors['otp-error'] = "Failed while sending code!";
                // Add error handling here, e.g., log the error or display a message to the user
                echo "Failed to send email. Please contact the site administrator.";
            }
        }else{
            $errors['db-error'] = "Failed while inserting data into database!";
        }
    }
}
    //if user click verification code submit button
    if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        $otp_code = "";
        $otp_code .= mysqli_real_escape_string($con, $_POST['digit1']);
        $otp_code .= mysqli_real_escape_string($con, $_POST['digit2']);
        $otp_code .= mysqli_real_escape_string($con, $_POST['digit3']);
        $otp_code .= mysqli_real_escape_string($con, $_POST['digit4']);
        $otp_code .= mysqli_real_escape_string($con, $_POST['digit5']);
        $otp_code .= mysqli_real_escape_string($con, $_POST['digit6']);
        $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){            
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $status = 'verified';
            $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
            $update_res = mysqli_query($con, $update_otp);
            if($update_res){

                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'techsparedhswd@gmail.com'; // Your Gmail address
                    $mail->Password   = 'sdps dpcm ghzb vahu'; // Your Gmail password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
    
                    // Recipients
                    $mail->setFrom('techsparedhswd@gmail.com', 'HSWD TECHSPARD TRAVELS');
                    $mail->addAddress($email, $name);
    
                    // Content
                    $mail->isHTML(true);                     // Set email format to HTML
                    $mail->Subject = 'Email Verification Code';
                    $mail->isHTML(true);                     // Set email format to HTML                
                    $mail->Body = "

                    <div style='background-image: url(https://img.freepik.com/free-photo/plant-against-blue-wall-background-with-copy-space_53876-98324.jpg); background-size: cover; padding: 20px; border-radius: 10px;'>
            
                    <div class='card' style='width: 80%; margin: auto;'>
                    <div style='background-color: #234652; color: white; padding: 20px; border-radius: 10px 10px 0 0;'>
                        <h4>Welcome to the HSWD TECHSPARD TRAVELS</h4>
                    </div>
                    <div class='card-body' style='padding: 20px; background-color: white; border-radius: 0; border-top: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                        <div style='margin-bottom: 20px;'>    
                            <p style='font-family: Arial, sans-serif;'>Your email verification is Done.</p>
                        </div>
                    </div>
                    <div style='background-color: white; color:#808080;   padding: 20px; border-radius: 0 0 10px 10px;'>
                        <small>Thank you.</small><br>
                        <small>HSWD TECHSPARD TRAVELS.</small><br>
                        <small>Manager of CET.</small>
                    </div>
                    </div>
                
            
                    
                    </div>";
                    
                
    
                    $mail->send();
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    header('location: home.php');
                    exit();
                } catch (Exception $e) {
                    $errors['otp-error'] = "Failed while sending code!";
                    // Add error handling here, e.g., log the error or display a message to the user
                    echo "Failed to send email. Please contact the site administrator.";
                }
            }else{
                $errors['otp-error'] = "Failed while updating code!";
            }
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

    //if user click login button
    if(isset($_POST['login'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $check_email = "SELECT * FROM usertable WHERE email = '$email'";
        $res = mysqli_query($con, $check_email);
        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            $fetch_pass = $fetch['password'];
            if(password_verify($password, $fetch_pass)){
                $_SESSION['email'] = $email;
                $status = $fetch['status'];
                if($status == 'verified'){
                  $_SESSION['email'] = $email;
                  $_SESSION['password'] = $password;
                    header('location: home.php');
                }else{
                    $info = "It's look like you haven't still verify your email - $email";
                    $_SESSION['info'] = $info;
                    header('location: user-otp.php');
                }
            }else{
                $errors['email'] = "Incorrect email or password!";
            }
        }else{
            $errors['email'] = "It's look like you're not yet a member! Click on the bottom link to signup.";
        }
    }

//if user click continue button in forgot password form
if(isset($_POST['check-email'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $check_email = "SELECT * FROM usertable WHERE email='$email'";
    $run_sql = mysqli_query($con, $check_email);
    if(mysqli_num_rows($run_sql) > 0){
        $code = rand(999999, 111111);
        $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($con, $insert_code);
        if($run_query){
            // Initialize PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'techsparedhswd@gmail.com'; // Your Gmail address
                $mail->Password   = 'sdps dpcm ghzb vahu'; // Your Gmail password
                $mail->addCC('harsha.p@arpico.com');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('techsparedhswd@gmail.com', 'HSWD TECHSPARD TRAVELS');
                $mail->addAddress($email, $name);

                // Content
                $mail->isHTML(true);                     // Set email format to HTML
                $mail->Subject = 'Email Verification Code';
                $mail->Body    = "Your verification code is $code";

                $mail->send();

                $info = "We've sent a password reset OTP to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } catch (Exception $e) {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}

    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

    //if user click change password button
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $update_pass = "UPDATE usertable SET code = $code, password = '$encpass' WHERE email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                $info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                $errors['db-error'] = "Failed to change your password!";
            }
        }
    }
    
   //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login-user.php');
    }
?>