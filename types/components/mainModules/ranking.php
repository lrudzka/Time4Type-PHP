<?php
    session_start();
    $_SESSION['level']='1.1';
    require_once '../configModules/database.php';
    
    include '../configModules/autoloader.php';
    
    $api = new FootballData();
    $event = new CurrentEvent();
    
    // updatujemy dane dla zakończonych meczów
    // ściągamy wszystkie zakończone mecze - od rozpoczęcia głównych rozgrywek, i updatujemy
    // tabelę z typami
    $start = $event::START_DATE;;
    $end = new DateTime(); 
    $response = $api->findMatchesFinished($start, $end->format('Y-m-d'));
    foreach ($response->matches as $match)
    {
        $typesQuery = $db->prepare('UPDATE types_types SET status="FINISHED", homeTeamResult='.$match->score->fullTime->homeTeam.', awayTeamResult='.$match->score->fullTime->awayTeam.' WHERE status<>"CLOSED" AND status<>"FINISHED" AND matchId='.$match->id);
        $typesQuery->execute();    
    }
    // ściągamy mecze w trakcie - i updatujemy tabelę z typami
    $response = $api->findMatchesInPlay($start, $end->format('Y-m-d'));
    foreach ($response->matches as $match)
    {
        $typesQuery = $db->prepare('UPDATE types_types SET status="IN_PLAY" WHERE status<>"CLOSED" AND status<>"FINISHED" AND matchId='.$match->id);
        $typesQuery->execute();    
    }
    
    //rozliczamy punkty i wstawiamy status "CLOSED" - tam, gdzie mecze są już zakończone
    // 3 punkty za prawidłowy wynik
    $close1Query = $db->prepare('UPDATE types_types SET points=3, status="CLOSED" WHERE status="FINISHED" AND homeTeamType=homeTeamResult AND awayTeamType=awayTeamResult');
    $close1Query->execute();
    // 1 punkt za poprawne wskazanie zwycięzcy bądź remisu
    $close2Query = $db->prepare('update types_types set status="CLOSED", points=1 WHERE status="FINISHED" AND ( ( homeTeamType>awayTeamType AND homeTeamResult>awayTeamResult  ) OR ( homeTeamType<awayTeamType AND homeTeamResult<awayTeamResult) OR ( homeTeamType=awayTeamType AND homeTeamResult=awayTeamResult ))');
    $close2Query->execute();
    // 0 punktów za pozostałe typy
    $close3Query = $db->prepare('update types_types set status="CLOSED", points=0 WHERE status="FINISHED" ');
    $close3Query->execute();
    
    $rankingQuery = $db->query('SELECT * FROM types_view_points ORDER BY points DESC ');
    $rankingRows = $rankingQuery->fetchAll();
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
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
</head>

<body>
    <?php include "../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <?php
                if (!$response)
                {
                    echo '<span class="error"> Chwilowy brak połączenia z serwerem</span>';
                }
            ?>
            <h1 class="title">Ranking</h1>
            <div class="table-responsive">
                <table class="table ranking">
                    <tr>
                        <th>Pozycja</th>
                        <th class="away">Login</th>
                        <th class="away">Liczba punktów</th>
                    </tr>
                <?php
                    $i=1;
                    $prevPoints=-10;
                    foreach ($rankingRows as $rankingRow)
                    {   
                        
                       if ( $rankingRow['points']==$prevPoints) 
                       {
                           $i = $i-1;
                       }
                       if ( $i == 1)
                       {
                          echo "<tr class=".'"ranking winner" '.">"; 
                       }
                       else
                       {
                          echo "<tr class=".'"ranking notwinner"'.">"; 
                       }
                       echo "<td class=".'"one"'.">{$i}.</td>";
                       echo "<td class=".'"away two"'.">{$rankingRow['user']}</td>";
                       echo "<td class=".'"away"'.">{$rankingRow['points']}</td>";
                       echo "</tr>";

                       $i = $i+1;
                       $prevPoints = $rankingRow['points'];
                    }
                ?>
                </table>
            </div>
            <h3><a href="../../index.php">Strona główna</a></h3>
        </section>
    </div>
    <?php include "../templates/footer.php"; ?>
</body>