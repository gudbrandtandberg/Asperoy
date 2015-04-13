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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="/js/customColorPicker.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/nybruker.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="/js/JIC.js"></script>

<div class="innholdboks innholdboks-stor">
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
            <table class="nybrukertabell">
                <tr>
                    <td class="firstcol">Velg bilde: </td>
                    <td><input type="file" id="bildeinput" name="profilbilde" value="Velg fil" accept="image/*" onchange="openFile(event);"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <canvas id="redigeringscanvas" width="335" height="200">
                            <img id="profilbildeimg" src=""/>
                        </canvas>
                        <canvas id="uploadcanvas" width="150" height="150" style="display: none;"></canvas>
                        <input id="profilebildestreng" type="text" name="profilbilde" style="display: none;"/>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </td>
                    <td style="text-align: right;">
                         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="slider"></div>
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
                   <td>Velg farge:</td>
                   <td>
                        <span class="colorpicker">
                            <span class="bgbox"></span>
                            <span class="hexbox"></span>
                            <span class="clear"></span>
                            <span class="colorbox">
                                <b class="selected" style="background:#A9BAD4"></b>
                                <b style="background:#FF0000"></b>
                                <b style="background:#FF7519"></b>
                                <b style="background:#FFCC00"></b>
                                <b style="background:#FF3399"></b>
                                <b style="background:#930093"></b>
                                <b style="background:#66CCFF"></b>
                                <b style="background:#009933"></b>
                                <br>
                                <b style="background:#996633"></b>
                                <b style="background:#989898"></b>
                                <b style="background:#009999"></b>
                                <b style="background:#CCFF99"></b>
                                <b style="background:#7070E2"></b>
                                <b style="background:#FF99CC"></b>
                                <b style="background:#FFCC99"></b>
                                <b style="background:#00FF00"></b>
                            </span>    
                        </span>
                       <input id="farge" type="text" name="farge" style="display: none;"/>
                   </td>
                </tr>
            </table>
            <div class="knapper">
                <button type="button" id="avbryt" class="btn btn-default">Avbryt</button>
                <button type="button" id="lagnybrukerknapp" class="btn btn-default">Lag bruker</button>
            </div>
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

<?php renderFooter();?>