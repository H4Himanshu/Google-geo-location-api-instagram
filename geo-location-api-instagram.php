<?php
if (!empty($_GET['location'])){
  /**
   * Here we build the url we'll be using to access the google maps api
   */
  $maps_url = 'https://'.
  'maps.googleapis.com/'.
  'maps/api/geocode/json'.
  '?address=' . urlencode($_GET['location']);
  $maps_json = file_get_contents($maps_url);
  $maps_array = json_decode($maps_json, true);
  $lat = $maps_array['results'][0]['geometry']['location']['lat'];
  $lng = $maps_array['results'][0]['geometry']['location']['lng'];
  /**
   * Time to make our Instagram api request. We'll build the url using the
   * coordinate values returned by the google maps api
   */
  $instagram_url = 'https://'.
    'api.instagram.com/v1/media/search' .
    '?lat=' . $lat .
    '&lng=' . $lng .
    '&client_id=b15c4cea3c8640e0b5cace82c6ece343'; //replace "CLIENT-ID"
  $instagram_json = file_get_contents($instagram_url);
  $instagram_array = json_decode($instagram_json, true);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="utf-8"/>
    <title>geogram</title>
  </head>
  <body>
<form class="form-horizontal" action="/geogram.php" method="get">
<fieldset>

<!-- Form Name -->
<legend>LocationGram</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-1 control-label" for="location"></label>  
  <div class="col-md-4">
  <input id="location" name="location" type="text" placeholder="Enter The Valid Location Name" class="form-control input-md" required="">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-1 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-default">Submit</button>
  </div>
</div>

</fieldset>
</form>


    <br/>
    <?php
    if(!empty($instagram_array)){
      foreach($instagram_array['data'] as $key=>$image){
        echo '<img src="'.$image['images']['standard_resolution']['url'].'" alt=""/><br/>';
      }
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </body>
</html>