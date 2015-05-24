<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Book.php");

	require_once("classes/Profile.php");

	require_once("classes/Tag.php");

	$profile = new Profile();
	//$book = new Book();
	$tag = new Tag();

	if (isset($tag)) {
	    if ($tag->errors) {
	        foreach ($tag->errors as $error) {
	            echo $error;
	        }
	    }
	    if ($tag->messages) {
	        foreach ($tag->messages as $message) {
	            echo $message;
	        }
    	}

	}
	if ($tag->isSearchTag() == true) {
	    include("views/search_tag.php");
	} else if ($tag->isShowBookTag() == true) {
		include("views/show_book_tag.php");
	}
?>