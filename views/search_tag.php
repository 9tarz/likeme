<?php
if (isset($tag)) {
    if ($tag->errors) {
        foreach ($tag->errors as $error) {
            echo $error;
        }
    }
    if ($tag->messages) {
        foreach ($tag->messages as $message) {
            echo $message;
        }
    }
}
?>
<?php
    if ($tag->data) {
        foreach ($tag->data as $tag_data) {
            echo "<a href = \"tag.php?addTag&book_id=" .$_GET["book_id"].  "&tag_id=" . $tag_data["tag_id"] . " \" >" . $tag_data["tag_name"] . "</a>";
        }
    }
?>