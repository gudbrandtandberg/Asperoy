<?php
    if (!isset($_SESSION)){session_start();}
?>

<?php
    require_once("../renderHelpers.php");
    render("views/templates/simple_header");
    
    $_SESSION["klarert"] = false;
    
    //oppgitt burde hete quizoppgitt..
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
<script src="/js/canvasImageEdit.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/nybruker.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="/js/JIC.js"></script>

    <?php if ($_SESSION["klarert"] == true): ?>
    <div style="position: absolute; left: 50%;">
    <div class="innholdboks innholdboks-stor" id="termspopup" style="display: none";>
        <h2>Brukervilkår</h2>

        <p style="font-size: 12px;">
            Disse vilkår regulerer all bruk av asperøy.no (herretter "Nettstedet" eller "Vi") og dets tjenester og innhold som vi gjør tilgjengelig for brukeren via tjenesten vår (heretter "Du", eller "Brukeren"). Nettstedet forbeholder seg retten til å endre vilkårene uten varsel.

Alle immaterielle rettigheter (inklusive opphavsrettigheter, varemerker og patenter) til Nettstedet og dets innhold, herunder tekst, tallmateriale, bilder, hendelser og kommentarer (heretter "Innholdet") tilhører nettstedet. Det er tillatt å laste ned og skrive ut kopier av skjermbilder til eget bruk. Med mindre Nettstedet gir uttrykkelig tillatelse, er det ikke tillatt å bruke Nettstedet og Innholdet til kommersielle formål, for eksempel videresalg eller publisering. 

Vi kan nå eller i fremtiden tillate brukere å poste, laste opp, eller på annen måte gjøre tilgjengelig gjennom Våre Tjenester meldinger, tekst, illustrasjoner, filer, bilder, kommentarer, informasjon, og/eller annet materiale (herretter "Brukerinnhold"). Det er utelukkende ditt ansvar å overvåke og beskytte immaterielle rettigheter som Du kan ha i ditt brukerinnhold, og Vi aksepterer ikke noe ansvar for dette overhodet.

Du ikke skal kaste et negativt lys over oss, våre partnere eller vår virksomhet, aktiviteter eller merkevarer.

Det er brukerens ansvar å holde alle passord, brukeridentifikasjoner og andre koder hemmelige, og å oppbevare dem slik at uvedkommende ikke får tilgang til dem. For sikkerhets skyld bør Du bruke et passord som ikke blir brukt til noe annet enn Nettstedet.

Nettstedet påtar seg ikke ansvar for innhold, funksjonalitet, materiale osv. på andre nettsteder som er lenket til på Nettstedet.

Ved tvist som gjelder bruk av nettstedet eller Innholdet skal norsk lov anvendes uten hensyn til lovvalgsregler. 

Hvis det under surfingen skulle oppstå feil eller mangler som kan gi anledning til misnøye skal support-teamet informeres om dette umiddelbart med hensyn til utbedring av mangler. Dette skal skje innen rimelig tid etter at feilen er oppdaget slik at leverandøren får mulighet til å rette opp den eventuelle feil/mangel.

