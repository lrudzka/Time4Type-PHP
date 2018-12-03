<?php
    session_start();
    
    $_SESSION['level']='1.3';

    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
    }
    
    include '../configModules/autoloader.php';
    
    require_once '../configModules/database.php';
    
    if (isset($_POST['i']))
    {
        
        $nowTime = new DateTime();
        $nowTime = $nowTime->format('Y-m-d H:i');
        $tooLateCounter = 0;
        for ($j=1; $j<$_POST['i']; $j++)
        {
            if ( ($_POST['homeTeamType'.$j]<>'') && ($_POST['awayTeamType'.$j]<>'') )
            {
                $matchTime = $_POST['matchDate'.$j].' '.$_POST['matchHour'.$j];
                
                // sprawdzenie czy mecz jeszcze się nie rozpoczął
                if ($nowTime > $matchTime)
                {
                    $tooLateCounter = $tooLateCounter+1;
                }
                else
                {
                    $matchId = $_POST['matchId'.$j];
                    $matchDate = $_POST['matchDate'.$j];
                    $queryCheck = $db->prepare('INSERT INTO types_types (id, user, matchId, matchDate, homeTeamName, awayTeamName, homeTeamType, awayTeamType, status) VALUES (NULL, "'.$_SESSION['userLoggedIn'].'", :matchId, :matchDate, :homeTeamName, :awayTeamName,:homeTeamType, :awayTeamType, "SCHEDULED")');
                    $queryCheck->bindValue(':matchId', $_POST['matchId'.$j], PDO::PARAM_STR);
                    $queryCheck->bindValue(':matchDate', $_POST['matchDate'.$j], PDO::PARAM_STR); 
                    $queryCheck->bindValue(':homeTeamName', $_POST['homeTeamName'.$j], PDO::PARAM_STR);
                    $queryCheck->bindValue(':awayTeamName', $_POST['awayTeamName'.$j], PDO::PARAM_STR);
                    $queryCheck->bindValue(':homeTeamType', $_POST['homeTeamType'.$j], PDO::PARAM_STR);
                    $queryCheck->bindValue(':awayTeamType', $_POST['awayTeamType'.$j], PDO::PARAM_STR);
                    $queryCheck->execute();
                }
               
                // jeśli były jakieś wpisy dla rozpoczętych już meczów:
                if ($tooLateCounter>0)
                {
                    $_SESSION['tooLateCounter']=$tooLateCounter; 
                }
               
            }
        }
        
    }
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
</head>

<body>
<?php include "../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            
            <?php
                // Create instance of API class
                $api = new FootballData();
                // fetch all available upcoming matches for the next 3 days
                $now = new DateTime();
                
                $end = new DateTime(); $end->add(new DateInterval('P3D'));
                $timeDiff = date('Z')/3600; // przesunięcie godzinowe dla naszej strefy czasowej
                $response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'));
                if (!$response)
                {
                    echo '<span class="error"> Chwilowy brak połączenia z serwerem</span>';
                }
            ?>
            
            <h3 class="title">Nadchodzące mecze: 3 dni do przodu</h3>
            <form method="POST">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="center">Gospodarze</th>
                            <th></th>
                            <th class="center">Goście</th>
                            <th class="center" >Data</th>
                            <th class="center" >Godzina</th>
                            <th class="center" colspan="3">Wrowadź swoje typy</th>
                        </tr>
                            <?php $i=1;
                            
                            foreach ($response->matches as $match) { 

                                //sprawdzamy, czy dany użytkownik ma już wprowadzony typ dla danego meczu

                                $id = $match->id;

                                $matchQuery = $db->prepare('SELECT id FROM types_types WHERE user="'.$_SESSION['userLoggedIn'].'" AND matchId='.$id);
                                $matchQuery-> execute();

                                $type = $matchQuery->fetch();

                                if (!$type)
                                {

                                $fullDate = $match->utcDate;
                                $matchDate = substr($fullDate,0,10 );
                                // dodaję przesunięcie godzinowe, żeby czas był poprawny
                                $matchHour = substr($fullDate, 11, 2)+$timeDiff;
                                $matchMin = substr($fullDate, 14, 2);

                                echo '<tr class="type">';
                                echo '<td><input class="hidden" name="homeTeamName'.$i.'" id="homeTeamName'.$i.'" value="'.$match->homeTeam->name.'" >'.$match->homeTeam->name.'</td>';
                                echo '<td>:</td>';
                                echo '<td><input class="hidden" name="awayTeamName'.$i.'" id="awayTeamName'.$i.'" value="'.$match->awayTeam->name.'" >'.$match->awayTeam->name.'</td>';
                                echo '<td><input class="hidden" name="matchDate'.$i.'" id="matchDate'.$i.'" value="'.$matchDate.'" >'.$matchDate.'</td>';
                                echo '<td><input class="hidden" name="matchHour'.$i.'" id="matchHour'.$i.'" value="'.$matchHour.':'.$matchMin.'" >'.$matchHour.':'.$matchMin.'</td>';
                                echo '<td><input class="type" type="number" name="homeTeamType'.$i.'" id="homeTeamType'.$i.'"></td>';
                                echo '<td>:</td>';
                                echo '<td><input class="type" type="number" name="awayTeamType'.$i.'" id="awayTeamType'.$i.'"></td>';
                                echo '<td><input class="hidden" name="matchId'.$i.'" id="matchId'.$i.'" value="'.$match->id.'" ></td>';
                                echo '</tr>';
                                $i = $i+1; 
                                }
                            } 
                             echo '<input class="hidden" type="number" name="i" id="i" value='.$i.'>';
                             
                             if ($i==1)
                             {
                                 echo '<tr class="type"><td  colspan="8">Na razie brak kolejnych pozycji</td></tr>';
                             }

                            ?>                     
                    </table>
                </div>
                <button type="submit" class="btn btn-success btn-lg">Prześlij wprowadzone typy</button>
                <?php
                    if (isset($_SESSION['tooLateCounter']))
                    {
                        echo "<span class=".'"wrongData"'.">Liczba rekordów odrzuconych z powodu przekroczonej daty/godziny rozpoczęcia meczu: {$_SESSION['tooLateCounter']}</span>";   
                        unset($_SESSION['tooLateCounter']);
                    }
                ?>
            </form>
            <br/>

            
            <h4><a href="userPanel.php">Panel użytkownika</a></h4>
            <h4><a href="../../index.php">Strona główna</a></h4>
            <h4><a href="logout.php">Wyloguj się</a></h4>
            <br/>
        </section>
    </div>

    
    <?php include "../templates/footer.php"; ?>
</body>
</html>