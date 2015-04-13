<?php
include("../renderHelpers.php");
renderHeaderWithTitle("ASPERØY - RESSURSER");
?>

<style>
    ul > li > a, ul > li > a:hover {
        color: inherit;
    }
    
    .side h2, .side h3 { /*dette er duplikat, men tydeligvis nødvendig..*/
	margin-top: 5px;
    }
</style>


<div class="col-sm-12 col-md-6 side">
    
    <h2>Ressurser</h2>
    <p>
        Her finner du mange nyttige Asperøy-relaterte ressurser. Om du har noen dokumenter du ønsker å ha på denne
        siden så er det bare å sende det inn til oss så skal det lastes opp.
    </p>
    
    <h3>Morgenbadet</h3>
    <ul>
        <li><a href="/resources/images/morgenH12.pdf">Morgenbadet V12</a></li>
        <li><a href="/resources/images/morgenH12.pdf">Morgenbadet H12</a></li>
        <li><a href="/resources/images/morgenH12.pdf">Morgenbadet V13</a></li>
        <li><a href="/resources/images/morgenH12.pdf">Morgenbadet H13</a></li>
    </ul>
    
    <h3>GF-referater</h3>
    
</div>

<div class="col-sm-12 col-md-6 side">
    <h3>Bruksannvisninger</h3>
        <ul>
            <li><a href="/resources/images/telt.pdf">Partytelt bruksanvisning</a></li>
        </ul>
    <h3>Diverse</h3>
</div>


<?php
renderFooter();
?>