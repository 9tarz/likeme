<?php
	require_once("libraries/password_compatibility_library.php");
	require_once("config/db_config.php");
	require_once("classes/Auth.php");

	$auth = new Auth();

	if ($auth->isUserSignin() == true) {
	    include("views/user_bar.php");
	} else {
	    include("views/signin.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
	<title>likeme | connect world</title>
</head>

<body>
	<h1>Welcome to Likeme</h1>
	
</body>

</html>
