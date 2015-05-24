<?php
if (isset($profile)) {
    if ($profile->errors) {
        foreach ($profile->errors as $error) {
            echo $error;
        }
    }
}
?>


<h2 class="content-head is-center">
    <?php echo $profile->data["first_name"]." ".$profile->data["last_name"]; ?>
</h2>
<div class="pure-g">
    <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3"></div>
    <div class="l-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
        <h3 class="content-subhead" style="text-align: center;">
            About me
        </h3>
        <p>
            <?php echo $profile->data["about"]; ?>
        </p>
    </div>
</div>