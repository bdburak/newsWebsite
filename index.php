<?php
$apiKey = "YOUR API KEY";
$cityIds='323784';
$wlink = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityIds . "&lang=tr&units=metric&APPID=" . $apiKey;
$links = array('https://newsapi.org/v2/top-headlines?country=tr&apiKey= YOUR API KEY',$wlink);
$data = array();
$articles = array();

for ($i=0; $i < 2; $i++) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $links[$i]);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($ch);

  curl_close($ch);


  $data[$i] = json_decode($response);
}


foreach ($data[0]->articles as $key) {
  array_push($articles,$key);
}






$currentTime = time();
?>
<!doctype html>
<html>
<head>
<title>Hava Durumu Raporu</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

  <div class="all">

    <ul>
          <li class="item">
            <div class="weather">
                <h2><?php echo $data[1]->name; ?>Hava Durumu</h2>
                <div class="time">

                    <div><?php echo date("jS F, Y",$currentTime); ?></div>
                    <div><?php echo ucwords($data[1]->weather[0]->description); ?></div>
                </div>
                <div class="weather-forecast">
                    <img
                        src="http://openweathermap.org/img/w/<?php echo $data[1]->weather[0]->icon; ?>.png"
                        class="weather-icon" /> <?php echo '<br>Maximum Sicaklik: '.$data[1]->main->temp_max; ?>°C<span
                        class="min-temperature"><?php echo '<br>Minimum Sicaklik: '.$data[1]->main->temp_min; ?>°C</span>
                </div>
                <div class="time">
                    <div>Nem Oranı: <?php echo $data[1]->main->humidity; ?> %</div>
                    <div>Rüzgar: <?php echo $data[1]->wind->speed; ?> km/s</div>
                </div>
            </div>
          </li>




    </ul>
    <div class="news">
      <?php
      foreach ($data[0]->articles as $key) {
        echo "<div class='newsI'>";
        echo '<img src="'.$key->urlToImage.'"  >';
        echo '<h2 >'.$key->title."</h2>"."<br>";
        echo '<p s>'.$key->description.'</p ><br>';
        echo '<a target="_blank" href="'.$key->url.'">Devamını okumak için</a><br>';
        echo "<hr>";
        echo "</div>";
      }
      ?>
    </div>


  </div>

</body>
</html>
