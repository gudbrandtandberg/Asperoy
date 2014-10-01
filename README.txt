Elementer: 
 - bilder (delt inn i kategorier?)
 - kalender (interaktiv, fullcalendar med php og json funker knall her)
 - nyheter (newsfeed stil)
 - chat
 - jobber/utlyse oppdrag/prosjekter
 - ressurser (bruksanvisninger, teltoppskrift, morgenbadet i pdf..) 
 - innlogging? alle må få bruker og all data er privat

Layout: 
 - Vil tenke nytt. Vil ha fancy enkel klassisk i "vår tid" type design. 


Konseptuelt oppsett:

			Node.js server på RaspberryPi (håndterer requests mm.)
						|
						|
					    innlogging (med passport.js)
						|
						|
					    index.html
						|
						|
			    innhold (html filer, json, noe i database (sql?))


noen ressurser: 
http://passportjs.org/
http://expressjs.com/
http://www.nodebeginner.org/
http://nodejs.org/
