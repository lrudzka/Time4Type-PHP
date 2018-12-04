<?php
    session_start();
    $_SESSION['level']='0';
    
    include "components/configModules/autoloader.php";
                        
    $api = new FootballData();

    // ściągamy mecze o statusie "SCHEDULED" - żeby sprawdzić datę następnego meczu
    $event = new CurrentEvent;
    $start = $event::START_DATE;
    $end = $event::END_DATE; 
    $_SESSION['name'] = $event::EVENT_NAME;
    $response = $api->findMatchesForDateRange($start, $end);
    
    $nextMatchDate;
    foreach ($response->matches as $match)
    {
        $nextMatchDate = $match->utcDate;
        break;
    }
    
    $nextMatchDate = substr($nextMatchDate, 0, 10); 
    
    
    require_once 'components/configModules/database.php';
    $event = new CurrentEvent();
    
    // updatujemy dane dla zakończonych meczów
    // ściągamy wszystkie zakończone mecze - od rozpoczęcia głównych rozgrywek, i updatujemy
    // tabelę z typami
    $start = $event::START_DATE;
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
    
    
    
    $rankingQuery = $db->query('SELECT user FROM types_view_points WHERE points = (SELECT MAX(points) FROM types_view_points) ');
    $rankingRows = $rankingQuery->fetchAll();
    
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Time4Type</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
</head>

<body>
<?php include "components/templates/header.php"; ?>
	
    <div class="background">
        <section class="main_width">
            <?php
                if (!$response)
                {
                    echo '<span class="error">Chwilowy brak połączenia z serwerem</span>';
                }
            ?>
            <h1 class="welcomeText">Dołącz do gry już dziś...</h1>
            
            <br/>
            <br/>
            <section id="info">
                
                <table class=" table">
                    
                    <tr>
                        <td class="infoTitle"> Aktualny turniej: </td>
                        <td class="infoData"> <?php
                            echo $_SESSION['name'];
                        ?></td>
                    </tr>
                    <tr>
                        <td class="infoTitle"> Data następnego meczu: </td>
                        <td class="infoData"> <?php
                            echo $nextMatchDate;
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="infoTitle"> Aktualny lider rankingu: </td>
                        <td class="infoData"> <?php
                            $counter=1;
                            foreach ($rankingRows as $rankingRow)
                            {
                                if ($counter==1)
                                {
                                    echo $rankingRow['user'];
                                }
                                else 
                                {
                                    echo ', '.$rankingRow['user'];
                                }
                                $counter=$counter+1;
                            }
                        ?>
                        </td>
                    </tr>
                </table>
               
            </section>
            <h2><a href="components/mainModules/ranking.php">Ranking</a></h2>
            <h2><a href="components/mainModules/nextMatches.php">Nadchodzące mecze</a></h2>
            <h2><a href="components/mainModules/matchesHistory.php">Historia rozgrywek</a></h2>
            <h2><a href="components/mainModules/rules.php">Regulamin</a></h2>
            <?php
                if (isset($_SESSION['userLoggedIn']))
                {
                   echo '<h2><a href="components/userModules/userPanel.php">Panel użytkownika</a></h2>';
                   echo '<h2><a href="components/userModules/logout.php">Wyloguj się</a></h2>' ;
                }
                else
                {
                    echo '<h2><a href="components/userModules/login.php">Zaloguj się / zarejestruj się</a></h2>';
                }
            ?>
            <br/>
        </section>
    </div>
    <?php include "components/templates/footer.php"; ?>
</body>
</html>