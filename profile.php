<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Profile.php");
	require_once("classes/Book.php");

	$profile = new Profile();
	$book = new Book();
	
	if ($profile->isProfileOwner() == true AND $profile->isEditProfile()) {
	    include("views/edit_profile.php");
	    include("views/edit_user_book.php");
	} else {
	    include("views/profile.php");
	    include("views/show_user_book.php");
	}

?>