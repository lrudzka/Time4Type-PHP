
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Header</title>
</head>
<body>
    <header>
        <div class="main_width">
            <div class="headerBox">
            <?php
                if (isset($_SESSION['level']))
                {
                    if ($_SESSION['level']=='0')
                    {
                        echo '<a href="index.php"><div title="strona główna" class="home"></div></a>';
                        echo '<a href="components/userModules/userPanel.php"><div title="panel użytkownika" class="user"></div></a>';
                    }
                    if ($_SESSION['level']=='1.1')
                    {
                        echo '<a href="../../index.php"><div title="strona główna" class="home"></div></span></a>';
                        echo '<a href="../userModules/userPanel.php"><div title="panel użytkownika" class="user"></div></a>';
                    }
                    if ($_SESSION['level']=='1.3')
                    {
                        echo '<a href="../../index.php"><div title="strona główna" class="home"></div></span></a>';
                        echo '<a href="userPanel.php"><div title="panel użytkownika" class="user"></div></a>';
                    }
                    unset($_SESSION['level']);
                }
            ?>
                <div class="name">TYPowisko</div>
            </div>
        </div>
    </header>
</body>
</html>