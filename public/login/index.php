<?php
    if (!isset($_SESSION))
    {
	session_start();
    }

ob_start();  //output buffering
error_reporting(E_ALL);

// dette skriptet skal enten: ta brukeren til hjem
// eller: be brukeren rette opp sine feil
// eller: ta brukeren til 'ny bruker' området

$fullphpdir = getcwd();
$fulldir = dirname($_SERVER["PHP_SELF"]);

require_once("../renderHelpers.php");
include_once("../../UserController.php");

$userController = UserController::getInstance();
$_SESSION["feil"] = false;

if (!empty($_POST)){
    if (($_POST["brukernavn"] != "") && ($_POST["passord"] != "")){

        $brukernavn = $_POST["brukernavn"];
        $passord = $_POST["passord"];

        $authenticated = $userController->verifyUser($brukernavn, $passord);

        if ($authenticated){  //infoen oppgitt var riktig

            $_SESSION["feil"] = false;
            $_SESSION["loggedIn"] = true;
            $_SESSION["brukernavn"] = $_POST["brukernavn"];

            header("Location: /hjem/");
        } else {
            $_SESSION["feil"] = true;
        }
    }
    else { //formen ble ikke utfyllt
        $_SESSION["feil"] = true;
    }
}
?>

<?php render("views/templates/simple_header");?>
<link rel="stylesheet" type="text/css" href="/styles/loginStyle.css"/>

<script type="text/javascript">
    $(document).ready(function(){
	document.getElementById("brukernavn").focus();

	$("#nyBrukerKnapp").click(function(e) {
	    e.preventDefault();
	    window.location.href = "/nybruker/";
	});
	$("#loggInnKnapp").click(function(e) {
	    if ($("#brukernavn").val() != "" && $("#passord").val() != ""){    
		    $("#formen").submit();
	    }
	});
	document.addEventListener('keyup', function(event) {
	    if(event.keyCode == 13) {
		if ($("#brukernavn").val() != "" && $("#passord").val() != ""){    
		    $("#formen").submit();
		}
	    }
	});
    });
</script>

<div class="innholdboks">

    <h3>Logg inn til Asperøy.no</h3>

    <p class="feilmelding">
	<?php if ($_SESSION["feil"] == true): ?>
	    Feil brukernavn/passord
	<?php endif; ?>
    </p>

    <form method="post" id="formen">
	<table id="tabell" align="center">
	    <tr>
		<td>Brukernavn:</td>
		<td><input id="brukernavn" type="text" name="brukernavn" id="brukernavn"></td>
	    </tr>
	    <tr>
		<td>Passord:</td>
		<td><input type="password" name="passord" id="passord"></td>
	    </tr>
	    <tr>
		<td><input type="button" value="Logg inn" name="logginn" class="knapp" id="loggInnKnapp"></td>
		<td><input id="nyBrukerKnapp" type="button" value="Ny bruker" name="nybruker" class="knapp"></td>
	    </tr>
	</table>
    </form>
    
</div>

<?php renderFooter();?>