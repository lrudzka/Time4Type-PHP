<?php
    session_start();
    
    require_once '../configModules/PHPMailer.php';
    require_once '../configModules/SMTP.php';
            
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    

    
    if (isset($_SESSION['userLoggedIn']))
    {
        header ('Location: userPanel.php');
    }
    
    $_SESSION['level']='1.3';
    
    require_once '../configModules/database.php';
    
        
    
    if (isset($_POST['email']))
    {
        
            
        // walidacja podanego adresu
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        $emailOk = true;
        
        
        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $emailOk = false;
            $_SESSION['e_email']="Wprowadzony adres e-mail nie jest poprawy";
        } 
        
        //sprawdzamy, czy email jest w bazie
        $queryCheck = $db->prepare('SELECT * FROM types_users WHERE email=:email');
        $queryCheck->bindValue(':email', $email, PDO::PARAM_STR);
        $queryCheck->execute();
        $emailAlreadyExists = $queryCheck->fetch();
         
        if (!$emailAlreadyExists)
        {
            $emailOk = false;
            $_SESSION['e_email'] = "Podany adres nie jest zarejestrowany w naszej bazie";
        }
        
        if ($emailOk)
        {
            
            include "../configModules/autoloader.php";
            $np = new NewPassword();
            $newPwd = $np->setNewPassword();
            $newPwd_hash = password_hash($newPwd, PASSWORD_DEFAULT);
            $queryPwd = $db->prepare('UPDATE types_users set password=:password WHERE email=:email');
            $queryPwd->bindValue(':password', $newPwd_hash, PDO::PARAM_STR);
            $queryPwd->bindValue(':email', $email, PDO::PARAM_STR);
            $queryPwd->execute();
            
            
            //wysyłka maila
            $mail = new PHPMailer(true);  
            // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = '*****************';                          // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = '*****************';                 // SMTP username
                $mail->Password = '*****************';                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to
                $mail->CharSet = 'utf8';

                //Recipients
                $mail->setFrom('noreply@mycoding.eu', 'TYPowisko');
                $mail->addAddress($email, $email);     // Add a recipient
            
                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Zmiana hasła';
                $mail->Body    = "<div style=".'"font-size: 20px;"'.">Drogi użytkowniku serwisu TYPowisko</div><br/><br/>
                                  <div style=".'"font-size: 18px;"'.">Twoje nowe - tymczasowe - hasło do naszego serwisu to:</div><br/> 
                                  <div style=".'"font-size: 18px;"'.">$newPwd</div><br/>
                                  <div style=".'"font-size: 18px;"'.">Zaloguj się do serwisu korzystając z podanego hasła, 
                                            a następnie zmień je na nowe.
                                  </div><br/>
                                  <div style=".'"font-size: 18px;"'.">
                                    <a href=".'"http://types.mycoding.eu/components/userModules/login.php"'.">*** Kliknij tutaj, aby przejść do aplikacji ***</a>
                                  </div>";
                $mail->AltBody = "Twoje nowe - tymczasowe - hasło do naszego serwisu to $newPwd, zaloguj się do serwisu i następnie ustaw sobie nowe hasło.";

                $mail->send();
                
            } catch (Exception $e) {
               $_SESSION['e_email'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
            }
            
            
            $_SESSION['emailInfo'] = "E-mail z nowym hasłem został wysłany";
            unset($_POST['email']);
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
            <h2>Odzyskiwanie dostępu do konta</h2>
            <br/>
            <h4>Podaj swój adres e-mail zarejestrowany w naszej bazie i kliknij 'Wyślij' - </h4>
            <h4>- w ten sposób otrzymasz na maila nowe - tymczasowe - hasło do konta.</h4>
            <h4>Po zalogowaniu się do konta nowym hasłem wejdź w ustawienia i zmień hasło na nowe.</h4>
            <br/>
            <br/>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Twój adres e-mail:</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="emal" name="email" value=<?php
                            if (isset($_POST['email'])) {
                                echo $_POST['email'];
                            }
                        ?>
                        >
                    </div>
                    <div class="col-sm-offset-3 col-sm-6">
                        <?php
                            if (isset($_SESSION['e_email']))
                            {
                                echo '<br/><span class="wrongData"><strong>'.$_SESSION['e_email'].'</strong></span>';
                                unset($_SESSION['e_email']);
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                    <input type="submit" class="btn btn-success" value="Wyślij">
                    </div>
                </div>
            </form>
            <div class="col-sm-offset-3 col-sm-6">
                <?php
                    if (isset($_SESSION['emailInfo']))
                    {
                        echo '<br/><span><strong>'.$_SESSION['emailInfo'].'</strong></span>';
                        unset($_SESSION['emailInfo']);
                    }
                ?>
            </div>
            <br/>
            <h3><a href="../../index.php">Strona główna</a></h3>
            <h3><a href="userPanel.php">Panel użytkownika</a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../templates/footer.php"; ?>
</body>
</html>

