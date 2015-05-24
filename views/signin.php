
<!-- login form box -->
<!--
<form method="post" action="index.php" name="signinform">

    <label for="signin_input_username">Username</label>
    <input id="signin_input_username" class="login_input" type="text" name="username"  />

    <label for="signin_input_password">Password</label>
    <input id="signin_input_password" class="login_input" type="password" name="password" autocomplete="off"  />

    <input type="submit"  name="signin" value="Sign in" />

</form>
-->

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
<div class="pricing-tables pure-g">
    <div class="pure-u-2 pure-u-md-1-3"></div>
    <div class="pure-u-2 pure-u-md-1-3">
        <div class="pricing-table pricing-table-biz pricing-table-selected">
            <div class="pricing-table-header">
                <h2>LOGIN</h2>
            </div>
            <form method="post" action="index.php" name="signinform" class="pure-form">
                <ul class="pricing-table-list">
                    <li><input placeholder="Username" id="signin_input_username" class="login_input" type="text" name="username"  /></li>
                    <li><input placeholder="Password" id="signin_input_password" class="login_input" type="password" name="password" autocomplete="off" /></li>
                    <button type="submit"  name="signin" class="button-choose pure-button">Sign in</button>
            </form>
        </div>
    </div>
</div>
<div class="pure-u-1-1 pure-u-md-1-1 pure-u-lg-1-1">
    <div class="pure-u-1-1 pure-u-md-1-3 pure-u-lg-1-3">
    </div>
    <div class="pure-u-1-1 pure-u-md-1-3 pure-u-lg-1-3" style="text-align:center">
        <a href="register.php">
        <button class="button-success pure-button"
        style="color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
            background: rgb(28, 184, 65);">Register</button>
        </a>
    </div>
</div>