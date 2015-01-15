<?php
session_start();
?>

<?php
    require_once("helpers.php");
    render("views/templates/simple_header", Array("title" => "ASPERØY - NY BRUKER"));
    
    $_SESSION["klarert"] = false;
    
    if (isset($_POST["oppgitt"])){ //bruker har sendt inn quiz
        
        if ($_POST["svar1"] == "enschien" &&
            $_POST["svar2"] == "35" &&
            $_POST["svar3"] == "Voss" &&
            $_POST["svar4"] == "Ingrid" &&
            $_POST["svar5"] == "Per") {
            $_SESSION["klarert"] = true;
        }
    }
?>

<script type="text/javascript">
    
    var riktig = [0, 0, 0, 0, 0]; //"global" variabel
    
    $(document).ready(function(){
        $(".firstFocus").focus(); //første inputfelt får fokus
        $(".tick img").css({"display": "none"});
        $(".tick").css({"width": "15px"});
        $("#ferdigknappen").attr("disabled", "disabled");
    });
    
    /*
     * check(i, element, blur)
     *
     * hver gang en tast løftes i et svarfelt sjekkes det om det oppgitte
     * svaret er riktig. Et ikon indikerer om svaret er riktig.
     * 'i' sier hvilket spørsmål det dreier seg om,
     * 'element' er en peker til input-elementet som trigget eventen og
     * 'blur' sier at feltet nettop har mistet fokus, i hvilket tilfelle
     * det er passelig med et rødt kryss.
     */
    function check(i, element, blur) {
        
        img_element = document.getElementById("tick" + i);
        var answers = ["enschien", "35", "Voss", "Ingrid", "Per"];
            
            if (element.value == answers[i-1]) {
                $(img_element).css("display", "block");
                img_element.src = "model/images/tick.png";
                riktig[i-1] = 1;
            }
            else{
                if (blur && (element.value != "")) {
                    $(img_element).css("display", "block");
                    img_element.src = "model/images/cross.png";
                    riktig[i-1] = 0;
                }
            }

        if (riktig[0] == 1 && riktig[1] == 1 && riktig[2] == 1 && riktig[3] == 1 && riktig[4] == 1) {
            $("#ferdigknappen").removeAttr("disabled");
        }
        else {
            $("#ferdigknappen").attr("disabled", "disabled");
        }
        
    }
</script>

<div class="innholdboks">
    
    <?php if ($_SESSION["klarert"]): ?>
        <h3>Du er klarert!</h3>
        <p>
            Velg et brukernavn og passord.
        </p>
        <form action="index.php" method="post">
            <table>
                
                <tr>
                    <td>E-post: </td> <td><input class="firstFocus" type="text" name="epost"></td>
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
        Hvis du får alle riktig i denne quiz'en kan du lage deg din egen bruker. Lykke til!
        </p>
        
        <form method="post">
            
            <table id="quiz">
                
                <tr>
                    <td>1. Han het Harald H...</td>
                    <td><input class="firstFocus" type="text" name="svar1" onkeyup="check(1, this, false);" onblur="check(1, this, true);"></td>
                    <td class="tick"><img src="model/images/tick.png" id="tick1"></td>
                </tr>
                <tr>
                    <td>2. Han kjøpte øya i 19..</td>
                    <td><input type="text" name="svar2" onkeyup="check(2, this, false);" onblur="check(2, this, true);"></td>
                    <td class="tick"><img src="model/images/tick.png" id="tick2"></td>
                </tr>
                <tr>
                    <td>3. Hun ble født Synnøve ...</td>
                    <td><input type="text" name="svar3" onkeyup="check(3, this, false);" onblur="check(3, this, true);"></td>
                    <td class="tick"><img src="model/images/tick.png" id="tick3"></td>
                </tr>
                <tr>
                    <td>4. Vår nyeste er lille ...</td>
                    <td><input type="text" name="svar4" onkeyup="check(4, this, false);" onblur="check(4, this, true);"></td>
                    <td class="tick"><img src="model/images/tick.png" id="tick4"></td>
                </tr>
                <tr>
                    <td>5. Og murer'n er han ...</td>
                    <td><input type="text" name="svar5" onkeyup="check(5, this, false);" onblur="check(5, this, true);""></td>
                    <td class="tick"><img src="model/images/tick.png" id="tick5"></td>
                </tr>            
            </table>
            <br>
            <input id="ferdigknappen" type="submit" value="Oppgi svar" name="oppgitt">
        </form>
    <?php endif ?>
</div>

<? render("views/templates/footer"); ?>