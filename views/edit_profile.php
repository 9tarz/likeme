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

<!-- edit profile form -->
<form method="post" action="profile.php?uid=<?php echo $_SESSION['uid']; ?>" name="editProfileform">

    <div style="display: block">
        <div class="pure-u-1-4 pure-u-md-1-4 pure-u-lg-1-4">
        </div>
        <div class="pure-u-1-4 pure-u-md-1-4 pure-u-lg-1-4">
            <div style="display: block; text-align: center;">
                <label for="editProfile_first_name">First Name</label>
            </div>
            <div style="display: block; text-align: center;">
                <input id="editProfile_first_name" type="text" name="first_name" value="<?php echo $profile->data['first_name']; ?>" required />
            </div>
        </div>
        <div class="pure-u-1-4 pure-u-md-1-4 pure-u-lg-1-4" style="vertical-align: middle;">
            <div style="display: block; text-align: center;">
                <label for="editProfile_last_name">Last Name</label>
            </div>
            <div style="display: block; text-align: center;">
                <input id="editProfile_last_name" type="text" name="last_name" value="<?php echo $profile->data['last_name']; ?>" required />    
            </div>
        </div>
    </div>
    
    <div display:block">
        <div class="pure-u-1-1 pure-u-md-1-3 pure-u-lg-1-3">
        </div>

        <div class="pure-u-1-1 pure-u-md-1-3 pure-u-lg-1-3">
            <label for="about" style="display:block; text-align: center;">About you</label>

            <div style="display:block">
                <textarea id="editProfile_about" name="about" rows="4" cols="70">
                <?php echo $profile->data['about']; ?></textarea>
            </div>
            
            <div style="display:block; text-align: center; margin: auto">
                <input type="submit" name="updateProfile" value="UpdateProfile" style="display:block; text-align: center;"/>
            </div>
        </div>
    </div>


</form>

<p> last updated at <?php echo $profile->data['last_updated_at']; ?> </p>