<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harsha Web devoloper</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Rajdhani', sans-serif;
            background-color: #E9F4F4; ;
            margin: 0;
            padding: 0;

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

        .navbar a:hover {
            color: cyan;
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

            .navbar.responsive {position: relative;}
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
        }

    </style>
</head>
<body>
<div class="navbar" id="myNavbar">
    <a class="ab" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
    <a class="ab" href="#"><i class="fa fa-fw fa-search"></i> Search</a>
    <a class="ab" href="logr.php"><i class="fa fa-fw fa-envelope"></i> Contact</a>
    <a href="javascript:void(0);" class="icon ab" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
    <a href="signup-user.php" class="cd"><i class="fa fa-fw fa-user" style="color: #00ff80;"></i></i>Sign In</a>
</div>

<div class="all" style="margin-top: 15px; width:auto;">
 <div class="home" >    
 <div class="slide-container">
    <div class="slides" style="margin-bottom: 35px;">
        <img src="imgs/nuwaraeliya.jpg" class="active">
        <img src="imgs/pitawala-patana.jpg">
        <img src="imgs/las.jpg">
        <img src="imgs/stclair.jpg">
        <img src="imgs/pol.jpeg">
    </div>
    <div class="buttons">
        <span class="next">&#10095;</span>
        <span class="prev">&#10094;</span>
    </div>
    <div class="dotsContainer">
        <div class="dot active" attr="0" onclick="switchImage(this)"></div>
        <div class="dot" attr="1" onclick="switchImage(this)"></div>
        <div class="dot" attr="2" onclick="switchImage(this)"></div>
        <div class="dot" attr="3" onclick="switchImage(this)"></div>
        <div class="dot" attr="4" onclick="switchImage(this)"></div>
    </div>
 </div>
</div>

<div class="details">
    <h2>Travel With Harsha Palihawadana</h2>   

    <div class='content'>
      <div class="flex-container">
        <div class="left-side">
          <h2>Where Do You Like To GO</h2>
          <p>
             <li>Ella - Witness The Countryside Charm </li>
             <li>Nuwara Eliya - Covered With Lush-Greenery </li>
             <li>Sinharaja Forest Reserve - Tropical Beauty </li>
             <li>Ravana Falls - Explore The Surreal Beauty</li>
             <li>Dehiwala Zoo - Experience The Wilderness</li>
             <li>Horton Plains National Park - Of Lakes And Greenery</li>
             <li>Nuwara Eliya Restaurants – Relish Sri Lankan Food</li>             
          </p>
        </div>
        <div class="vl"></div>
        <div class="right-side ">
          <p>
          Sri Lanka is arguably one of the most beautiful places in the world. 
          This tiny island nation is only 9,833,517 sq km but it has a huge range of diverse landscapes to offer.
          I’m talking mountains and cliffs, hills filled with tea plantations, waterfalls, insane beaches and sunsets, and of course, temples.
          </p>
          <p>
          Often called the mini London, Nuwara Eliya is a perfect place to relax in Sri Lanka. There are a lot of places to visit in Nuwara 
          Eliya and the whole of Nuwara Eliya is completely different from the whole of Sri Lanka. It is a quiet place with great scenic 
          beautyand for planning perfect family trips. Located in central Sri Lanka, this city is perched on the tea hills and is surrounded 
          by spellbinding greenery.
          </p>
        </div>
      </div>        
    </div>
</div>

</div>

<script type="text/javascript">

function myFunction() {
        var x = document.getElementById("myNavbar");
        if (x.className === "navbar") {
            x.className += " responsive";
        } else {
            x.className = "navbar";
        }
    }

   // Access the Images
   let slideImages = document.querySelectorAll('img');

   //  Access the next and pre buttons
   let next = document.querySelector('.next');
   let prev = document.querySelector('.prev');

   //  Access the indicators
   let dots = document.querySelectorAll('.dot');

   var counter = 0;


   // Code for next button
   next.addEventListener('click', slideNext);
   function slideNext(){
      slideImages[counter].style.animation = 'next1 0.5s ease-in forwards';
      if(counter >= slideImages.length-1){
        counter = 0;
      }
      else{
        counter++;
      }
      slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';
      indicators();
   }

    // Code for next button
   prev.addEventListener('click', slidPrev);
   function slidPrev(){
    slideImages[counter].style.animation = 'prev1 0.5s ease-in forwards';
    if(counter == 0){
        counter = slideImages.length-1;
    }
    else{
        counter--;
    }
    slideImages[counter].style.animation = 'prev2 0.5s ease-in forwards';
    indicators();
   }


   // Auto slideing
   function autoSliding(){
       deletInterval = setInterval(timer, 3000);
        function timer(){
            slideNext();
            indicators();
        }
    }
    autoSliding();

    // Stop auto Sliding when mouse is over
    const container = document.querySelector('.slide-container');
    container.addEventListener('mouseover', function(){
        clearInterval(deletInterval);
    });
    
    // Resume sliding when mouse is out
    container.addEventListener('mouseout', autoSliding);

    // Add and remove active class from the indicators
    function indicators(){
        for(i = 0; i < dots.length; i++){
            dots[i].className = dots[i].className.replace(' active', '');
        }
        dots[counter].className += ' active';
    }
    
    // Add click event to the indicator
    function switchImage(currentImage){
        currentImage.classList.add('active');
        var imageId = currentImage.getAttribute('attr');
        if(imageId > counter){
          slideImages[counter].style.animation = 'next1 0.5s ease-in forwards';   
          counter = imageId;
          slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';   
        }
        else if(imageId == counter){
          return;
        }
        else{
          slideImages[counter].style.animation = 'prev1 0.5s ease-in forwards';   
          counter = imageId;
          slideImages[counter].style.animation = 'prev2 0.5s ease-in forwards';      
        }
        indicators();
    }


</script>

<style>
     @import url("index.css");
</style>

</body>
</html>
