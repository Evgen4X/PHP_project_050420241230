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
            <div id="password-div" style="display: flex; justify-content: center; align-items: center; flex-direction: row;">
                <input type="password" id="password" name="password" placeholder="hasło" requied>
                <div id="show-password" onclick="togglePassword();"></div>
            </div>
            <div id="error">
                <?php
                    if(isset($_GET['err'])){
                        switch($_GET['err']){
                            case 1:
                                echo "Nie udało się połączyć z serwerem. Spróbuj później";
                                break;
                            case 2:
                                echo "Wystąpił problem z bazą danych. Zgłoś to <a href='report.php'>tutaj</a>";
                                break;
                            case 3:
                                echo "Niepoprawny login lub hasło";
                                break;
                        }
                    }
                ?>
            </div>
            <div id="error-desc">
                <?php
                    if(isset($_GET['errdesc'])){
                        echo 'Błąd '.$_GET['errdesc'];
                    }
                ?>
            </div>
            <input type="submit">
            <a href="register.php">Utwórz konto</a>
        </form>
    </div>

    <script>
        function gen(){
    let b = [Math.floor(Math.random() * CWidth), Math.floor(Math.random() * CHeight)];
    let n = bubbles.length;
    bubbles.push(b);
    setTimeout(() => {
        bubbles.splice(n, 1);
    }, Math.floor(Math.random() * 10000));
}

function anim(){
    
} 

const canvas = document.querySelector('canvas');

const ctx = canvas.getContext('2d');

const CWidth = window.innerWidth;
const CHeight = window.innerHeight;
var bubbles = [];

for(let i = 0; ++i < 100; gen);

setInterval(gen, 5000);
  
        const password = document.getElementById("show-password");
        function togglePassword(){
            document.getElementById("password").setAttribute("type", document.getElementById("password").getAttribute("type") == "password" ? "text" : "password");
            // document.getElementById("password").value = document.getElementById("password").value;
        }
    </script>
</body>
</html>
