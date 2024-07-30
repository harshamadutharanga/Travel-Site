<?php
include('booking.config.php');

// Check if the notification ID is received
if(isset($_POST['id'])) {
    // Retrieve the notification ID from the POST data
    $notificationId = $_POST['id'];

    // Update the database to mark the notification as read (i.e., set active to 0)
    $sql = "UPDATE bookingdata SET active = 0 WHERE id = $notificationId";

    if(mysqli_query($con, $sql)) {
        echo "Notification marked as read successfully";
    } else {
        echo "Error marking notification as read: " . mysqli_error($con);
    }
} else {
    echo "Notification ID not provided";
}
?>
