Hey, <?php echo $_SESSION['username']; ?>. You are logged in.
</br>
<a href="profile.php?uid=<?php echo $_SESSION['uid']; ?> ">My Profile</a>
<a href="profile.php?uid=<?php echo $_SESSION['uid']; ?>&editProfile">Edit My Profile</a>
<a href="index.php?signout">Signout</a>
