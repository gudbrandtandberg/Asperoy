<?php

	session_start();
	require_once("../helpers.php");
	
	if (isset($_SESSION["loggedIn"])){ //redirect to homepage
	
		if (isset($_GET["page"])){
			$page = $_GET["page"];
		}
		else{
			$page = "hjem";
		}
	
		switch ($page){
			case "hjem":
				
				render("../views/templates/header", Array("title"=>"ASPERØY"));
				render("../views/hjem");
				render("../views/templates/footer");
				break;
			
			case "bilder":
				
				render("../views/templates/header", Array("title" => "ASPERØY - BILDER"));
				render("../views/bilder");
				render("../views/templates/footer");
				break;
			
			case "kalender":
				
				render("../views/templates/header", Array("title" => "ASPERØY - KALENDER"));
				render("../views/kalender");
				render("../views/templates/footer");
				break;
			
			case "prosjekter":
				
				render("../views/templates/header", Array("title" => "ASPERØY - PROSJEKTER"));
				render("../views/prosjekter");
				render("../views/templates/footer");
				break;
			
			case "ressurser":
				
				render("../views/templates/header", Array("title" => "ASPERØY - RESSURSER"));
				render("../views/ressurser");
				render("../views/templates/footer");
				break;
		}
	}
	else{
		render("../views/templates/header");
		render("../views/login");
		render("../views/templates/footer");
	}
?>