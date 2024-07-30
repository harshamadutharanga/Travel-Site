<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Weather of Sri Lanka | HSWD</title>
    <link rel="stylesheet" href="weather.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="script.js" defer></script>
  </head>
  <body>



  <div class="hero">

  
  <div class="video-container">
    <video autoplay loop muted playsinline>
        <source src="assets/133823-758327952_small.mp4" type="video/mp4" style="width: 100%;">
    </video>
    <!-- Your content goes here -->
  </div>
   
  <div class="container1">
    <!-- <h1>Weather Report for Five Consecutive Days</h1>-->
    <div class="container">
      <div class="weather-input">
        <h3 class="tropic">Enter a City Name</h3>
        <input id="city-input" class="city-input" type="text" placeholder="E.g., New York, London, Tokyo">
        <button class="search-btn">Search</button>
        <div class="separator"></div>
        <button class="location-btn">Use Current Location</button>
      </div>
      <div class="weather-data">
        <div class="current-weather">
          <div class="details">
            <h2>_______ ( ______ )</h2>
            <h6>Temperature: __°C</h6>
            <h6>Wind: __ M/S</h6>
            <h6>Humidity: __%</h6>
          </div>
        </div>
        <div class="days-forecast">
          <h2>5-Day Forecast</h2>
          <ul class="weather-cards">
            <li class="card">
              <h3>( ______ )</h3>
              <h6>Temp: __C</h6>
              <h6>Wind: __ M/S</h6>
              <h6>Humidity: __%</h6>
            </li>
            <li class="card">
              <h3>( ______ )</h3>
              <h6>Temp: __C</h6>
              <h6>Wind: __ M/S</h6>
              <h6>Humidity: __%</h6>
            </li>
            <li class="card">
              <h3>( ______ )</h3>
              <h6>Temp: __C</h6>
              <h6>Wind: __ M/S</h6>
              <h6>Humidity: __%</h6>
            </li>
            <li class="card">
              <h3>( ______ )</h3>
              <h6>Temp: __C</h6>
              <h6>Wind: __ M/S</h6>
              <h6>Humidity: __%</h6>
            </li>
            <li class="card">
              <h3>( ______ )</h3>
              <h6>Temp: __C</h6>
              <h6>Wind: __ M/S</h6>
              <h6>Humidity: __%</h6>
            </li>
          </ul>
        </div>
      </div>
    </div>
    </div>
   </div>  
  </body>

  <script>
    // Get the value from the URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const city = urlParams.get('city');

    // Populate the input field with the city value
    if (city) {
        document.getElementById('city-input').value = city;
    }
</script>
</html>