<?php 
require "booking.config.php";
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : array();
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : "";
?>

<!DOCTYPE html>
<html lang="en">
<script>
        setTimeout(function() {
            <?php
                unset($_SESSION['errors']);
                unset($_SESSION['success']);
                unset($_SESSION['notification_count']);
            ?>
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Booking Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css"> 
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</head>
<style>

@import url('https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap');

/*    body {
        overflow: hidden;
    }*/

    .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Ensure the navbar is above other content */
            background-color: #181C47;
            overflow: hidden; /* Ensure no overflow */
            
        }

    .container{
        border-radius: solid 1px;
        
    }

    .card{
        margin: 8%;
        background-image: url("imgs/images.jpg");
        background-size: cover;
        
    }

    .card-body{
        margin: 1%;
        
    }

    .blurred {
        filter: blur(1px); /* Adjust the blur amount as needed */
    }

    /* Styles for spinner */
    #spinner {
        position: fixed;
        padding-top: 10px;
        padding-right: 30px;
        padding-bottom: 10px;
        padding-left: 15px;
        background-color: white;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        box-shadow: 0 0 8px 2px rgba(0, 0, 0, 0.2);
    }

    body {
             margin:0 !important;
             padding:0 !important;
             box-sizing: border-box;
             font-family: 'Roboto', sans-serif;
        }


.round {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    position: absolute;
    top: 12px; /* Adjust the positioning here */
    right: 15px; /* Adjust the positioning here */
    background: red;
    padding: 0.3rem 0.2rem !important;
    z-index: 99 !important;
}


    .round > span {
          color:white;
          display:block;
          text-align:center;
          font-size:0.6rem !important;
          padding:0 !important;
    }

        #list{
          list-style: none;
          display: none;
          top: 10%;
          position: absolute;
          right: 2%;
          background:#ffffff;
          z-index:100 !important;
          width: 15vw;
          margin-left: -37px;   
          padding:0 !important;
          margin:0 auto !important;          
        }

        .message > span {
           width:100%;
           display:block;
           color:red;
           text-align:justify;
           margin:0.2rem 0.3rem !important;
           padding:0.2rem !important;
           line-height:0.5rem !important;
           font-weight:bold;
           border-bottom:1px solid white;
           font-size:1.1rem !important;

        }

        .message{
          /* background:#ff7f50;
          margin:0.3rem 0.2rem !important;
          padding:0.2rem 0 !important;
          width:100%;
          display:block; */
          
        }

        .message > .msg {
           width:90%;
           margin:0.2rem 0.3rem !important;
           padding:0.1rem 0.1rem !important;
           text-align:justify;
           font-weight:bold;
           display:block;
           word-wrap: break-word;
                   
        }

        h4{
            margin-bottom: 25px;
            color:  white ;
            font-weight: bold;
            font-family: 'Playfair Display', serif;
        }
       
        label{
            color: #fff;;
        }
</style>
<body>

<body>
     <?php
       $find_notifications = "Select * from bookingdata where active = 1";
       $result = mysqli_query($con,$find_notifications);
       $count_active = '';
       $notifications_data = array(); 
       $deactive_notifications_dump = array();
        while($rows = mysqli_fetch_assoc($result)){
                $count_active = mysqli_num_rows($result);
                $notifications_data[] = array(
                            "id" => $rows['id'],
                            "location"=>$rows['location'],
                            "pvisit"=>$rows['pvisit']
                );
        }
        //only five specific posts
        $deactive_notifications = "Select * from bookingdata where active = 0 ORDER BY id DESC LIMIT 0,5";
        $result = mysqli_query($con,$deactive_notifications);
        while($rows = mysqli_fetch_assoc($result)){
          $deactive_notifications_dump[] = array(
                      "id" => $rows['id'],
                      "location"=>$rows['location'],
                      "pvisit"=>$rows['pvisit']
          );
        }
        ?>


