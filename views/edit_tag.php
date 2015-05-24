<?php
if (isset($book)) {
    if ($book->errors) {
        foreach ($book->errors as $error) {
            echo $error;
        }
    }
    if ($book->messages) {
        foreach ($book->messages as $message) {
            echo $message;
        }
    }

    //var_dump($book->data);
}
?>

<form method="post" action="tag.php?createTag" name="createTagform">

    <label for="createTag_tag_name">Tag Name</label>
    <input id="createTag_tag_name" type="text" name="tag_name" value="" required />

    <label for="createTag_tag_description">Tag Description</label>
    <textarea id="createTag_tag_description" name="tag_description"></textarea>


    <input hidden id="createTag_book_id" type="text" name="book_id" value=" <?php echo $book->data["book_id"]; ?>" required />

    <input type="submit"  name="createTag" value="CreateTag" />

</form>