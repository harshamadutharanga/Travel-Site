<?php

require_once "controllerUserData.php";

// Check if email and password are set in the session
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    // Query the database to check the user's status
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);

    if ($run_Sql) {
        $fetch_info = mysqli_fetch_assoc($run_Sql);

        // If user data is found
        if ($fetch_info) {
            $status = $fetch_info['status'];
            $code = $fetch_info['code'];

            // If user is verified
            if ($status == "verified") {
                // If user has a code, redirect to reset-code.php
                if ($code != 0) {
                    header('Location: reset-code.php');
                    exit(); // Make sure to exit after redirecting
                }
            } else {
                // If user is not verified, redirect to user-otp.php
                header('Location: user-otp.php');
                exit(); // Make sure to exit after redirecting
            }
        } else {
            // If user data is not found, display a message and redirect to index.php
            echo '<script>
            if(confirm("Admin deleted you from the database or you are not a user. Harsha Palihawadana Admin Of Database")){
                window.location.href = "index.php";
            }
            </script>';
        }
    }
} else {
    // If email and password session variables are not set, redirect to login page
    header('Location: login-user.php');
    exit(); // Make sure to exit after redirecting
}
?>

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
                            "name"=>$rows['name'],
                            "location"=>$rows['location']
                );
        }
        //only five specific posts
        $deactive_notifications = "Select * from bookingdata where active = 0 ORDER BY id DESC LIMIT 0,5";
        $result = mysqli_query($con,$deactive_notifications);
        while($rows = mysqli_fetch_assoc($result)){
          $deactive_notifications_dump[] = array(
                      "id" => $rows['id'],
                      "name"=>$rows['name'],
                      "location"=>$rows['location']
          );
        }
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $fetch_info['name'] ?> | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Rajdhani', sans-serif;
            margin: 0;
            padding: 0;
        }

        #webcontent{
            border-top-width: 20px;
            margin: 50px;
            padding-top: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left:  auto;
            margin-right:  auto;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Ensure the navbar is above other content */
            background-color: #181C47;
            overflow: hidden; /* Ensure no overflow */
        }

        .navbar .ab {
            padding: 16px 20px;
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        .cd {
            padding: 16px 20px;
            float: right;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar .ab:hover {
            color: cyan;;
        }
        .navbar .cd:hover {
            color: red;
        }

        .navbar a.active {
            background-color: #4CAF50;
            color: white;
        }

        .navbar .icon {
            display: none;
        }
        
    @media screen and (max-width: 600px) {

        .navbar a:not(:first-child) {display: none;}
        .navbar a.icon {
            float: right;
            display: block;
        }

        .navbar.responsive {
            
        }


        .navbar.responsive .icon {
            position: absolute;
            right: 0;
            top: 0;
        }

        .navbar.responsive a {
            float: none;
            display: block;
            text-align: left;
        }

        div#bell-count {
            left: 37px;
            top: 115px;
        }

    }

    .fas{
        padding-right: 10px;
    }


    .round {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        position: absolute;
        top: 5px; /* Adjust the positioning here */
        left: 285px; /* Adjust the positioning here */
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
          box-shadow: 20px 20px 50px grey;
          top: 10px;
          left: 8px;
          position: absolute;
          background:#EFF0C1 ;
          z-index:100 !important;
          width: 300px;
          border-radius: 10px;
          margin-left: -37px;   
          padding: 10px; !important;
          margin:0 auto !important;         
        }

        .message > span {
           width:100%;
           display:block;
           color:#1a59d1;
           text-align:justify;
           margin:0.2rem 0.3rem !important;
           padding:0.1rem !important;
           line-height:0.01rem !important;
           font-weight:bold;
           font-size:1.1rem !important;

        }

        .message{
          margin:0.3rem 0.2rem !important;
          padding:0.1rem 0 !important;
          width:90%;
          display:block; 
          
        }

        .message > .msg {
           width:90%;
           margin:0.2rem 0.3rem !important;
           padding:0.1rem 0.1rem !important;
           text-align:justify;
           font-weight:bold;
           display:block;
           word-wrap: break-word;
           border-bottom:1px solid white;
           font-size:0.8rem !important;
         
          
        }

        #notificationDetails{
            position: relative;
        }

        .context{
            position: relative;
        }

        #iframe{
            border: 1px solid #ccc; /* Define your border */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Define the shadow */
            border-radius: 10px;
            position: fixed;
            right: 1%;
            top: 70%;
            transform: translateY(-50%);
            width: 350px;
            height: 430px;
            display: none; /* Initially hide the iframe */
        }

        .chat{
            position: fixed;
            color:green;
            font-size: 24px;
            right: 1%;
            top: 94%;
            background-color:#FFFDD0;
            padding:5px;
            border-radius: 10px;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
        }

        .left-content {
            flex: 1;
        }

        .right-content {
            margin-left: 10px; /* Adjust as needed */
            margin-top: 20px;
        }

                /* Optional: Add some styling */
        .weather-icon {
            font-size: 18px;
            color: blue; /* Change color as needed */
        }

    </style>
</head>
<body>

