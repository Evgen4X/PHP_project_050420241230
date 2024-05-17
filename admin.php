<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <?php
        $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
        $data = mysqli_fetch_row(mysqli_query($id, "select imie, nazwisko, admin from klient where id_klienta = ".$_SESSION['uid'].";"));
        $imie = $data[0] ? "'".$data[0]."'" : "''";
        $nazwisko = $data[1] ? "'".$data[1]."'" : "''";
        if($data[2] != 1){
            header("Location: index.php");
            die;
        }

        echo "<nav>";

        echo "Witaj, ".($imie ? substr($imie, 1, strlen($imie) - 2) : '').'!';
        echo "
            <div onclick='window.location.href = window.location.href.replace(\"admin\", \"index\");'>Wróć</div>
            <div id='type-klient' onclick=\"toggle('klient');\">Klient</div>
            <div id='type-ksiazka' onclick=\"toggle('ksiazka');\">Książka</div>
        </nav>";

        echo "<main></main>";

        echo "<footer><span>Created by <a href='https://github.com/Evgen4X'>Evgen4X</a></span><span>".date("d.m.Y")."</span></footer>";

        echo "<script> setTimeout(() => {toggle('klient');}, 10); </script>";
        
    ?>

    <script>
        function toggle(type){
            document.querySelectorAll('nav div').forEach(div => {
                div.style.backgroundColor = '#2f2f2f';
                div.style.borderColor = '#2f2f2f';
            });
            document.getElementById('type-' + type).style.backgroundColor = '#ef6461';
            document.getElementById('type-' + type).style.borderColor = '#ef6461';
            if(type == 'ksiazka'){
                main.innerHTML = `
                    
                `; //TODO: do.
            } else if(type == 'klient'){
                main.innerHTML = `

                `; //TODO: do.
            }
        }

        const main = document.querySelector('main');

    </script>
</body>
</html>