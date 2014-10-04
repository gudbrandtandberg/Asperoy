<?php
    // dette skriptet skal enten: ta brukeren til hjem
    // eller: be brukeren rette opp sine feil
    // eller: ta brukeren til 'ny bruker' området
    
    session_start();
    
    if (isset($_POST["logginn"])){  //bruker trykket på 'Logg inn'
        if (($_POST["brukernavn"] != "") && ($_POST["passord"] != "")){
            // her burde vi bruke passport for å autentisere
            if (true){  //infoen oppgitt var riktig
                
                $_SESSION["feil"] = false;
                $_SESSION["loggedIn"] = true;
                $_SESSION["brukernavn"] = $_POST["brukernavn"];
                
                header("Location: index.php");
            }
            
            else {
                echo "Du ga feilinnformasjon";
            }
        }
        else { //formen ble ikke utfyllt
            $_SESSION["feil"] = true;
        }
    }
    elseif (isset($_POST["nybruker"])){
        
        echo "hello verden";
    }
?>

<html>
    <head>   <!-- Det virker som om head ikke blir lest av load() funksjonen..? -->
        <meta charset="utf-8">
        <title>Log inn til Asperøy</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="shortcut icon" href="../images/asperøyico.ico" type="image/x-icon">
	<link rel="icon" href="../images/asperøyico.ico" type="image/x-icon">
    </head>
    
    <body>
        
        <div class="innholdboks">
            <h3>Log inn til Asperøy</h3>
            
            <div id="feilmelding">
                <?php
                    if ($_SESSION["feil"] == true){
                        echo "Du må oppgi riktig informasjon faktisk..";
                    }
                ?>
            </div>
            
            <form name="input" action="login.php" method="post"> <!-- form som blir behandlet av skriptet øverst her -->
                <table id="tabell" align="center">
                    <tr>
                        <td>Brukernavn:</td>
                        <td><input type="text" name="brukernavn"></td>
                    </tr>
                    <tr>
                        <td>Passord:</td>
                        <td><input type="password" name="passord"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Ny bruker" name="nybruker"></td>
                        <td><input type="submit" value="Logg inn" name="logginn"></td>
                    </tr>
                </table>
            </form>
        </div>
        
    </body>
    
    
</html>