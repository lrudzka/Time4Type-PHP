<?php
    session_start();
    $_SESSION['level']='1.1';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Time4Type</title>
    
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/bootstrap/style.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
</head>

<body>
    <?php include "../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h1 class="title history">Historia rozgrywek</h1>
            <input type="text" class="form-control searchTeam" placeholder="Wyszukaj drużynę">
            <div class="table-responsive">
                <table class="table history" id='history'>
                    <tr>
                        <th class="center"><span class="sort">Data</span>   <button class='sortDown sort btn btn-succes btn-lg'></button></th>
                        <th class="home">Gospodarze</th>
                        <th></th>
                        <th class="away">Goście</th>
                        <th class="center">Wynik</th>
                    </tr>
                    <?php
                        $counter = 0;
                    
                        include '../configModules/autoloader.php';
                        
                        $event = new CurrentEvent();
                        $api = new FootballData();

                        // ściągamy wszystkie trwające mecze 
                        $start = $event::START_DATE;
                        $end = new DateTime(); 
                        $response = $api->findMatchesInPlay($start, $end->format('Y-m-d'));
                        if (!$response)
                        {
                            echo '<span class="error"> Chwilowy brak połączenia z serwerem</span>';
                        }
                        foreach ($response->matches as $match)
                        {
                            $matchDate = substr($match->utcDate, 0, 10);
                            echo '<tr class="type">';
                            echo '<td>'.$matchDate.'</td>';
                            echo '<td class="home">'.$match->homeTeam->name.'</td>';
                            echo '<td>:</td>';
                            echo '<td class="away">'.$match->awayTeam->name.'</td>';
                            echo '<td>'.$match->score->fullTime->homeTeam.' : '.$match->score->fullTime->awayTeam.' <img src="../../img/blink-green.gif" class="blinkGreen break" alt="blinking green light"></td>';
                            echo '</tr>';
                            $counter = $counter+1;
                        }
                        // ściągamy wszystkie zakończone mecze (od daty 17-09-18 - czyli główne rozgrywki)
                        $response = $api->findMatchesFinished($start, $end->format('Y-m-d'));
                        foreach ($response->matches as $match)
                        {
                            $matchDate = substr($match->utcDate, 0, 10);
                            echo '<tr class="type">';
                            echo '<td>'.$matchDate.'</td>';
                            echo '<td class="home">'.$match->homeTeam->name.'</td>';
                            echo '<td>:</td>';
                            echo '<td class="away">'.$match->awayTeam->name.'</td>';
                            echo '<td>'.$match->score->fullTime->homeTeam.' : '.$match->score->fullTime->awayTeam.'</td>';
                            echo '</tr>';
                            $counter = $counter+1;
                        }
                        
                        if ($counter==0)
                        {
                            echo '<tr class="type"><td colspan="7">Brak pozycji</td></tr>';
                        }

                    ?>
                </table>
            </div>
            
            <br/>
            <h3><a href="../../index.php">Strona główna</a></h3>
            <br/>
        </section>
    </div>
    <?php include "../templates/footer.php"; ?>
    <script src='../../js/script.js'></script>
</body>