<div class="navbar" id="myNavbar">
    <a class="ab" href="index.php" style="font-size:20px"><i class="fa fa-fw fa-home"></i> Home</a>
    <a class="ab" href="booking.php" style="font-size:20px"><i class="fas fa-book"></i>Booking</a>
    <a class="ab" id="over" data-value ="<?php echo $count_active;?>" style="z-index:-99 !important; cursor: pointer; white; font-size:20px"><i class="fas fa-bell" style="color: white;"></i>
        Notification
        <?php if(!empty($count_active)){?>
            <div class="round" style="cursor: pointer;" id="bell-count" data-value ="<?php echo $count_active;?>"><span><?php echo $count_active; ?></span></div>
        <?php }?>                    
    </a>
    <a href="javascript:void(0);" class="icon ab" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
    <a href="logout-user.php" class="cd"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>



    <div id="notificationDetails" >
                <!-- Notification details will be displayed here -->
                <?php if(!empty($count_active)){?>
                      <div id="list">
                       <?php
                          foreach($notifications_data as $list_rows){?>
                            <li id="message_items" >
                            <div class="message alert alert-warning"  data-id=<?php echo $list_rows['id'];?>>
                            <span><?php echo $list_rows['name'];?></span>
                              <div class="msg">
                                <p>Booking <?php echo $list_rows['location'];?> as His Location</p>      
                              </div> 
                            </div>
                            </li>
                         <?php }
                       ?> 
                       </div> 
                     <?php }else{?>
                        <!--old Messages-->
                        <div id="list" >
                        <?php
                          foreach($deactive_notifications_dump as $list_rows){?>
                            <li id="message_items">
                            <div class="message alert alert-info" data-id=<?php echo $list_rows['id'];?>>
                              <span><?php echo $list_rows['name'];?></span>
                              <div class="msg">
                                <p><?$name?>Booking <?php echo $list_rows['location'];?> as His Location</p>      
                              </div>                         
                            </div>
                            </li>
                         <?php }
                       ?>
                        <!--old Messages-->
                     
                     <?php } ?>                
    </div>


    <div id="webcontent">
    <div class='container3'> 
        <p class='p1'>Full of romantic landscapes, stirring mountains, lush green tea gardens and golden beaches, 
            the island nation of Sri Lanka is nothing short of magnificent. The country has no shortage 
            of beautiful awe-inspiring spots, natural, historic and cultural, each more picture-perfect 
            than the next. From soulful Buddhist monasteries and temples to exotic and impeccable spots 
            rarely explored, Sri Lanka offers everything that makes your escape a memorable one! Whether 
            travelling with your significant other or planning a vacation with your family, Sri Lanka won’t 
            disappoint you! Take a trip to these most beautiful places in Sri Lanka and you will find it 
            difficult to leave back home. Read on to know the most beautiful experiences of Sri Lanka 
            including astounding places and popular attractions.
        </p>

        <h3 class='tp'>Where do you like to go</h3>
        
        <p>1. Southern Provience</p>


        <p> The Southern Province of Sri Lanka is one of the nine provinces of Sri Lanka, 
            the first level administrative division of the country. The provinces have existed
            since the 19th century but did not have any legal status until 1987 when the 13th
            Amendment to the Constitution of Sri Lanka established provincial councils.[3][4]
            It is the 7th largest province by area and is home to 2.5 million people, the 
            3rd most populated province. The province is bordered by Sabaragamuwa Province
            and Uva Province to the North, Eastern Province to the Northeast, Western Province
            to the Northwest and the Indian Ocean to the South, West and East. The Province's
            capital is Galle.The Southern Province is a geographic area consisting of the 
            districts of Galle, Matara and Hambantota. Subsistence farming and fishing is 
            the main source of income for the vast majority of the people of this region.
            <a id="gu1" href="javascript:void(0);" class="ll" onclick="southern()"> Show Details</a>  </p>  
        <p>
    </div>

    <div id="content1" class="content">

    <div class="showimage1">
        <img src="imgs/PV/SP/FatnaDeniyaya.jpg">
        <div class="data" id="weatherLink">
            
            <div class="row">
                <div class="left-content">
                    <h4 id="cityName">Fatna Deniyaya</h4>
                </div>
                <div class="right-content">
                    <a id="Location" href="gmap.php?city=Deniyaya"><i id="Location" class="fas fa-map-marker-alt"></i></a>
                    <a id="weatherIconLink" href="weather.php?city=Deniyaya"><i id="weatherIcon" class="fas fa-sun weather-icon"></i></a>
                </div>
            </div>  

            <div class="details">
                <small>
                    Patna Sliding Rock, locally know as the Patna Burus Gala is one of the newer destinations 
                    discovered local travelers. The location is situated inside Patna Division in Enesalwatta 
                    estate belonging to Maturata Plantations in Deniyaya.At this location the river flows over 
                    a number of wide rocks with gentle slopes and at end of the each rock lies a shallow pool. 
                    Due to the gentle water flow over the smooth rock surface, number of natural water slides 
                    are created on the rock.Since recently this location has turned in to a popular destination 
                    due publicity on social media and now visited by hundreds during holidays. Unfortunately  
                    the tranquility and the natural beauty of this location is destroyed today due to overcrowing 
                    and scattered piles of garbage left by them.
                </small>
            </div>
        </div>
    </div>

    <div class="showimage2">
        <img src="imgs/PV/SP/Yala-National-Park.jpg">
        <div class="data">

            <div class="row">
                <div class="left-content">
                    <h4>Animals of Yala National Park</h4>
                </div>
                <div class="right-content">
                <a id="Location" href="gmap.php?city=Yala National Park"><i id="Location" class="fas fa-map-marker-alt"></i></a>
                    <a id="weatherIconLink" href="weather.php?city=Yala"><i id="weatherIcon" class="fas fa-bolt"></i></a>
                </div>
            </div>                 

            <div class="details">
                <small>
                    Yala National Park is the best reserve in Sri Lanka for seeing a wide variety of wildlife, and 
                    in particular leopards, elephants and sloth bears. There are approximately 215 bird species 
                    resident in the park, including seven endemics, along with 44 mammals. The park is divided into 
                    five blocks of which block I (where most game drives take place) is renowned for having the 
                    greatest density of leopards per square kilometre in the world. Many of the younger males have 
                    grown so used to their dominance within the reserve and the jeeps that seek them out that they 
                    saunter lazily along tracks and sunbathe on rocky outcrops in full view. As such, Yala is Sri 
                    Lanka’s most popular national park, and receives a large number of visitors. Elephants, sambur deer, 
                    jackals and langur monkeys also play leading roles in the park, as do elusive sloth bears – small, 
                    scrubby looking bears that love to feast on the fruits of the palu tree when in season in May and 
                    June. Bird life is also a highlight, and some endemics include the Sri Lanka grey hornbill, the Sri 
                    Lanka wood pigeon, the brown-capped babbler and the blue-tailed bee-eater. The rare Black-necked 
                    Stork and the greater adjutant are other significant residents of the park, which is also visited 
                    by many migratory species.  
                </small>
            </div>
        </div>
    </div>

    <div class="showimage3">
        <img src="imgs/PV/SP/bundala.jpg">
        <div class="data">
            
            <div class="row">
                <div class="left-content">
                    <h4>Bundala National Park</h4>
                </div>
                <div class="right-content">
                    <a id="weatherIconLink" href="weather.php?city=Bundala "><i id="weatherIcon" class="fas fa-bolt"></i></a>
                </div>
            </div> 

            <div class="details">
                <small>
                    Situated in the Southern Province, close to Hambantota, The Bundala National Park considered the most 
                    important birding destination in Sri Lanka was declared as a wildlife sanctuary in 1969 and thereafter 
                    advanced to a National Park in 1993. It is located 251 km southeast of the capital city of Colombo, and 
                    can be reached from various tourist destinations around the country. For those travelling from Colombo 
                    the route is via Galle, Matara and Hambantota and from Kandy via Badulla. The climate at Bundala is hot 
                    and dry at most times, with average temperatures at 27 degrees Celsius during the months of May to September, 
                    with plenty of migratory birds arriving between September and March. </br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp; The park isspread out on 6,218 hectares consists of a striking landscape made up of a mix of thorny 
                    scrublands, marshes, lagoons, waterways and dunes making it an inviting destination for thousands of migratory
                    birds, some long distant migrants flying all the way from Euro Asian destinations to winter in the park. 
                    This has made it an internationally important wintering ground for thousands of exotic migratory species 
                    of birds. The reason for this is fascination for Sri Lanka is the countryâ€™s geographic location, being 
                    situated just below the southern tip of the Indian subcontinent, making it the final destination in their 
                    long journey across the oceans
                </small>
            </div>
        </div>
    </div>

    <div class="showimage4">
        <img src="imgs/PV/SP/unawatuna.jpg">
        <div class="data">

            <div class="row">
                <div class="left-content">
                    <h4>Beach Of Unawatuna</h4>
                </div>
                <div class="right-content">
                    <a id="weatherIconLink" href="weather.php?city=Unawatuna"><i id="weatherIcon" class="fas fa-bolt"></i></a>
                </div>
            </div>  

            <div class="details">
                <small>
                    The history of Unawatuna Beach goes back many thousand years, and it was lavishly adorned by Valmiki, the author of the Ramayana. 
                    According to Valmiki, Unawatuna was a seashore with thousands of trees, coconuts, and palms predominating, strings of houses and 
                    hermitages along the coastline, human beings and superior beings like Gandharvas, Siddhas, and ascetics living in them, and 
                    countless bejewelled celestial nymphs thronging the shore. The coast also occasionally received visits from heavenly beings, gods, 
                    and demons.   
                    Unawatuna beach in southern Sri Lanka is one of the best beaches on the island. The name Unawatuna is derived from “Onna-wetuna” 
                    which means “there it fell. Unawatuna bay is separated from the sea by a coral reef, which is about 100 meters from the Unawatuna
                    beach. Unawatuna beach is a safe place for year-round swimming due to its geographical location with the protective coral reef. 
                    The history of Unawatuna beach goes back to the pre-Christian era and Unawatuna is surrounded by several historical and religious
                    places such as “Wella Devala”.
                </small>
            </div>
        </div>
    </div>

    <div class="showimage5">
        <img src="imgs/PV/SP/sinharaja.jpg">
        <div class="data">
            <h4>Sinharaja Rain Forest</h4>
            <div class="details">
                <small>
                    Sinharaja is a Rain Forest and a biodiversity hotspot which is located in south west lowland 
                    wet zone within Sabaragamu and Southern provinces of Sri Lanka. Sinharaja rain forest is the 
                    country’s last viable area of primary tropical rain forest. It covers an area of 11,000 Ha of 
                    primary and secondary forests. This narrow strip of rolling site comprises of a series of 
                    ridges and valleys. More than 60% of the trees are endemic to Sinharaja Forest and many of 
                    them are considered rare. There is much endemic wildlife, especially birds but the reserve is 
                    also home to over 50% of Sri Lanka’s endemic species of butterflies & mammals and also many 
                    kinds of insects, reptiles and rare amphibians. This is one of the main reasons that UNESCO 
                    declared Sinharaja Forest as a UNESCO World Heritage in 1988 under the name of Sinharaja Forest
                    Reserve. In 1936 Sinharaja Forest was first recognized as being the only considerable patch of
                    virgin tropical rain forest in the Island.
                </small>
            </div>
        </div>
    </div>

    <div class="showimage6">
        <img src="imgs/PV/SP/Kanneliya.jpg">
        <div class="data">
            <h4>Kanneliya Rain Forest</h4>
            <div class="details">
                <small>
                Kanneliya Forest Reserve Experience the feeling of walking in a tropical rain forest . . . The KDN Forest 
                Reserve (Kanneliya-Dediyagama-Nakiyadeniya) is the second largest primary forest area in Sri Lanka and is 
                renowned for its watershed value. The forest occupies the area between two rivers - the Gin Ganga and the 
                Nilwala Ganga. The natural vegetation of the KDN complex is lowland wet evergreen forest, which is a climax 
                forest formation dominated by an association of Shorea, Dipterocarpus and Mesua. Over 17% of the wet zone 
                flora is confined to this area where the KDN forest is the most prominent. This region has been identified 
                as one of the floristically richest areas in South Asia. The endemic flora and fauna of the southwestern wet 
                zone, including the KDN, forms a relic of the biota of the Indian Plate with Gondwanaic ancestry. Therefore, 
                the biota of southwest Sri Lanka, including the KDN forest complex, is of considerable scientific interest 
                with respect to biogeography. There is a high proportion of endemism amongst the identified woody plants, with 
                150 species being endemic to Sri Lanka. There are 78 villages surrounding the KDN forest complex. There are 
                small-scale cottage industries based on Fish-tail palm (Kitul), and many local people are involved in the collection 
                of medicinal plants and plant products, as well as rattan, to produce handicrafts and furniture. What can be seen:- 
                Over 100 bird species, 16 of which are endemic to Sri Lanka (such as the Green-billed Coucal, Blue Magpie and 
                Spot-winged Thrush). Over 15 species of endemic fresh-water fish. Many other endemic reptiles, amphibians and
                butterflies can also be seen in the area.
                </small>
            </div>
        </div>
    </div>

    <div class="showimage7">
        <div class="data">
        <img src="imgs/PV/SP/junglebeach1.jpg">
            <h4>Jungle Beach</h4>
            <div class="details">
                <small>
                    Jungle Beach is a very famous and beautiful beach located in Rumassala, Galle. This is 
                    a hidden beach in the past. At that time it was known as the "White Dam". The corals 
                    act as a natural breakwater so the waves do not get rough here. Also special is the 
                    variety of fish species found in the coral reefs. Jungle Beach is the perfect place for 
                    a shallow safe bath. The beach at the foot of the Rumassala hills is so called because of
                    the Rumassala forest. The Jungle Beach is a difficult trek through the Rumassala jungle. 
                    Jungle Beach features a white sand dune, a shallow blue sea, and a safe beach with no ripples. 
                </small>
            </div>
        </div>
    </div>

    <div class="showimage8">
        <div class="data">
        <img src="imgs/PV/SP/gallef.jpg">
            <h4>Galle Fart</h4>
            <div class="details">
                <small>
                    Galle is located in the south of Sri Lanka. A journey to the past sees the remnants of a Dutch 
                    past at a World Heritage Site. Galle has been the emporium of foreign trade since the dawn of 
                    commerce. The Dutch Fort, which has been declared a World Heritage Site, surrounds the older part 
                    of the town and is situated on a headland of which three sides overlook the sea. The ramparts of 
                    the Fort are over 2.5 km in circumference and provide a pleasant and interesting walk. The historian 
                    Sir Emerson Tennant claimed that Galle was the ancient biblical city of Tarshish. This city is said 
                    to have traded with King Solomon, the Persians and the Egyptians. In 1505 a Portuguese fleet led by 
                    Lorenzo de Almeida heading for the Maldives drifted accidentally into Galle. On hearing a cock crowing
                    (cock means ”Galo” in Portuguese), it is said that they gave the town its name. Another explanation 
                    for the name is from the Sinhala name for rock ‘Gala’, plenty of which are found in the harbour area.
                </small>
            </div>
        </div>
    </div>
    
    <div class="showimage9">
        <div class="data">
        <img src="imgs/PV/SP/brahmana.jpeg">
            <h4>Brahmana Ella</h4>
            <div class="details">
                <small>
                    Lankagama Brahmana Ella Falls is situated on the border of the Sinharaja Forest with a 17m height, which is fed 
                    by the Hariyawa brook. This brook had been dammed at the point where it’s both, right and left branches meet. A 
                    hydropower station is located below. The name of the fall is steeped in history. Folklore narrates that during 
                    the reign of King Walagamba, a Brahmin had stolen a golden melon, intended to be enshrined in the Batuwangala. 
                    The King sent his army to apprehend him, and while fleeing he slipped down the fell to his death.Another says that 
                    a Brahmin from India bent on acquiring a golden melon from a place called Puhulegama married the eldest daughter 
                    of a family. According to tradition he sacrificed their firstborn in a ritual and obtained the golden melon. A 
                    youth named Mugunanal showed the Brahmin the escape route. But when crossing the waterfall, he was pushed down to 
                    his death.
                </small>
            </div>
        </div>
    </div>

    
    
    <div class="showimage10">
        <div class="data">
            <img src="imgs/PV/SP/Gongala.jpg">
            <h4>Gongala Roak</h4>
            <div class="details">
                <small>
                    Galle is located in the south of Sri Lanka. A journey to the past sees the remnants of a Dutch 
                    past at a World Heritage Site. Galle has been the emporium of foreign trade since the dawn of 
                    commerce. The Dutch Fort, which has been declared a World Heritage Site, surrounds the older part 
                    of the town and is situated on a headland of which three sides overlook the sea. The ramparts of 
                    the Fort are over 2.5 km in circumference and provide a pleasant and interesting walk. The historian 
                    Sir Emerson Tennant claimed that Galle was the ancient biblical city of Tarshish. This city is said 
                    to have traded with King Solomon, the Persians and the Egyptians. In 1505 a Portuguese fleet led by 
                    Lorenzo de Almeida heading for the Maldives drifted accidentally into Galle. On hearing a cock crowing
                    (cock means ”Galo” in Portuguese), it is said that they gave the town its name. Another explanation 
                    for the name is from the Sinhala name for rock ‘Gala’, plenty of which are found in the harbour area.
                </small>
            </div>
        </div>
    </div>
    
    <div class="showimage11">
        <div class="data">
        <img src="imgs/PV/SP/Madu Gaga.jpg">
            <h4>Madu Gaga</h4>
            <div class="details">
                <small>
                    Madu Ganga, situated close to the town of Balapitiya in Sri Lanka’s Galle District, has become an increasingly 
                    popular destination for boat safaris because of the variety of attractions. The name "Madu Ganga" meaning 
                    “Madu River”, is also spelt “Maduganga” or “Madhu Ganga”. The amphibic landscape of Maduganga is Sri Lanka’s 
                    largest remaining mangrove swamp, home to several fish and reptile species. It’s a fantastic birding territory, 
                    too. Together with the smaller Randombe Lake, which is situated closer to the ocean, but further south, and linked
                    with Madu River by two natural channels, it forms the Madu Ganga Wetland, inhabited by more than 300 species of 
                    plants and  almost 250 species of vertebrate animals. Due to its rich biodiversity, Madu Ganga was listed under 
                    the International Ramsar Convention on Wetlands, an international treaty for the conservation and sustainable use 
                    of wetlands. The Convention on Wetlands is named after the city of Ramsar in Iran, where it was signed in 1971.
                </small>
            </div>
        </div>
    </div>

    <div class="showimage12">
        <div class="data">
        <img src="imgs/PV/SP/kalametiya.jpg">
            <h4>Kalametiya bird sanctuary</h4>
            <div class="details">
                <small>
                    Kalametiya bird sanctuary is located in Hambantota district, southern province, in Sri Lanka. 22 km from Tangalle. 
                    It is a protected area by the government of Sri Lanka. It was declared as a sanctuary in 1938. Kalametiya bird sanctuary 
                    falls in to the dry zone category. It is a nice natural landscape for bird watching and nature photography. It is full of 
                    water and water flows to the sea through the bird sanctuary. Kalametiya bird sanctuary consists with beautiful mangroves, 
                    coastal lagoons, and scrub lands. Many species of resident birds, migratory birds and endemic birds can be seen. These 
                    lagoons support breeding colonies of pelicans, herons, egrets and open-billed stork and large wintering populations of 
                    migratory ducks and shorebirds. You can enter in to the bird sanctuary by a catamaran. You can climb up the rocks in the
                    middle of the bird sanctuary, and you will see beautiful sceneries of the bird sanctuary from the top of the rocks. It will 
                    be a nice tour for nature lovers.
                </small>
            </div>
        </div>
    </div>
  </div>

    <div class='container3'>        
        <p>2. Centrel Provience</p>

        <p> The Southern Province of Sri Lanka is one of the nine provinces of Sri Lanka, 
            the first level administrative division of the country. The provinces have existed
            since the 19th century but did not have any legal status until 1987 when the 13th
            Amendment to the Constitution of Sri Lanka established provincial councils.[3][4]
            It is the 7th largest province by area and is home to 2.5 million people, the 
            3rd most populated province. The province is bordered by Sabaragamuwa Province
            and Uva Province to the North, Eastern Province to the Northeast, Western Province
            to the Northwest and the Indian Ocean to the South, West and East. The Province's
            capital is Galle.The Southern Province is a geographic area consisting of the 
            districts of Galle, Matara and Hambantota. Subsistence farming and fishing is 
            the main source of income for the vast majority of the people of this region.
            <a id="gu2" href="javascript:void(0);" class="ll" onclick="western()"> Show Details</a>  </p>  
        <p>
    </div>  

  <div id="content2" class="content">
   <div class="showimage1">
    <img src="imgs/PV/CP/kandy-lake-and-the-temple.jpg">
    <div class="data">
        <h4>Sri Dalada Maligawa</h4>
        <div class="details">
            <small>
                Patna Sliding Rock, locally know as the Patna Burus Gala is one of the newer destinations 
                discovered local travelers. The location is situated inside Patna Division in Enesalwatta 
                estate belonging to Maturata Plantations in Deniyaya.At this location the river flows over 
                a number of wide rocks with gentle slopes and at end of the each rock lies a shallow pool. 
                Due to the gentle water flow over the smooth rock surface, number of natural water slides 
                are created on the rock.Since recently this location has turned in to a popular destination 
                due publicity on social media and now visited by hundreds during holidays. Unfortunately  
                the tranquility and the natural beauty of this location is destroyed today due to overcrowing 
                and scattered piles of garbage left by them.
            </small>
    </div>
    </div>
 </div>

 <div class="showimage2">
    <img src="imgs/PV/CP/hotanthanna.jpg">
    <div class="data">
        <h4>Hortan Thanna</h4>
        <div class="details">
            <small>
                Yala National Park is the best reserve in Sri Lanka for seeing a wide variety of wildlife, and 
                in particular leopards, elephants and sloth bears. There are approximately 215 bird species 
                resident in the park, including seven endemics, along with 44 mammals. The park is divided into 
                five blocks of which block I (where most game drives take place) is renowned for having the 
                greatest density of leopards per square kilometre in the world. Many of the younger males have 
                grown so used to their dominance within the reserve and the jeeps that seek them out that they 
                saunter lazily along tracks and sunbathe on rocky outcrops in full view. As such, Yala is Sri 
                Lanka’s most popular national park, and receives a large number of visitors. Elephants, sambur deer, 
                jackals and langur monkeys also play leading roles in the park, as do elusive sloth bears – small, 
                scrubby looking bears that love to feast on the fruits of the palu tree when in season in May and 
                June. Bird life is also a highlight, and some endemics include the Sri Lanka grey hornbill, the Sri 
                Lanka wood pigeon, the brown-capped babbler and the blue-tailed bee-eater. The rare Black-necked 
                Stork and the greater adjutant are other significant residents of the park, which is also visited 
                by many migratory species.  
            </small>
        </div>
    </div>
 </div>

 <div class="showimage3">
    <img src="imgs/PV/CP/pitawala-thanna.jpeg">
    <div class="data">
        <h4>pitawala patana</h4>
        <div class="details">
            <small>
                Pitawala Patana Mini World's End is an overhanging cliff at the edge of a grassland plain in the northern foothills of Knuckles Range, situated at the Rattota-Illukkumbura mountain road in Matale District. "Pitawala", also transcribed "Pitawea", is the name of the nearby village between Riverston and the Mini World's End. Administrationally, also the pass and peaks and towers of Riverston are part of Pitawala. "Patana", also transcribed "Pathana", is a Sinhala term that applies to natural grasslands in the hillcountry in general. Such open meadows are also found at steep slopes of mountains. In the case of Pitawala Patana, it's only a slightly sloping grassland plain. The terrain of the open grasland of Pitawala Partana, surrounded by semi-evergreen forest, is of almost square size, half a kilometer long and wide.
            </small>
        </div>
    </div>
 </div>

 <div class="showimage4">
    <img src="imgs/PV/CP/Hanthana.jpg">
    <div class="data">
        <h4>Hanthana</h4>
        <div class="details">
            <small>
                The history of Unawatuna Beach goes back many thousand years, and it was lavishly adorned by Valmiki, the author of the Ramayana. 
                According to Valmiki, Unawatuna was a seashore with thousands of trees, coconuts, and palms predominating, strings of houses and 
                hermitages along the coastline, human beings and superior beings like Gandharvas, Siddhas, and ascetics living in them, and 
                countless bejewelled celestial nymphs thronging the shore. The coast also occasionally received visits from heavenly beings, gods, 
                and demons.   
                Unawatuna beach in southern Sri Lanka is one of the best beaches on the island. The name Unawatuna is derived from “Onna-wetuna” 
                which means “there it fell. Unawatuna bay is separated from the sea by a coral reef, which is about 100 meters from the Unawatuna
                beach. Unawatuna beach is a safe place for year-round swimming due to its geographical location with the protective coral reef. 
                The history of Unawatuna beach goes back to the pre-Christian era and Unawatuna is surrounded by several historical and religious
                places such as “Wella Devala”.
            </small>
        </div>
    </div>
 </div>

 <div class="showimage5">
    <img src="imgs/PV/CP/STclair.jpg">
    <div class="data">
        <h4>St. Clair</h4>
        <div class="details">
            <small>
                St. Clair’s waterfall is located on the western side of Thalawakele town in the Nuwara Eliya District. You can observe this beautiful waterfall during your travels via the Hatton–Nuwara Eliya main road. The distance to the waterfall from Kandy is about 71 km, and from Colombo, it is about 145 km. Those traveling from Kandy can first go to Nawalapitiya and then take the Kotmale road to get here. Travelers who start their journey in Colombo can come here via Hatton. The distance between Nuwara Eliya City and St. Clair’s Falls is about 26 kilometers. If you travel here by train, you need to drop off at the Talawakele railway station. It’s not difficult for anyone to find this place. 

            </small>
        </div>
    </div>
 </div>

 <div class="showimage6">
    <img src="imgs/PV/SP/Kanneliya.jpg">
    <div class="data">
        <h4>Kanneliya Rain Forest</h4>
        <div class="details">
            <small>
            Kanneliya Forest Reserve Experience the feeling of walking in a tropical rain forest . . . The KDN Forest 
            Reserve (Kanneliya-Dediyagama-Nakiyadeniya) is the second largest primary forest area in Sri Lanka and is 
            renowned for its watershed value. The forest occupies the area between two rivers - the Gin Ganga and the 
            Nilwala Ganga. The natural vegetation of the KDN complex is lowland wet evergreen forest, which is a climax 
            forest formation dominated by an association of Shorea, Dipterocarpus and Mesua. Over 17% of the wet zone 
            flora is confined to this area where the KDN forest is the most prominent. This region has been identified 
            as one of the floristically richest areas in South Asia. The endemic flora and fauna of the southwestern wet 
            zone, including the KDN, forms a relic of the biota of the Indian Plate with Gondwanaic ancestry. Therefore, 
            the biota of southwest Sri Lanka, including the KDN forest complex, is of considerable scientific interest 
            with respect to biogeography. There is a high proportion of endemism amongst the identified woody plants, with 
            150 species being endemic to Sri Lanka. There are 78 villages surrounding the KDN forest complex. There are 
            small-scale cottage industries based on Fish-tail palm (Kitul), and many local people are involved in the collection 
            of medicinal plants and plant products, as well as rattan, to produce handicrafts and furniture. What can be seen:- 
            Over 100 bird species, 16 of which are endemic to Sri Lanka (such as the Green-billed Coucal, Blue Magpie and 
            Spot-winged Thrush). Over 15 species of endemic fresh-water fish. Many other endemic reptiles, amphibians and
            butterflies can also be seen in the area.
            </small>
        </div>
    </div>
 </div>

 <div class="showimage7">
    <div class="data">
    <img src="imgs/PV/SP/junglebeach1.jpg">
        <h4>Jungle Beach</h4>
        <div class="details">
            <small>
                Jungle Beach is a very famous and beautiful beach located in Rumassala, Galle. This is 
                a hidden beach in the past. At that time it was known as the "White Dam". The corals 
                act as a natural breakwater so the waves do not get rough here. Also special is the 
                variety of fish species found in the coral reefs. Jungle Beach is the perfect place for 
                a shallow safe bath. The beach at the foot of the Rumassala hills is so called because of
                the Rumassala forest. The Jungle Beach is a difficult trek through the Rumassala jungle. 
                Jungle Beach features a white sand dune, a shallow blue sea, and a safe beach with no ripples. 
            </small>
        </div>
    </div>
 </div>

 <div class="showimage8">
    <div class="data">
    <img src="imgs/PV/SP/gallef.jpg">
        <h4>Galle Fart</h4>
        <div class="details">
            <small>
                Galle is located in the south of Sri Lanka. A journey to the past sees the remnants of a Dutch 
                past at a World Heritage Site. Galle has been the emporium of foreign trade since the dawn of 
                commerce. The Dutch Fort, which has been declared a World Heritage Site, surrounds the older part 
                of the town and is situated on a headland of which three sides overlook the sea. The ramparts of 
                the Fort are over 2.5 km in circumference and provide a pleasant and interesting walk. The historian 
                Sir Emerson Tennant claimed that Galle was the ancient biblical city of Tarshish. This city is said 
                to have traded with King Solomon, the Persians and the Egyptians. In 1505 a Portuguese fleet led by 
                Lorenzo de Almeida heading for the Maldives drifted accidentally into Galle. On hearing a cock crowing
                (cock means ”Galo” in Portuguese), it is said that they gave the town its name. Another explanation 
                for the name is from the Sinhala name for rock ‘Gala’, plenty of which are found in the harbour area.
            </small>
        </div>
    </div>
 </div>

 <div class="showimage9">
    <div class="data">
    <img src="imgs/PV/SP/brahmana.jpeg">
        <h4>Brahmana Ella</h4>
        <div class="details">
            <small>
                Lankagama Brahmana Ella Falls is situated on the border of the Sinharaja Forest with a 17m height, which is fed 
                by the Hariyawa brook. This brook had been dammed at the point where it’s both, right and left branches meet. A 
                hydropower station is located below. The name of the fall is steeped in history. Folklore narrates that during 
                the reign of King Walagamba, a Brahmin had stolen a golden melon, intended to be enshrined in the Batuwangala. 
                The King sent his army to apprehend him, and while fleeing he slipped down the fell to his death.Another says that 
                a Brahmin from India bent on acquiring a golden melon from a place called Puhulegama married the eldest daughter 
                of a family. According to tradition he sacrificed their firstborn in a ritual and obtained the golden melon. A 
                youth named Mugunanal showed the Brahmin the escape route. But when crossing the waterfall, he was pushed down to 
                his death.
            </small>
        </div>
    </div>
 </div>



 <div class="showimage10">
    <div class="data">
        <img src="imgs/PV/SP/Gongala.jpg">
        <h4>Gongala Roak</h4>
        <div class="details">
            <small>
                Galle is located in the south of Sri Lanka. A journey to the past sees the remnants of a Dutch 
                past at a World Heritage Site. Galle has been the emporium of foreign trade since the dawn of 
                commerce. The Dutch Fort, which has been declared a World Heritage Site, surrounds the older part 
                of the town and is situated on a headland of which three sides overlook the sea. The ramparts of 
                the Fort are over 2.5 km in circumference and provide a pleasant and interesting walk. The historian 
                Sir Emerson Tennant claimed that Galle was the ancient biblical city of Tarshish. This city is said 
                to have traded with King Solomon, the Persians and the Egyptians. In 1505 a Portuguese fleet led by 
                Lorenzo de Almeida heading for the Maldives drifted accidentally into Galle. On hearing a cock crowing
                (cock means ”Galo” in Portuguese), it is said that they gave the town its name. Another explanation 
                for the name is from the Sinhala name for rock ‘Gala’, plenty of which are found in the harbour area.
            </small>
        </div>
    </div>
 </div>

 <div class="showimage11">
    <div class="data">
    <img src="imgs/PV/SP/Madu Gaga.jpg">
        <h4>Madu Gaga</h4>
        <div class="details">
            <small>
                Madu Ganga, situated close to the town of Balapitiya in Sri Lanka’s Galle District, has become an increasingly 
                popular destination for boat safaris because of the variety of attractions. The name "Madu Ganga" meaning 
                “Madu River”, is also spelt “Maduganga” or “Madhu Ganga”. The amphibic landscape of Maduganga is Sri Lanka’s 
                largest remaining mangrove swamp, home to several fish and reptile species. It’s a fantastic birding territory, 
                too. Together with the smaller Randombe Lake, which is situated closer to the ocean, but further south, and linked
                with Madu River by two natural channels, it forms the Madu Ganga Wetland, inhabited by more than 300 species of 
                plants and  almost 250 species of vertebrate animals. Due to its rich biodiversity, Madu Ganga was listed under 
                the International Ramsar Convention on Wetlands, an international treaty for the conservation and sustainable use 
                of wetlands. The Convention on Wetlands is named after the city of Ramsar in Iran, where it was signed in 1971.
            </small>
        </div>
    </div>
 </div>

 <div class="showimage12">
    <div class="data">
    <img src="imgs/PV/SP/kalametiya.jpg">
        <h4>Kalametiya bird sanctuary</h4>
        <div class="details">
            <small>
                Kalametiya bird sanctuary is located in Hambantota district, southern province, in Sri Lanka. 22 km from Tangalle. 
                It is a protected area by the government of Sri Lanka. It was declared as a sanctuary in 1938. Kalametiya bird sanctuary 
                falls in to the dry zone category. It is a nice natural landscape for bird watching and nature photography. It is full of 
                water and water flows to the sea through the bird sanctuary. Kalametiya bird sanctuary consists with beautiful mangroves, 
                coastal lagoons, and scrub lands. Many species of resident birds, migratory birds and endemic birds can be seen. These 
                lagoons support breeding colonies of pelicans, herons, egrets and open-billed stork and large wintering populations of 
                migratory ducks and shorebirds. You can enter in to the bird sanctuary by a catamaran. You can climb up the rocks in the
                middle of the bird sanctuary, and you will see beautiful sceneries of the bird sanctuary from the top of the rocks. It will 
                be a nice tour for nature lovers.
            </small>
        </div>
    </div>
 </div>
 </div>

