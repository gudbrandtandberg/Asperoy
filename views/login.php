<?php
    session_start();
    ob_start();  //output buffering
    
    // dette skriptet skal enten: ta brukeren til hjem
    // eller: be brukeren rette opp sine feil
    // eller: ta brukeren til 'ny bruker' området
    
    require_once("helpers.php");
    
    if (isset($_POST["logginn"])){  //bruker trykket på 'Logg inn'
        if (($_POST["brukernavn"] != "") && ($_POST["passord"] != "")){
            
	    // her burde vi bruke passport (eller noe egenskrevet?) for å autentisere
	    $authenticated = true;
	    
            if ($authenticated){  //infoen oppgitt var riktig
                
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
        header("Location: index.php?page=nybruker");
    }
?>

<?php render("views/templates/simple_header");?>

<script type="text/javascript">
    $(document).ready(function(){
	document.getElementById("brukernavn").focus();
    });
</script>

<div class="innholdboks">
    
    <h3>Log inn til Asperøy.no</h3>
    
    <p class="feilmelding">
	<? if ($_SESSION["feil"] == true): ?>
	    Feil brukernavn/passord
	<? endif ?>
    </p>
    
    <form method="post">
	<table id="tabell" align="center">
	    <tr>
		<td>Brukernavn:</td>
		<td><input id="brukernavn" type="text" name="brukernavn"></td>
	    </tr>
	    <tr>
		<td>Passord:</td>
		<td><input type="password" name="passord"></td>
	    </tr>
	    <tr><td><br></td></tr>
	    <tr>
		<td><input type="submit" value="Logg inn" name="logginn"></td>
		<td><input type="submit" value="Ny bruker" name="nybruker"></td>
	    </tr>
	</table>
    </form>
</div>
        
<?php render("views/templates/footer");?>