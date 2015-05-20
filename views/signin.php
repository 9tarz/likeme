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

<!-- login form box -->
<form method="post" action="index.php" name="signinform">

    <label for="signin_input_username">Username</label>
    <input id="signin_input_username" class="login_input" type="text" name="username"  />

    <label for="signin_input_password">Password</label>
    <input id="signin_input_password" class="login_input" type="password" name="password" autocomplete="off"  />

    <input type="submit"  name="signin" value="Sign in" />

</form>

<a href="register.php">Register new account</a>