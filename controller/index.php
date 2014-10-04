<?php
	// avgjører om brukeren er logget inn eller ikke.
	// logikken er ikke helt god, men en grei start..
	
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
				
				render("../views/templates/header");
				render("../views/hjem");
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