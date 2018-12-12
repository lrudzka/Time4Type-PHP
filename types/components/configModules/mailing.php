<?php


require_once 'PHPMailer.php';
require_once 'SMTP.php';
            
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once 'database.php';
$usersQuery = $db->query('SELECT email FROM types_users WHERE  mailing=1');
$users = $usersQuery->fetchAll();



include 'autoloader.php';
                        
$api = new FootballData();
$event = new CurrentEvent();

// ściągamy mecze o statusie "SCHEDULED" - żeby sprawdzić datę następnego meczu
$start = $event::START_DATE;
$end = $event::END_DATE; 
$response = $api->findMatchesForDateRange($start, $end);
    
$nextMatchDate;
foreach ($response->matches as $match)
{
    $nextMatchDate = $match->utcDate;
    break;
}
    
$nextMatchDate = substr($nextMatchDate, 0, 10);
    
$today = new DateTime;
$plus2Days = $today->modify("+2 days");
$plus2DaysFormat = $today->format("Y-m-d");


if ($nextMatchDate == $plus2DaysFormat)
{
    //wysyłka maila
    $mail = new PHPMailer(true);  
    // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = '************';                          // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '************';                       // SMTP username
        $mail->Password = '************';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->CharSet = 'utf8';

        //Recipients
        $mail->setFrom('noreply@mycoding.eu', 'TYPowisko');

        foreach ($users as $user)
        {
            $mail->addAddress($user['email']);
        }

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Serwis TYPowisko zaprasza do typowania';
        $mail->Body    = "<div style=".'"font-size: 23px;"'.">Drogi użytkowniku serwisu TYPowisko</div><br/><br/>
                          <div style=".'"font-size: 20px;"'.">Kolejne mecze tuż tuż!</div><br/>
                          <div style=".'"font-size: 20px;"'.">Typowanie jest już dostępne! Nie przegap!</div><br/><br/>
                          <div style=".'"font-size: 20px;"'."><a href=".'"http://types.mycoding.eu/components/userModules/login.php"'.">***Kliknij tutaj, aby przejść do aplikacji***</a></div>";
        $mail->AltBody = 'Typowanie jest już dostępne, ZAPRASZAMY!!!';

        $mail->send();

        } catch (Exception $e) {
           
        }
} 

