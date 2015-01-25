<?php
    if (!isset($_SESSION))
    {
	session_start();
    }

    ob_start();  //output buffering

// dette skriptet skal enten: ta brukeren til hjem
// eller: be brukeren rette opp sine feil
// eller: ta brukeren til 'ny bruker' området

require_once("helpers.php");

if (isset($_POST["logginn"])){  //bruker trykket på 'Logg inn'
    if (($_POST["brukernavn"] != "") && ($_POST["passord"] != "")){
        $brukernavn = $_POST["brukernavn"];
        $passord = $_POST["passord"];

        $users_XML = simplexml_load_file("model/users.xml");
	// her sier php 'notice: undefined offset: 0' fordi $users_node potensielt er tom
        $users_node = $users_XML->xpath("//USER[@NAVN='{$brukernavn}']")[0];
        $users_name = $users_node["NAVN"];
        $users_password = $users_node["PASSORD"];

        if (!$users_name) {
            echo "Finner ikke en bruker med det navnet";
            $authenticated = false;
        } else if (!password_verify($passord, $users_password)) {
            echo "Galt passord";
            $authenticated = false;
        } else {
            $authenticated = true;
        }


        if ($authenticated){  //infoen oppgitt var riktig

            $_SESSION["feil"] = false;
            $_SESSION["loggedIn"] = true;
            $_SESSION["brukernavn"] = $_POST["brukernavn"];

            header("Location: index.php");
        } else {
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
                    <td><input type="submit" value="Ny bruker" name="nybruker"></td>
                </tr>
            </table>
        </form>
    </div>

<?php render("views/templates/footer");?>