</div>   

<i onclick="toggleChat()" class="chat fas fa-comments"></i>

<iframe id="iframe" class="iframe" width="350" height="430" allow="microphone;" src="https://console.dialogflow.com/api-client/demo/embedded/783c3a89-8a6a-4f97-81e0-033f058ecb54"></iframe></a>  


<script>

function toggleChat() {
    var x = document.getElementById("iframe");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

    function myFunction() {
        var x = document.getElementById("myNavbar");
        var y = document.getElementById("list");
        var z = document.getElementById("notificationDetails");
        if (x.className === "navbar") {
            x.className += " responsive";
            z.style.top ="150px";
        } else {
            x.className = "navbar";
            y.style.display = "none";
            z.style.top ="0px";                    
        }
    }


// Function to handle changes in screen size
function handleResize() {
    var x = document.getElementById("myNavbar");
    var y = document.getElementById("list");
    var z = document.getElementById("notificationDetails");

    // Check if the screen width is less than or equal to 600px
    if (window.matchMedia('(max-width: 600px)').matches) {
        x.className = "navbar"; // Add 'responsive' class
        y.style.display = "none"; // Hide the list
        z.style.top = "150px"; // Set top position for notification details
    } else {
        x.className = "navbar"; // Add 'navbar' class
        y.style.display = "none"; // Show the list
        z.style.top = "0"; // Reset top position for notification details
    }
}

// Initial call to handleResize to set initial state
handleResize();

// Event listener for media screen size change
window.addEventListener('resize', handleResize);



    function southern() {
        var x = document.getElementById("content1");
        var y = document.getElementById("gu1");
        if (x.className === "content") {
            x.className += " contentr";
            y.innerHTML = "Hide";
            
        } else {
            x.className = "content";
            y.innerHTML = "Show More";
        }
    }
    
    function western() {
        var x = document.getElementById("content2");
        var y = document.getElementById("gu2");
        if (x.className === "content") {
            x.className += " contentr";
            y.innerHTML = "Hide";
        } else {
            x.className = "content";
            y.innerHTML = "Show More";
        }
    }
</script>

<!-- Notification-->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        var name = $('#name').val();
        var ins_msg = $('#location').val();
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

<script>
    setTimeout(function() {
            <?php
                unset($_SESSION['notification_count']);
            ?>
    }, 5000); // 5000 milliseconds = 5 seconds
</script>


</body>
</html>
