<?php

    require "./helpers/weather-api.php";
    require "./helpers/math.php";
    require "./env.php";

    $city="San Sebastián";
    if(isset($_GET['city'])){
        $city = $_GET['city'];
    }

    $json = get_current_weather($city);
    $response = json_decode($json);
    if (isset($response->cod) && $response->cod =="404"){

        header('Location:'.$_SERVER['PHP_SELF'].'?error='.$response->message);
        die;
    }

    $current_weather = $response;

    $json = get_weather_forecast($city);
    $forecast = json_decode($json);

    


?>



<!DOCTYPE html>
<html>
    <head>
        <title>Weather App</title>
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="background-image:url('./images/<?=$current_weather->weather[0]->icon?>.jpg');">
        <main>
            <section class="current-city">
                <h1><?= calculate_celcius($current_weather->main->temp)?>º</h1>
                <div>
                    <h2><?= $current_weather->name?></h2>
                    <span><?= date("d/m/Y", $current_weather->dt)?></span>
                </div>

                <div>
                    <i class="fas fa-<?=translate_icon_code($current_weather->weather[0]->icon)?>"></i>
                    <span><?=$current_weather->weather[0]->main?></span>
                </div>
            </section>
        </main>
        <aside>
            
            <form action="#" action="get">
                <input type="text" name="city" placeholder="Find another city...">
                <button>
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <section class="current-city mini">
                <h1><?= calculate_celcius($current_weather->main->temp)?>º</h1>
                <div>
                    <h2><?= $current_weather->name?></h2>
                    <span><?= date("d/m/Y H:i:s", $current_weather->dt)?></span>
                </div>

                <div>
                    <i class="fas fa-<?=translate_icon_code($current_weather->weather[0]->icon)?>"></i>
                    <span><?=$current_weather->weather[0]->main?></span>
                </div>
            </section>
            <div id="details">
                <h3>Details</h3>
            
                <ul>
                    <li>
                        <span>Max</span>
                        <span><?=calculate_celcius($current_weather->main->temp_max)?>º</span>
                    </li>
                    <li>
                        <span>Min</span>
                        <span><?=calculate_celcius($current_weather->main->temp_min)?>º</span>
                    </li>
                    <li>
                        <span>Clouds</span>
                        <span><?=$current_weather->clouds->all?> %</span>
                    </li>
                    <li>
                        <span>Wind</span>
                        <span><?=$current_weather->wind->speed?> km/h</span>
                    </li>
                </ul>
            </div>
            <div id="days">
                <h3>Next days</h3>
                <ul>
                    <?php
                        $previous_day=date("l");
                        foreach ($forecast->list as $day) {
                            ?>
                            <li>
                                <span>
                                    <?php
                                         if($previous_day != date("l", $day->dt)){
                                            echo date("l, H:i", $day->dt);
                                         }else{
                                            echo date("H:i", $day->dt);
                                         }
                                         $previous_day = date("l", $day->dt);
                                    ?>
                                </span>
                                <span>
                                    <span><?=calculate_celcius($day->main->temp)?>º</span>
                                    <i class="fas fa-<?=translate_icon_code($day->weather[0]->icon)?>"></i>
                                </span>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
                
            </div>
        </aside>
        <script>
            <?php
                if($_GET["error"]) echo "alert('".$_GET["error"]."')";
            
            ?>
            </script>
    </body>
</html>