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
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
</head>

<body>
    <?php include "../templates/header.php"; ?>
    <div class="background">
        <section class="main_width">
            <h1 class="title">Zasady gry</h1>
            <ol>
                <li>Aplikacja TYPowisko służy do zabawy w typowanie wyników meczów piłkarskich</li>
                <li>Typujemy wyniki meczów w ramach aktualnie trwającej imprezy</li>
                <li>Informacja o aktualnej imprezie zamieszczona jest na stronie głównej</li>
                <li>Aby wprowadzić i / lub przeglądać swoje typy należy zalogować do systemu</li>
                <li>Za poprawne wytypowanie wyniku gracz otrzymuje 3 punkty</li>
                <li>Za poprawne wskazanie zwycięzcy meczu gracz otrzymuje 1 punkt</li>
                <li>Za poprawne wytypowanie remisu gracz otrzymuje 1 punkt</li>
                <li>Aby zmienić swój typ należy go najpierw usunąć z listy</li>
                <li>Typy można wprowadzać dla meczów, które jeszcze się nie zaczęły</li>
                <li>Typujemy wyniki uzyskane w regulaminowym czasie gry</li>
            </ol>
            <br/>
            <h3><a href="../../index.php">Strona główna</a></h3>
        </section>
    </div>
    <?php include "../templates/footer.php"; ?>
</body>