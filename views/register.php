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
    <!-- paste here -->
    <div class="pure-u-2 pure-u-md-1-3"></div>
    <div class="pure-u-2 pure-u-md-1-3">
        <strong>
            <em>
                <p style="text-align: center; color: red">
                    <?php
                    // show potential errors / feedback (from login object)
                    if (isset($auth)) {
                        if ($auth->errors) {
                            foreach ($auth->errors as $error) {
                                echo $error;
                            }
                        }
                        if ($auth->messages) {
                            foreach ($auth->messages as $message) {
                                echo $message;
                            }
                        }
                    }
                    ?>
                </p>
            </em>
        </strong>
    </div>
    <div class="pure-u-2 pure-u-md-1-3"></div>
    <div class="pure-u-2 pure-u-md-1-3">
        <strong>
            <em>
                <p style="text-align: center; color: red">
                    <?php
                    // show potential errors / feedback (from registration object)
                    if (isset($registration)) {
                        if ($registration->errors) {
                            foreach ($registration->errors as $error) {
                                echo $error;
                            }
                        }
                        if ($registration->messages) {
                            foreach ($registration->messages as $message) {
                                echo $message;
                            }
                        }
                    }
                    ?>
                </p>
            </em>
        </strong>
    </div>
    <div class="pricing-tables pure-g">
        <div class="pure-u-2 pure-u-md-1-3"></div>
        <div class="pure-u-2 pure-u-md-1-3">
            <div class="pricing-table pricing-table-free pricing-table-selected">
                <div class="pricing-table-header">
                    <h2>Register</h2>
                </div>
                <form method="post" action="register.php" name="registerform" class="pure-form">
                    <ul class="pricing-table-list">
                        <li>
                            <input placeholder="Username" id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="username" required />
                        </li>
                        <li>
                            <input placeholder="Email" id="login_input_email" class="login_input" type="email" name="email" required />
                        <li>
                            <input placeholder="Password" id="login_input_password" class="login_input" type="password" name="password" pattern=".{6,}" required autocomplete="off" />
                        </li>
                        <li>
                            <input placeholder="Confirm password" id="login_input_password_confirm" class="login_input" type="password" name="password_confirm" pattern=".{6,}" required autocomplete="off" />
                        </li>
                        <button type="submit"  name="register" class="button-choose pure-button" value="Register">Register</button>
                </form>
            </div>
        </div>
    </div>
    <div class="pure-u-1-1 pure-u-md-1-1 pure-u-lg-1-1">
        <div class="pure-u-1-1 pure-u-md-1-3 pure-u-lg-1-3">
        </div>
        <div class="pure-u-1-1 pure-u-md-1-3 pure-u-lg-1-3" style="text-align:center">
            <a href="index.php">
            <button class="button-success pure-button"
            style="color: white;
                border-radius: 4px;
                text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
                background: rgb(28, 184, 65);">Login</button>
            </a>
        </div>
    </div>
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
