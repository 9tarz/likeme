<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Book.php");

	require_once("classes/Profile.php");

	require_once("classes/Tag.php");

	$profile = new Profile();
	$book = new Book();
	$tag = new Tag();


	$users_id = $book->getUsersID(); 

	for ($i = 0; $i < count($users_id) ; $i++) {
		$book->updatedUserTag($users_id[$i]["uid"]); // updateUserTagTable
	}

	$arr_tag_id = $book->getUserStatus($_GET["uid"],1);
	$arr_tag_name = $book->getUserStatus($_GET["uid"],3);
	for ($i = 0; $i < count($arr_tag_id) ;$i++ ) {
		
		$users_use_same_tag = $book->searchByTag($arr_tag_id[$i], $_GET["uid"]);

		$count_sum = $users_use_same_tag["count_sum"];

		if ($count_sum != NULL) {
			echo "<p>" . $arr_tag_name[$i] . "</p>";
		}

		for ($j = 0; $j < count($users_use_same_tag) - 1 ; $j++) {
			echo "<li>" . $users_use_same_tag[$j]["username"] . " | freq : " . ($users_use_same_tag[$j]["tag_count"]/$count_sum)*100 . "%</li>";

		}
	}
?>