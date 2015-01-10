<?php
session_start();
?>

<script type="text/javascript">
    
    $(document).ready(function(){
       $(".innholdboks").hide();
       $(".innholdboks").fadeIn(1000);
        
    });
    
</script>

<?php
    require_once("../helpers.php");
    render("../views/templates/simple_header", Array("title" => "ASPERØY - NY BRUKER"));
 
    
    $_SESSION["klarert"] = false;
    
    if ($_POST["oppgitt"] == "Oppgi svar"){
    //sjekk svarene i $_POST
    //lagrer om svarene ble klarert eller ikke i variablen klarert=true/false,
    //dette påvirker om quizen vises med feilmelding
    //eller en side for å legge inn persondata vises
        
        if ($_POST["svar1"] == "enschien" &&
            $_POST["svar2"] == "35" &&
            $_POST["svar3"] == "Voss" &&
            $_POST["svar4"] == "Ingrid" &&
            $_POST["svar5"] == "Per"){
        
            $_SESSION["klarert"] = true;
        }
        else {
            $_SESSION["klarert"] = false;
            $_SESSION["quizfeil"] = true;
        }
    }
?>

<div class="innholdboks">
    
    <?php if ($_SESSION["klarert"] == true): ?>
        <h3>Du er klarert!</h3>
        <p>
            Velg et brukernavn og passord.
        </p>
        <form action="login.php" method="post">
            <table>
                
                <tr>
                    <td>E-post: </td> <td><input type="text" name="epost"></td>
                </tr>
                <tr>
                    <td>Brukernavn: </td> <td><input type="text" name="brukernavn"></td>
                </tr>
                <tr>
                    <td>Passord: </td> <td><input type="password" name="epost"></td>
                </tr>
            
            </table>
            <br>
            <input type="submit" value="Lag bruker" name="lagnybruker">
            
        </form>
       
    <?php else: ?>
        <h3>Velkommen til Asperøy.no </h3>
        <p>
        Før du får lov til å lage bruker må vi sikkerhetsklarere deg.
        Hvis du får én eller færre feil i denne quiz'en kan du lage deg din egen bruker. Lykke til!
        </p>
        
        <? if ($_SESSION["quizfeil"] == true): ?>
        <p class="feilmelding">
            Oops! Du kjenner vist ikke øya godt nok til å få lov til å lage bruker. Men du kan få prøve igjen!
        </p>
        <? endif ?>
        
        <form action="../views/nybruker.php" method="post">
            
            <table id="quiz">
                
                <tr>
                    <td>1. Han het Harald H...</td>
                    <td><input type="text" name="svar1"></td>
                </tr>
                <tr>
                    <td>2. Han kjøpte øya i 19..</td>
                    <td><input type="text" name="svar2"></td>
                </tr>
                <tr>
                    <td>3. Hun ble født Synnøve ...</td>
                    <td><input type="text" name="svar3"></td>
                </tr>
                <tr>
                    <td>4. Vår nyeste er lille ...</td>
                    <td><input type="text" name="svar4"></td>
                </tr>
                <tr>
                    <td>5. Og murer'n er han ...</td>
                    <td><input type="text" name="svar5"></td>
                </tr>            
            </table>
            <br>
            <input type="submit" value="Oppgi svar" name="oppgitt"></td>
        </form>
    <?php endif ?>
</div>

<? render("../views/templates/footer", Array("title" => "ASPERØY - NY BRUKER")); ?>