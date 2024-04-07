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
        <form action="reporter.php" method="post">
            <span>Zgłoś problem</span>
            <textarea name="description"></textarea>
            <div id="error">
                <?php
                    if(isset($_GET['err'])){
                        switch($_GET['err']){
                            case 1:
                                echo "Nie udało się połączyć z serwerem. Spróbuj później";
                                break;
                            case 3:
                                echo "Wystąpił problem z bazą danych. Nie możesz tego nawet zgłosić...";
                                break;
                        }
                    }
                ?>
            </div>
            <input type="submit">
            <a href="register.php">Zgłoś</a>
        </form>
    </div>
</body>
</html>