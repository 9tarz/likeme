<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Profile.php");
	require_once("classes/Book.php");

	$profile = new Profile();
	$book = new Book();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A layout example that shows off a responsive product landing page.">
        <title>Profile</title>
        
        <link rel="stylesheet" href="libraries/pure-release-0.6.0/pure-min.css">
        <link rel="stylesheet" href="libraries/pure-release-0.6.0/grids-responsive-min.css">
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link rel="stylesheet" href="views/css/marketing.css">    
    </head>

    <body>
        <div class="header">
            <div class="home-menu pure-menu pure-menu-horizontal pure-menu-fixed">
                <a class="pure-menu-heading" href="">Like Me</a>
                <ul class="pure-menu-list">
                	<a href="index.php?signout">
                        <button class="button-success pure-button"
                        style="color: white;
                            border-radius: 4px;
                            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
                            background: rgb(223, 117, 20);
                            margin-top:5px">Log out</button>
                    </a>
                </ul>
            </div>
        </div>

        <div class="splash-container">
            <div class="splash">
                <h1 class="splash-head">Insert profile img here</h1>
                <p>
                	<?php 
                	if($profile->isProfileOwner() == true AND $profile->isEditProfile() == false)
                    	echo "<a href=\"profile.php?uid=" .$_GET["uid"] . "&editProfile\" class=\"pure-button pure-button-primary\">Edit profile</a>";
                	?>
                </p>
            </div>
        </div>

        <div class="content-wrapper">
        	<!-- profile -->
            <div class="content">
          
            	<?php
					if ($profile->isProfileOwner() == true AND $profile->isEditProfile()) {
					    include("views/edit_profile.php");
					} else {
					    include("views/profile.php");
					}
				?>
                
            </div>

            <!-- book -->
            <div class="ribbon l-box-lrg pure-g">
            	<?php
					if ($profile->isProfileOwner() == true AND $profile->isEditProfile()) {
					    include("views/edit_user_book.php");
					} else {
					    include("views/show_user_book.php");
					}

				?>

            </div>


        </div>
    </body>
</html>



