#Dokumentasjon Asperøy.no
===========================

##Overview
Vi skal lage en helt fantastisk Asperøy-hjemmeside. Vårt hovedmål er at siden skal være nyttig, og at folk faktisk bruker den. Disse kravene burde vi alltid ha i bakhodet når vi vurderer om en funksjonalitet skal være med eller ikke. Foreløpig ser set ut til at siden kommer til å inneholde minst disse funksjonene:

- LOGIN
Brukeren må logge inn/lage en konto for å få lov til å se innholdet.
Kanskje brukeren må bestå en liten Asperøyquiz for å få lov til å lage bruker? 

- HJEM
Brukeren blir velkommet og får se en bildekarusell

- BILDER 
Masse bilder delt inn i album. Det skal være mulig å kommentere bildene nedover siden slik som i Facebook. Brukere skal også kunne laste opp sine egne bilder. 

- KALENDER
Nyttig interaktivt kallenderverktøy. Skal være fullt redigerbart. Alle hendelser lagres i json format

- PROSJEKTER
En slags nyhetsside hvor pågående prosjekter informeres om. Dette kan jo utikles en del, hva med mulighet for å legge til prosjekter/utlyse arbeid osv. Kanskje det ikke blir brukt.. Kanskje heller ha en slags newsfeed? SPM: PROSJEKTER -> NYHETER (kanskje morgenbadet digitaliseres..)

- RESSURSER
Enkel side med masse nyttige ressurser. Telefonnummere, bruksanvisninger, morgenbadeter, osv. 

##Oppsett

Websiden følger et slags MVC-oppsett hvor vi skiller de forskjellige delene i programmet fra hverandre så mye som mulig.  

###Filstruktur

- controllers   (rootdirectory for klientene)
  - index.php
  - hjem.php
  - bilder.php
  - ressurser.php
  -prosjekter.php

- model (alle ressursene skal ligge her, bilder, database, hendelser, osv)
	   (denne idéen speiler ikke den virkelige filstrukturen ennå, model/db trenger å tas tak i)
  - json
   -kalender_hendelser.json    
  - bilder
    karusellbilder
      - et utvalg av landskap format bilder som vises på forsiden

- style.css (hoved-stylesheeten som brukes for de fleste elementer)

- slick
- fullcalendar-2.1.1

###Implementasjon

Websiden tar i bruk masse forskjellige verktøy; html, css, javascript/jquery, php, db++…
Vi bruker noen tilleggsmoduler (slick, fullcalendar, node, ++), men la oss prøve å gjøre så mye som mulig selv. For eksempel kan vi nok greit lage en god innloggingsautentifisering uten passport?!

NÅ: bruker kommer til index.php og innhold lastes dynamisk ned med jQuery sin load() funksjon inn i “innhold” div’en i index siden. Jeg ser flere ulemper ved dette. 

SNART (hvis all denne php’en er greit for Eivind): Hver side har sin egen .php fil, og innholdet lastes dynamisk inn. Da vil foreksempel hjem, ressurser, osv inneholde kun sitt eget innhold OG ha en enkel include(header, vars) og include(footer, vars), hvor header og footer er egne statiske html templates med placeholder innhold. Flere fluer tas i et smekk med en slik løsning. 
