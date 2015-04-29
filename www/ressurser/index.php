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
        Her finner du mange nyttige Asperøy-relaterte ressurser. For å laste opp egne dokumenter
        sender du det til <a href="mailto:gudbrandduff@gmail.com">oss</a> med e-post så laster vi det opp.
    </p>
    
    <h3>Morgenbadet</h3>
    <ul>
        <li><a href="/resources/images/morgenH12.pdf" target="_blank">Morgenbadet V12</a></li>
        <li><a href="/resources/images/morgenH12.pdf" target="_blank">Morgenbadet H12</a></li>
        <li><a href="/resources/images/morgenH12.pdf" target="_blank">Morgenbadet V13</a></li>
        <li><a href="/resources/images/morgenH12.pdf" target="_blank">Morgenbadet H13</a></li>
    </ul>
    
    <h3>GF-referater</h3>
    
</div>

<div class="col-sm-12 col-md-6 side">
    <h3>Bruksanvisninger</h3>
        <ul>
            <li><a href="/resources/images/telt.pdf" target="_blank">Partytelt bruksanvisning</a></li>
        </ul>
        
    <h3>Nyttige lenker</h3>
        <ul>
            <li><a href="http://www.lillesand.kommune.no/" target="_blank">Lillesand kommune</a></li>
            <li><a href="http://www.yr.no/sted/Norge/Aust-Agder/Lillesand/Lillesand/" target="_blank">Været i Lillesand</a></li>
            <li><a href="http://www.lp.no/" target="_blank">Lillesandsposten</a></li>
            <li><a href="http://www.ute-service.info/" target="_blank">Ute Service v/ Christopher Johansen</a></li>
        </ul>
        
    <h3>Diverse</h3>
</div>


<?php
renderFooter();
?>