Brukeren plikter å være med på å spleise på Nettstedets årsavgift på 200 kr. Summen vil deles på Nettstedets ca. 20 brukere. 
        </p>
    
        <button id="okjegharlest" class="btn btn-default">OK</button>
    </div>
    </div>

    <div class="innholdboks innholdboks-stor">
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
                    <td class="firstcol"><span style="cursor: help" title="Velg et profilbilde. Hvis du ikke vil velge et bilde akkkurat nå, vil du få annledning til å gjøre senere">Velg bilde: </span></td>
                    <td><input type="file" id="bildeinput" name="profilbilde" value="Velg fil" accept="image/*" onchange="openFile(event);"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <canvas id="redigeringscanvas" width="335" height="200">
                            <img id="profilbildeimg" src=""/>
                        </canvas>
			<canvas id="compressioncanvas" width="335" height="200" style="display: none;"></canvas>
                        <canvas id="uploadcanvas" width="150" height="150" style="display: none;"></canvas>
                        <input id="profilbildestreng" type="text" name="profilbilde" style="display: none;"/>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true" onclick="manualZoom(-0.1);" style="cursor: pointer;"></span>
                    </td>
                    <td style="text-align: right;">
                         <span class="glyphicon glyphicon-plus" aria-hidden="true" onclick="manualZoom(0.1);" style="cursor: pointer"></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="slider"></div>
                    </td>
                </tr>
                <tr>
                    <td><span style="cursor:help;" title="Forvavnet ditt er det samme som brukernavnet ditt. Hvis du heter Harald vil ditt fornavn automatisk byttes ut med Harald T./L.">Fornavn:</span></td>
                    <td><input id="fornavn" type="text" name="fornavn" class="firstFocus"></td>
                </tr>
                <tr>
                    <td><span style="cursor:help;" title="Etternavnet ditt">Etternavn:</span></td>
                    <td><input id="etternavn" type="text" name="etternavn"></td>
                </tr>
                <tr>
                    <td><span style="cursor:help;" title="Eposten du kan nås på">E-post: </span></td> <td><input id="epost" type="text" name="epost"></td>
                </tr>
                <tr>
                    <td><span style="cursor:help;" title="Velg et trygt passord som du ikke bruker noen andre steder">Passord:</span> </td> <td><input id="passord" type="password" name="passord"></td>
                </tr>
                <tr>
                   <td><span style="cursor:help;" title="Fargen du velger brukes til diverse formål inne på siden. Du kan bytte farge når som helst">Velg farge:</span></td>
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
            
            <div style="margin-top: 10px;">
                <small>Jeg har lest og godtatt <a id="termscond" href="#">brukervilkårene</a></small>
                <input id="godtatt" style="display: inline-block;" type="checkbox" name="godtatt">
            </div>
            
            <div class="knapper">
                <button type="button" id="avbryt" class="btn btn-default">Avbryt</button>
                <button type="button" id="lagnybrukerknapp" class="btn btn-default">Lag bruker</button>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="innholdboks innholdboks-medium">
        <h3>Velkommen til Asperøy.no </h3>
        <p>
        Før du får lov til å lage bruker må vi sikkerhetsklarere deg.
        Hvis du får alle riktig i denne quiz'en kan du lage deg din egen bruker. Lykke til!
        </p>
        
        <form method="post" id="quizform">
            <table id="quiz">
                <tr>
                    <td>1. Han het Harald H...</td>
                    <td><input class="firstFocus" type="text" name="svar1" onkeyup="check(1, this, false);" onblur="check(1, this, true);"></td>
                    <td class="tick"><img src="/resources/images/tick1.png" id="tick1"></td>
                </tr>
                <tr>
                    <td>2. Han kjøpte øya i 19..</td>
                    <td><input type="text" name="svar2" onkeyup="check(2, this, false);" onblur="check(2, this, true);"></td>
                    <td class="tick"><img src="/resources/images/tick1.png" id="tick2"></td>
                </tr>
                <tr>
                    <td>3. Hun ble født Synnøve ...</td>
                    <td><input type="text" name="svar3" onkeyup="check(3, this, false);" onblur="check(3, this, true);"></td>
                    <td class="tick"><img src="/resources/images/tick1.png" id="tick3"></td>
                </tr>
                <tr>
                    <td>4. Vår nyeste er lille ...</td>
                    <td><input type="text" name="svar4" onkeyup="check(4, this, false);" onblur="check(4, this, true);"></td>
                    <td class="tick"><img src="/resources/images/tick1.png" id="tick4"></td>
                </tr>
                <tr>
                    <td>5. Og murer'n er han ...</td>
                    <td><input type="text" name="svar5" onkeyup="check(5, this, false);" onblur="check(5, this, true);""></td>
                    <td class="tick"><img src="/resources/images/tick1.png" id="tick5"></td>
                </tr>            
            </table>
            <br>
            <button id="ferdigknappen" class="btn btn-default">Oppgi svar</button>
            <input type="hidden" name="oppgitt">
        </form>
    </div>
    <?php endif ?>

<?php renderFooter();?>
