<?php
    if (!isset($_SESSION))
    {
	session_start();
    }

    require_once("../renderHelpers.php");
    renderHeaderWithTitle("ASPERØY - PROFIL");

?>

<div class="col-xs-12 col-md-6">
    <h2>Profil</h2>
    <p>Her kan du gjøre endringer på profilen din!</p>


</div>



<?php
    renderFooter();
?>