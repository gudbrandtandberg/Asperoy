<?php
    if (!isset($_SESSION))
    {
	session_start();
    }
    require_once("../renderHelpers.php");
    renderHeaderWithTitle("ASPERØY - PROFIL");
?>

<link href="/styles/customColorPicker.css" rel="stylesheet" type="text/css" />
<link href="/styles/profilStyle.css" rel="stylesheet" type="text/css"/> <!-- heller egen css? -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
<script src="/js/customColorPicker.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="/js/JIC.js"></script>
<script src="/js/profil.js"></script>

<div class="col-xs-12" style="text-align: center;">
    <h2>Profil</h2>
    <p>Her kan du gjøre endringer på profilen din</p>
    
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
                   </td>
                </tr>
            </table>
            <div class="knapper">
                <button type="button" id="lagreendringerknapp" class="btn btn-default">Lagre endringer</button>
            </div>
        </form>
</div>

<?php
    renderFooter();
?>