<nav class="navbar navbar-inverse">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <a class="navbar-brand" style="color:white" href="home.php"><i class='fas fa-chevron-circle-left' style='font-size:16px; margin-right:5px;'></i>Back</a>
                  </div>
                  <ul class="nav navbar-nav navbar-right">
                    <li><i class="fa fa-bell"   id="over" data-value ="<?php echo $count_active;?>" style="z-index:-99 !important; cursor: pointer; font-size:16px;color:white;margin:0.4rem 0.4rem !important;"></i></li>
                    <?php if(!empty($count_active)){?>
                    <div class="round" style="cursor: pointer;" id="bell-count" data-value ="<?php echo $count_active;?>"><span><?php echo $count_active; ?></span></div>
                    <?php }?>                    
                     </div>
                  </ul>
                 
                </div>
              </nav> 

              <div id="notificationDetails" >
                <!-- Notification details will be displayed here -->
                <?php if(!empty($count_active)){?>
                      <div id="list">
                       <?php
                          foreach($notifications_data as $list_rows){?>
                            <li id="message_items" >
                            <div class="message alert alert-warning"  data-id=<?php echo $list_rows['id'];?>>
                              <span><?php echo $list_rows['location'];?></span>
                              <div class="msg">
                                <p><?php 
                                  echo $list_rows['pvisit'];
                                ?></p>
                              </div>
                            </div>
                            </li>
                         <?php }
                       ?> 
                       </div> 
                     <?php }else{?>
                        <!--old Messages-->
                        <div id="list">
                        <?php
                          foreach($deactive_notifications_dump as $list_rows){?>
                            <li id="message_items">
                            <div class="message alert alert-danger" data-id=<?php echo $list_rows['id'];?>>
                              <span><?php echo $list_rows['location'];?></span>
                              <div class="msg">
                                <p><?php 
                                  echo $list_rows['pvisit'];
                                ?></p>
                              </div>
                            </div>
                            </li>
                         <?php }
                       ?>
                        <!--old Messages-->
                     
                     <?php } ?>                
              </div>

    <div class="container">
        <div class="card">
            <div class="card-body">

                <!-- Spinner -->
                <div id="spinner" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                    </div>
                    <span>Loading...</span>
                </div>


                <form action="bookform.php" method="POST" id="bookingForm">

                <!-- Success message -->
                <?php if (!empty($success_message)): ?>
                    <div id="dpmg" class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                    <audio id="notificationSound" autoplay>
                        <source src="audio/linkedin_notification.mp3" type="audio/mp3">
                    </audio>
                <script>
                    // Wait for the audio to be loaded before playing
                    document.getElementById("notificationSound").addEventListener("loadedmetadata", function() {
                        this.play();
                    });
                </script>

                <?php endif; ?>


                <!-- Display errors here -->
                <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                    
                    <h4>Vehicle Booking Form</h4>
                    
                    <!-- Personal Information -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="fullname">Full Name:</label>
                            <input type="text" class="form-control" id="fullname" name="name" required>
                        </div>

                    
                        <div class="form-group col-md-6">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" name="email" id="email" >
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="country">Country of Residence:</label>
                            <input type="text" class="form-control" id="country" name="residence" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="arrival">Date of Arrival:</label>
                            <input type="date" class="form-control" id="arrival" name="arrivaldate" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="departure">Date of Departure:</label>
                            <input type="date" class="form-control" id="departure" name="depaturedate" required>
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="options">Select Your Location:</label>
                            <select class="form-control" name="location" id="options">
                                <?php
                                    // Step 3: Populate location options dynamically
                                    $sql_locations = "SELECT DISTINCT location FROM booking"; 
                                    $result_locations = $conn->query($sql_locations);

                                    if ($result_locations->num_rows > 0) {
                                        while ($row = $result_locations->fetch_assoc()) {
                                            echo "<option value='" . $row['location'] . "'>" . $row['location'] . "</option>";
                                        }
                                    }
                                 ?>
                             </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="town">Drop-off Location:</label>
                            <input type="text" class="form-control" id="dlocation" name="dlocation" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="vehicle">Preferred Vehicle Type:</label>
                            <select class="form-control" id="vehicle" name="vtype">
                                <option value="sedan">Alto</option>
                                <option value="suv">BMW</option>
                                <option value="minivan">CAR(Vitz)</option>
                                <option value="bus">Bus</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="passengers">Number of Passengers:</label>
                            <input type="number" class="form-control" id="passengers" name="npessanger" min="1" required>
                        </div>
                    </div>

                    <!-- Additional Preferences -->
                    <div class="form-group">
                        <label for="special_req">Special Requests:</label>
                        <textarea class="form-control" id="special_req" name="srequest"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="places">Places to Visit:</label>
                        <textarea class="form-control" id="places" name="pvisit" ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button  id="submitBtn" type="submit" class="btn btn-primary" name="book">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $("#options").change(function () {
            var selectedOption = $(this).find("option:selected");
            var selectedTown = selectedOption.data("town");
            var selectedDistance = selectedOption.data("distance");

            $("#town").val(selectedTown);
            $("#distance").val(selectedDistance);
        });
    });

    </script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        // Event listener for form submission
        $("#bookingForm").submit(function () {
            // Show the spinner when the form is submitted
            $("#spinner").show();
            $("#bookingForm").addClass("blurred");
        });
    });
</script>

<script>
   // Function to hide success and error messages after few seconds
   setTimeout(function() {
    // Your action here for the element with ID 'dpmg'
    // For example, you can fade it out
    $("#dpmg").fadeOut('slow', function() {
        $(this).css({
            'opacity': '1', 
            'transform': 'scale(0.8)',  
            'transition': 'opacity 0.5s ease, transform 0.5s ease'  
        });
    });
    }, 8000);

</script>

<script>
$(document).ready(function(){
    var ids = new Array();
    $('#over').on('click',function(){
           $('#list').toggle();  
       });

   //Message with Ellipsis
   $('div.msg').each(function(){
       var len =$(this).text().trim(" ").split(" ");
      if(len.length > 12){
         var add_elip =  $(this).text().trim().substring(0, 65) + "…";
         $(this).text(add_elip);
      }
     
}); 


// Add click event listener to notification items
$('.message').on('click', function() {
    var notificationId = $(this).data('id');
    // Send AJAX request to mark notification as read
    $.ajax({
        url: 'deactive.php',
        type: 'POST',
        data: { id: notificationId },
        success: function(response) {
            // Reload the page or update the UI as needed
            location.reload(); // For example, reload the page after marking the notification as read
        },
        error: function(xhr, status, error) {
            console.error(error); // Handle error gracefully
        }
    });
});



   $('#notify').on('click',function(e){
        e.preventDefault();
        var name = $('#location').val();
        var ins_msg = $('#pvisit').val();
        if($.trim(name).length > 0 && $.trim(ins_msg).length > 0){
          var form_data = $('#bookingForm').serialize();
        $.ajax({
          url:'./booking.config.php',
                type:'POST',
                data:form_data,
                success:function(data){
                    location.reload();
                }
        });
        }else{
          alert("Please Fill All the fields");
        }
      
       
   });
});
</script>





</body>
</html>
<?php
// Close the database connection
$conn->close();
?>

