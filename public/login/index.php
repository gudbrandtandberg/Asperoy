<?php
    if (!isset($_SESSION))
    {
	session_start();
    }

    ob_start();  //output buffering

// dette skriptet skal enten: ta brukeren til hjem
// eller: be brukeren rette opp sine feil
// eller: ta brukeren til 'ny bruker' området


$fullphpdir = getcwd();
$fulldir = dirname($_SERVER["PHP_SELF"]);

require_once("../renderHelpers.php");
include_once("../../UserController.php");

$userController = UserController::getInstance();

if (isset($_POST["logginn"])){  //bruker trykket på 'Logg inn'
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
            echo "Du ga feilinnformasjon";
        }
    }
    else { //formen ble ikke utfyllt
        $_SESSION["feil"] = true;
    }
}
elseif (isset($_POST["nybruker"])){
    header("Location: /");
}
?>

<?php render("views/templates/simple_header");?>

    <script type="text/javascript">
        $(document).ready(function(){
            document.getElementById("brukernavn").focus();

            $("#nyBrukerKnapp").click(function(e) {
                e.preventDefault();
                window.location.href = "/nybruker/";
            })
        });
    </script>

    <div class="innholdboks">

        <h3>Logg inn til Asperøy.no</h3>

        <p class="feilmelding">
            <?php if ($_SESSION["feil"] == true): ?>
                Feil brukernavn/passord
            <?php endif; ?>
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
                    <td><input id="nyBrukerKnapp" type="submit" value="Ny bruker" name="nybruker"></td>
                </tr>
            </table>
        </form>
    </div>

<?php renderFooter();?>