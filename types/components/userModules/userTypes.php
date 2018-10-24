<?php
    session_start();
    
    $_SESSION['level']='1.3';

    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
    }
    
    require_once '../configModules/database.php';
    
    include '../configModules/FootballData.php';
    
    $api = new FootballData();
    
    // updatujemy dane dla zakończonych meczów
    // ściągamy wszystkie zakończone mecze - od rozpoczęcia głównych rozgrywek
    $start = '2018-09-17';
    $end = new DateTime(); 
    $response = $api->findMatchesFinished($start, $end->format('Y-m-d'));
    foreach ($response->matches as $match)
    {
        $typesQuery = $db->prepare('UPDATE types_types SET status="FINISHED", homeTeamResult='.$match->score->fullTime->homeTeam.', awayTeamResult='.$match->score->fullTime->awayTeam.' WHERE status<>"CLOSED" AND status<>"FINISHED" AND matchId='.$match->id);
        $typesQuery->execute();    
    }
    
    
    // updatujemy dane dla rozpoczętych meczów
    $response = $api->findMatchesInPlay($start, $end->format('Y-m-d'));
    foreach ($response->matches as $match)
    {
        $typesQuery = $db->prepare('UPDATE types_types SET status="IN_PLAY", homeTeamResult='.$match->score->fullTime->homeTeam.', awayTeamResult='.$match->score->fullTime->awayTeam.' WHERE status<>"CLOSED" AND status<>"FINISHED" AND matchId='.$match->id);
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
    
    
    
    
    $userOpenTypesQuery = $db->query('SELECT * FROM types_types WHERE status="SCHEDULED"  AND user="'.$_SESSION['userLoggedIn'].'"');
    $userOpenTypes = $userOpenTypesQuery->fetchAll();
    $userClosedTypesQuery = $db->query('SELECT * FROM types_types WHERE (status="CLOSED" OR status="IN_PLAY") AND user="'.$_SESSION['userLoggedIn'].'" ORDER BY matchDate DESC');
    $userClosedTypes = $userClosedTypesQuery->fetchAll();
    $userPointsQuery = $db->query('SELECT points from types_view_points WHERE user = "'.$_SESSION['userLoggedIn'].'"');
    $userPoints = $userPointsQuery -> fetch();
    
  
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
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
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
            
            <h2 class="title">TWOJA HISTORIA TYPOWANIA</h2>
            <h3 class="title">Typy otwarte</h3>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="center">Data</th>
                        <th class="home">Gospodarze</th>
                        <th></th>
                        <th class="away">Goście</th>
                        <th class="center">Twój typ</th>
                        <th class="center">Usuwanie</th>
                    </tr>
                <?php
                    if (!$userOpenTypes)
                    {
                        echo '<tr class="type"><td colspan="8">Brak wpisów</td></tr>';
                    }
                    foreach ($userOpenTypes as $userOpenType)
                    {
                        echo '<tr class="type">';
                            echo "<td>{$userOpenType['matchDate']}</td>";
                            echo "<td class=".'"home"'.">{$userOpenType['homeTeamName']}</td>";
                            echo "<td>:</td>";
                            echo "<td class=".'"away"'.">{$userOpenType['awayTeamName']}</td>";
                            echo "<td>{$userOpenType['homeTeamType']} : {$userOpenType['awayTeamType']}</td>";
                            echo "<td><a href=".'"'."deleteType.php?matchId={$userOpenType['matchId']}".'"'." class=".'"btn btn-danger btn-sm"'.">x</a></td>";
                        echo '</tr>';

                    }

                ?>
                </table>
            </div>
            
            <h3 class="title">Typy zamknięte</h3>
            <section class="closedTypesHeader">             
                <input type="text" class="form-control searchTeam" placeholder="Wyszukaj drużynę">
                <h4 class="sum"><strong>Suma zdobytych punktów: <?php
                    echo $userPoints['points'];
                    ?></strong>
                </h4>
            </section>
               
            <div class="table-responsive">
                <table class="table  history">
                    <tr>
                        <th class="center"><span class="sort">Data</span> <button  class="sortUp btn sort btn-succes btn-lg"></button></th>
                        <th class="home">Gospodarze</th>
                        <th></th>
                        <th class="away">Goście</th>
                        <th class="center">Twój typ</th>
                        <th class="center">Końcowy wynik</th>
                        <th class="center">Punkty</th>
                    </tr>
                <?php
                    if (!$userClosedTypes)
                    {
                        echo '<tr class="type"><td colspan="7">Brak wpisów</td></tr>';
                    }
                    foreach ($userClosedTypes as $userClosedType)
                    {
                        echo '<tr class="type">';
                            echo "<td>{$userClosedType['matchDate']}</td>";
                            echo "<td class=".'"home"'.">{$userClosedType['homeTeamName']}</td>";
                            echo "<td> : </td>";
                            echo "<td class=".'"away"'.">{$userClosedType['awayTeamName']}</td>";
                            echo "<td>{$userClosedType['homeTeamType']} : {$userClosedType['awayTeamType']}</td>";
                            echo "<td>{$userClosedType['homeTeamResult']} : {$userClosedType['awayTeamResult']}</td>";
                            if ($userClosedType['status']=='IN_PLAY')
                            {
                                echo '<td><img src="../../img/blink-green.gif" class="blinkGreen" alt="blinking green light"></td>';
                            }
                            else
                            {
                              echo "<td>{$userClosedType['points']}</td>";  
                            }
                        echo '</tr>';

                    }

                ?>
                </table>
            </div>
        
            <h3><a href="userPanel.php">Panel użytkownika</a></h3>
            <h3><a href="../../index.php">Strona główna</a></h3>
            <h3><a href="logout.php">Wyloguj się</a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../templates/footer.php"; ?>
    <script src='../../js/script.js'></script>
</body>
</html>