<?php
    session_start();
    
    $_SESSION['level']='1.3';

    if (!isset($_SESSION['userLoggedIn']))
    {
        header ('Location: login.php');
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
</head>

<body>
<?php include "../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <?php
                echo '<h1>Witaj,<strong> '.$_SESSION['userLoggedIn'].'</strong></h1>';

            ?>
            <h3><a href="addTypes.php">Wprowadź nowe typy</a></h3>
            <h3><a href="userTypes.php">Historia typowania</a></h3>
            <h3><a href="../../index.php">Strona główna</a></h3>
            <h3><a href="logout.php">Wyloguj się</a></h3>
            <br/>
        </section>
    </div>

    
    <?php include "../templates/footer.php"; ?>
</body>
</html>