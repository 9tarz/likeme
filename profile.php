<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Profile.php");

	$profile = new Profile();
	//$user_book = new Book();
	
	if ($profile->isProfileOwner() == true) {
	    include("views/edit_profile.php");
	} else {
	    include("views/profile.php");
	}

?>