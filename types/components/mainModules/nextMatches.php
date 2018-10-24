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
    <link rel="stylesheet" href="../../css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
</head>

<body>
    <?php include "../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h1 class="title">Nadchodzące mecze: najbliższe 3 dni</h1>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="center">Data</th>
                        <th class="center">Godzina</th>
                        <th class="home">Gospodarze</th>
                        <th></th>
                        <th class="away">Goście</th>
                    </tr>
                    <?php
                    
                        include '../configModules/FootballData.php';
                        
                        $api = new FootballData();

                        // ściągamy wszystkie zakończone mecze - od rozpoczęcia głównych rozgrywek, 
                        $now = new DateTime();
                        $end = new DateTime(); $end->add(new DateInterval('P3D')); 
                        $response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'));
                        if (!$response)
                        {
                            echo '<span class="error"> Chwilowy brak połączenia z serwerem</span>';
                        }
                        if (!$response->matches)
                        {
                            echo '<tr class="type"><td colspan="5">Brak pozycji</td></tr>';
                        }
                        foreach ($response->matches as $match)
                        {
                            $fullDate = $match->utcDate;
                            $matchDate = substr($fullDate,0,10 );
                            // dodaję dwie godziny, żeby czas był poprawny dla naszej strefy czasowej
                            $matchHour = substr($fullDate, 11, 2)+2;
                            $matchMin = substr($fullDate, 14, 2);
                            
                            echo '<tr class="type">';
                            echo '<td>'.$matchDate.'</td>';
                            echo '<td>'.$matchHour.':'.$matchMin.'</td>';
                            echo '<td class="home">'.$match->homeTeam->name.'</td>';
                            echo '<td>:</td>';
                            echo '<td class="away">'.$match->awayTeam->name.'</td>';
                            echo '</tr>';
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
</body>