<?php
    // dette skriptet skal enten: ta brukeren til hjem
    // eller: be brukeren rette opp sine feil
    // eller: ta brukeren til ny bruker området
    
    
    if (isset($_POST["brukernavn"]) && isset($_POST["passord"])){
        
        if (true){  //infoen oppgitt var riktig
            
            session_start();
            $_SESSION["loggedIn"] = true;
            $_SESSION["brukernavn"] = $_POST["brukernavn"];
            
            header("Location: index.php");
        }
        
        else {
            echo "Du ga feilinnformasjon";
        }
    }

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Log inn til Asperøy</title>
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        
        <div class="innholdboks">
        <h3>Log inn til Asperøy</h3><br>
        <form name="input" action="login.php" method="post"> <!-- form som blir behandlet av skriptet øverst her -->
            Brukernavn: <input type="text" name="brukernavn"> <br>
            Passord: <input type="password" name="passord"> <br>
            <input type="submit" value="Ny bruker">
            <input type="submit" value="Log inn">
        </form>
        </div>
        
    </body>
    
    
</html>