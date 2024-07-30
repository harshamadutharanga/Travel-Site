<?php 
session_start();
$con = mysqli_connect('localhost', 'root', '', 'harsha');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$email = "";
$name = "";
$errors = array();

if(isset($_POST['book'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $residence = mysqli_real_escape_string($con, $_POST['residence']);
    $arrivaldate = mysqli_real_escape_string($con, $_POST['arrivaldate']);
    $depaturedate = mysqli_real_escape_string($con, $_POST['depaturedate']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $dlocation = mysqli_real_escape_string($con, $_POST['dlocation']);
    $vtype = mysqli_real_escape_string($con, $_POST['vtype']);
    $npessanger = mysqli_real_escape_string($con, $_POST['npessanger']);
    $srequest = mysqli_real_escape_string($con, $_POST['srequest']);
    $pvisit = mysqli_real_escape_string($con, $_POST['pvisit']);

    $email_check = "SELECT * FROM bookingdata WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);
    if(mysqli_num_rows($res) > 0){
        $errors['email'] = "Email that you have entered is already exist!";
    }

    
    if(count($errors) === 0){
        $insert_data = "INSERT INTO bookingdata (name, email, phone, residence, arrivaldate, depaturedate, location, dlocation, vtype, npessanger, srequest, pvisit, active)
        values('$name', '$email', '$phone', '$residence', '$arrivaldate', '$depaturedate', '$location', '$dlocation', '$vtype','$npessanger', '$srequest', '$pvisit', '1')";

        $name_parts = explode(" ", $name);
        $first_name = $name_parts[0];

        $data_check = mysqli_query($con, $insert_data);
        $mail = new PHPMailer(true); // Instantiate PHPMailer object
        
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
        $mail->addAddress('harsha.p@arpico.com', 'Harsha Palihawadana'); 
        $mail->addAddress($email); // Assuming $name is defined somewhere

        
    // Optionally, you can use CC or BCC if needed
        $mail->addCC('harsha.p@arpico.com');
        $mail->addCC('ravindu.dh@arpico.com', 'DARME');
        $mail->addCC('ravindu.m@arpico.com', 'Tharushi');
        $mail->addBCC('ravindu.m@arpico.com', 'Tharushi');
        
        // Content
        $mail->isHTML(true);                     // Set email format to HTML
        $mail->Subject = 'Booking Successful';
        $mail->Body = "
        <div style='background-image: url(https://img.freepik.com/free-photo/plant-against-blue-wall-background-with-copy-space_53876-98324.jpg); background-size: cover; padding: 20px; border-radius: 10px;'>

        <div class='card' style='width: 80%; margin: auto;'>
        <div style='background-color: #234652; color: white; padding: 20px; border-radius: 10px 10px 0 0;'>
            <h2 style='font-family: courier;'>Your Booking Is Successful.</h2>
        </div>
        <div class='card-body' style='padding: 20px; background-color: white; border-radius: 0; border-top: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
            <div style='margin-bottom: 20px;'>    
                <p style='margin-bottom: 20px;'>Dear $first_name, We hope you are happy <span style='font-weight: bold;'>Good Luck!</span>.</p>
                <p><span style='font-weight: bold; font-family: courier;'>Name</span>: $name</p>
                <p><span style='font-weight: bold;'>Email</span>: $email</p>
                <p><span style='font-weight: bold;'>TP No</span>: $phone</p>
                <p><span style='font-weight: bold;'>Residence</span>: $residence</p>
                <p><span style='font-weight: bold;'>Date of Arrival</span>: $arrivaldate</p>
                <p><span style='font-weight: bold;'>Date of Departure</span>: $depaturedate</p>
                <p><span style='font-weight: bold;'>Pick Location</span>: $location</p>
                <p><span style='font-weight: bold;'>Drop Location</span>: $dlocation</p>
                <p><span style='font-weight: bold;'>Vehicle Type</span>: $vtype</p>
                <p><span style='font-weight: bold;'>Passenger</span>: $npessanger</p>
                <p><span style='font-weight: bold;'>Passenger</span>: $srequest</p>
                <p><span style='font-weight: bold;'>Passenger</span>: $pvisit</p>
                <p>Your Booking Price is: Rs. 35,700.00 <span style='color:red'>Please pay before AUGUST 05, 2024</span></p>
            </div>
        </div>
        <div style='background-color: white; color:#808080; padding: 20px; border-radius: 0 0 10px 10px;'>
            <small>Thank you.</small><br>
            <small>Ceylon Expeditions travels.</small><br>
            <small>Manager of CET.</small>
        </div>
        </div>
            
        </div>";

        // Send email
        if($mail->send()) {
            $_SESSION['success'] = "Booking Successful!";
            header("Location: booking.php");
        } else {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: booking.php"); // Redirect back to the form
        exit(); 
    }

}
?>
