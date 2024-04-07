<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <div id="form">
        <form action="logger.php" method="post">
            <span>Zaloguj się</span>
            <input type="text" id="login" name="login" placeholder="login" requied>
            <input type="password" id="password" name="password" placeholder="hasło" requied>
            <div id="error">
                <?php
                    if(isset($_GET['err'])){
                        switch($_GET['err']){
                            case 1:
                                echo "Nie udało się połączyć z serwerem. Spróbuj później";
                                break;
                            case 3:
                                echo "Wystąpił problem z bazą danych. Zgłoś to <a href='report.php'>tutaj</a>";
                                break;
                            case 3:
                                echo "Niepoprawny login lub hasło";
                                break;
                        }
                    }
                ?>
            </div>
            <input type="submit">
            <a href="register.php">Utwórz konto</a>
        </form>
    </div>
</body>
</html>