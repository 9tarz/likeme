<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Book.php");

	require_once("classes/Profilephp");

	$profile = new Profile();
	$book = new Book();
	
	if ($profile->isProfileOwner() == true) {
	    include("views/book.php");
	} else {
	    include("views/show_book.php");
	}

?>