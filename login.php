<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <canvas width="" height=""></canvas>
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
                                echo "Nie udało się połączyć z serwerem. Spróbuj później lub zgłoś to <a href='report.php/?errcode=".(isset($_GET['errcode']) ? $_GET['errcode'] : null)."&errdesc=".(isset($_GET['errdesc']) ? $_GET['errdesc'] : null)."'>tutaj</a>";
                                break;
                            case 2:
                                echo "Wystąpił problem z bazą danych. Zgłoś to <a href='report.php/?errcode=".(isset($_GET['errcode']) ? $_GET['errcode'] : null)."&errdesc=".(isset($_GET['errdesc']) ? $_GET['errdesc'] : null)."'>tutaj</a>";
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
            let b = [Math.floor(Math.random() * CWidth), Math.floor(Math.random() * CHeight), Math.random() * 2 - 1, Math.random() * 2 - 1, Math.floor(Math.random() * 4 + 1)];
            let n = bubbles.length;
            bubbles.push(b);
            console.log(bubbles);
            setTimeout(() => {
                bubbles.splice(n, 1);
            }, Math.floor(Math.random() * 10000));
            setTimeout(gen, Math.floor(Math.random() * 5000));
        }

        function anim(){
            ctx.fillStyle = "black";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "white";
            bubbles.forEach(bubble => {
                bubble[0] += bubble[2];
                bubble[1] += bubble[3];
                if(Math.random() < 0.05){
                    bubble[2] = Math.random() * 2 - 1;
                    bubble[3] = Math.random() * 2 - 1;
                }
                ctx.beginPath();
                ctx.arc(bubble[0], bubble[1], bubble[4], 0, 360);
                ctx.fill();
            });
        }

        const canvas = document.querySelector('canvas');

        const CWidth = window.innerWidth;
        const CHeight = window.innerHeight;

        canvas.setAttribute("width", CWidth);
        canvas.setAttribute("height", CHeight);

        const ctx = canvas.getContext('2d');

        var bubbles = [];

        for(let i = 0; ++i < 200; gen());

        setTimeout(gen, Math.floor(Math.random() * 5000));
        setInterval((anim), 40);
  
        const password = document.getElementById("show-password");
        function togglePassword(){
            document.getElementById("password").setAttribute("type", document.getElementById("password").getAttribute("type") == "password" ? "text" : "password");
            // document.getElementById("password").value = document.getElementById("password").value;
        }
    </script>
</body>
</html>
