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
                	<a href="index.php?signout">Signout</a>
                </ul>
            </div>
        </div>

        <div class="splash-container">
            <div class="splash">
                <h1 class="splash-head">Insert profile img here</h1>
                <p>
                	<?php 
                	if($profile->isEditProfile() == false)
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

                <h2 class="content-head is-center">Excepteur sint occaecat cupidatat.</h2>
                <div class="pure-g">

                    <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">

                        <h3 class="content-subhead">
                            <i class="fa fa-rocket"></i>
                            Get Started Quickly
                        </h3>
                        <p>
                            Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                        </p>
                    </div>

                    <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                        <h3 class="content-subhead">
                            <i class="fa fa-mobile"></i>
                            Responsive Layouts
                        </h3>
                        <p>
                            Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                        </p>
                    </div>

                    <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                        <h3 class="content-subhead">
                            <i class="fa fa-th-large"></i>
                            Modular
                        </h3>
                        <p>
                            Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                        </p>
                    </div>

                    <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                        <h3 class="content-subhead">
                            <i class="fa fa-check-square-o"></i>
                            Plays Nice
                        </h3>
                        <p>
                            Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.
                        </p>
                    </div>
                </div>
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
                <div class="l-box-lrg is-center pure-u-1 pure-u-md-1-2 pure-u-lg-2-5">
                    <img class="pure-img-responsive" alt="File Icons" width="300" src="img/common/file-icons.png">
                </div>
                <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-3-5">
                    <h2 class="content-head content-head-ribbon">Laboris nisi ut aliquip.</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor.
                    </p>
                </div>
            </div>


        </div>
    </body>
</html>



