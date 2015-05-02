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

        if ($authenticated) {  //infoen oppgitt var riktig
            $_SESSION["feil"] = false;
            $_SESSION["loggedIn"] = true;
            $_SESSION["brukernavn"] = $brukernavn;
            $_SESSION["farge"] = (string)$userController->getUserColor($brukernavn);
            $_SESSION["bilde"] = (string)$userController->getUserImage($brukernavn);
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

<div class="innholdboks innholdboks-liten">

    <h3>Logg inn til Asperøy.no</h3>

    <p class="feilmelding">
	<?php if ($_SESSION["feil"] == true): ?>
	    Feil brukernavn/passord
	<?php endif; ?>
    </p>

    <form method="post" id="formen">
	<input id="brukernavn" type="text" name="brukernavn" placeholder="Brukernavn" class="langinput" ></td>
	<input id="passord" type="password" name="passord" placeholder="Passord" class="langinput">
	<button id="loggInnKnapp" class="btn btn-default btn1" type="button">Logg inn</button>
	<button id="nyBrukerKnapp" class="btn btn-default btn2" type="button">Ny bruker</button>
    </form>
    
</div>

<?php renderFooter();?>
