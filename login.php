<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Ksiegarnia Internetowa</title>
</head>
<body>
    <form action="logger.php" method="post">
        <fieldset>
            <legend>Log In</legend>
            <input type="login" id="login">
            <input type="password" id="password">
            <button onclick="check();">
            <a href="register.php">Create an account</a>
        </fieldset>
    </form>

    <script>
        function check(){
            if(!document.getElementById("login").value){
                return 1;
            } else if(!document.getElementById("password").value){
                return 2;
            } else if(document.getElementById("password").value.length < 8){
                return 3;
            }
            return 0;
        }
    </script>
</body>
</html>