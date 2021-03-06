<?php
    require_once("libraries/password_compatibility_library.php");
    require_once("config/db_config.php");
    require_once("classes/Auth.php");

    $auth = new Auth();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="A layout example that shows off a responsive pricing table.">

    <title>LikeMe</title>

<link rel="stylesheet" type="text/css" href="libraries/pure-release-0.6.0/pure-min.css">

  
<link rel="stylesheet" type="text/css" href="libraries/pure-release-0.6.0/grids-responsive-min.css">
  
<link rel="stylesheet" type="text/css" href="libraries/pure-layout-pricing/css/layouts/pricing.css">
  

</head>
<body>

<div class="banner">
    <h1 class="banner-head">
        Like Me
    </h1>
    <h3 class="sub-banner-head">
        Find people with similar interests
    </h3>
</div>

<div class="l-content">

    <?php 
        if ($auth->isUserSignin() == true) {
            header("Location: profile.php?uid=" . $_SESSION["uid"]."");
        } else {
            include("views/signin.php");
        }
    ?>

    <div class="information pure-g">
        <div class="pure-u-1 pure-u-md-1-1">
            <div class="l-box">
                <h3 class="information-head">How it works</h3>
                <p style="text-align: left;">
                    Have you ever wondered who would love to a horror series or read the whole spiderman comic like you? Well you will! By telling us what book you read and what tag or genre it is, we can collect data and compare to each other to see who have the same interests as you!
                </p>
            </div>
        </div>

    </div> 
</div> 

<div class="footer l-box">
    <p>
        <a href="#"><3</a> 
    </p>
</div>




</body>
</html>
