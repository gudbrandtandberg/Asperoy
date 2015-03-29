<?php
    if (!isset($_SESSION))
    {
        session_start();
    }
?>

<?php
    require_once("../renderHelpers.php");

    render("views/templates/simple_header"); //hvis ikke så blir man login-blokkert av vanlig header!

    $_SESSION["klarert"] = true; //bare for å kunne teste nybruker-siden
    
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

<link href="/styles/customColorPicker.css" rel="stylesheet" type="text/css" />
<link href="/styles/loginStyle.css" rel="stylesheet" type="text/css"/>
<script src="/js/customColorPicker.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/nybruker.js"></script>

<div class="innholdboks">
    <?php if ($_SESSION["klarert"]): ?>
        <h3>Du er klarert!</h3>
        <p class="feilmelding">
            <?php if ($_SESSION["feil"] == true): ?>
                Det finnes en bruker med det navnet. Ta et annet!
            <?php endif; ?>
        </p>
        <p>
            Fyll ut skjema for å lage en ny bruker:
        </p>
        <form action="/api/nyBruker.php" method="post" id="lagnybrukerform">
            <table>
                <tr>
                    <td>Velg profilbilde: </td>
                    <td><input type="file" id="bildeinput" name="profilbilde" value="Velg fil" onchange="openFile(event);"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <canvas id="redigeringscanvas">
                            <img id="profilbildeimg" src=""/>
                        </canvas>
                    </td>
                </tr>
                <tr>
                    <td>Fornavn:</td>
                    <td><input type="text" name="fornavn" class="firstFocus"></td>
                </tr>
                <tr>
                    <td>Etternavn:</td>
                    <td><input type="text" name="etternavn"></td>
                </tr>
                <tr>
                    <td>E-post: </td> <td><input type="text" name="epost"></td>
                </tr>
                <tr>
                    <td>Passord: </td> <td><input type="password" name="passord"></td>
                </tr>
                <tr>
                   <td>Velg din farge:</td>
                   <td>
                        <span class="colorpicker">
                            <span class="bgbox"></span>
                            <span class="hexbox"></span>
                            <span class="clear"></span>
                            <span class="colorbox">
                                <b class="selected" style="background:#A9BAD4" title="Lyseblå"></b>
                                <b style="background:#A1A4B3" title="Blå"></b>
                                <b style="background:#A49381" title="Fuchsia"></b>
                                <b style="background:#626878" title="Gul"></b>
                                <b style="background:#ff0000" title="Rød"></b>
                                <b style="background:#0000ff" title="Blå"></b>
                                <b style="background:#A49381" title="Rosa"></b>
                                <b style="background:#ff0033" title="Orange"></b>
                            </span>    
                        </span>
                   </td>
                </tr>
                <tr>
                    <td><button type="button" id="avbryt" class="btn btn-default">Avbryt</button></td>
                    <td><button type="button" id="lagnybrukerknapp" class="btn btn-default">Lag bruker</button></td>
                </tr>
            </table>
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
                    <td class="tick"><img src="/resources/images/tick.png" id="tick1"></td>
                </tr>
                <tr>
                    <td>2. Han kjøpte øya i 19..</td>
                    <td><input type="text" name="svar2" onkeyup="check(2, this, false);" onblur="check(2, this, true);"></td>
                    <td class="tick"><img src="/resources/images/tick.png" id="tick2"></td>
                </tr>
                <tr>
                    <td>3. Hun ble født Synnøve ...</td>
                    <td><input type="text" name="svar3" onkeyup="check(3, this, false);" onblur="check(3, this, true);"></td>
                    <td class="tick"><img src="/resources/images/tick.png" id="tick3"></td>
                </tr>
                <tr>
                    <td>4. Vår nyeste er lille ...</td>
                    <td><input type="text" name="svar4" onkeyup="check(4, this, false);" onblur="check(4, this, true);"></td>
                    <td class="tick"><img src="/resources/images/tick.png" id="tick4"></td>
                </tr>
                <tr>
                    <td>5. Og murer'n er han ...</td>
                    <td><input type="text" name="svar5" onkeyup="check(5, this, false);" onblur="check(5, this, true);""></td>
                    <td class="tick"><img src="/resources/images/tick.png" id="tick5"></td>
                </tr>            
            </table>
            <br>
            <input id="ferdigknappen" type="submit" value="Oppgi svar" name="oppgitt">
        </form>
    <?php endif ?>
</div>

<? render("views/templates/footer"); ?>