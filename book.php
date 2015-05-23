<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Book.php");

	require_once("classes/Profile.php");

	$profile = new Profile();
	$book = new Book();


	if ($book->isSearchBook() == true) {
	    include("views/search_book.php");
	} else if ($book->isAddBook() == true) {
		include("views/search_book.php");
	} else if ($book->isShowBook() == true) {
		include("views/show_book.php");
	} else {
		if ($profile->isProfileOwner() == true) {
	    	include("views/edit_book.php");
		} else {
	    	include("views/show_user_book.php");
	}
}

?>