<?php
if (isset($profile)) {
    if ($profile->errors) {
        foreach ($profile->errors as $error) {
            echo $error;
        }
    }
    if ($profile->messages) {
        foreach ($profile->messages as $message) {
            echo $message;
        }
    }

}
?>

<h1>  <?php echo $_SESSION['username']; ?> </h1>

<!-- edit profile form -->
<form method="post" action="profile.php?uid=<?php echo $_SESSION['uid']; ?>" name="editProfileform">

    <label for="editProfile_first_name">First Name</label>
    <input id="editProfile_first_name" type="text" name="first_name" value="<?php echo $profile->data['first_name']; ?>" required />

    <label for="editProfile_last_name">Last Name</label>
    <input id="editProfile_last_name" type="text" name="last_name" value="<?php echo $profile->data['last_name']; ?>" required />

    <label for="about">About you</label>
    <input id="editProfile_about" type="text" name="about" value="<?php echo $profile->data['about']; ?>" required />

    <input type="submit"  name="updateProfile" value="UpdateProfile" />

</form>

<p> last updated at <?php echo $profile->data['last_updated_at']; ?> </p>