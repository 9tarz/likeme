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

    var_dump($profile->data);
}
?>
<p><?php echo $profile->data["first_name"]; ?></p>
</br>
<p> last updated at <?php if (isset($profile->data['last_updated_at'])) echo $profile->data['last_updated_at']; else echo ""; {
    # code...
}?> </p>