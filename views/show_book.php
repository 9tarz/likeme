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
<label>ISBN </label> <?php echo $book->data["book_ISBN"]; ?> </br>
<label>name </label> <?php echo $book->data["book_name"]; ?> </br>
<label>description </label> <?php echo $book->data["book_description"]; ?> </br>
<label>created at </label>  <?php echo $book->data["created_at"]; ?> </br>
<label>last updated at </label> <?php echo $book->data["updated_at"]; ?> </br>
<label>tag </label>
<?php
    if ($tag->data) {
        foreach ($tag->data as $tag_data) {
            echo "" . $tag_data["tag_name"] . ", ";
        }
    }
?>

<?php 
	if ($book->isOwnerBook($book->data["book_id"], $_SESSION["uid"])) {
		echo "<p> You have this book. </p></br>";
		echo "<a href= \"book.php?deleteBook&book_id=" . $book->data["book_id"] . "\" > remove from my collection</a>";
	} else {
		echo "<a href= \"book.php?addBook&book_id=" . $book->data["book_id"] . "\" >add to collection</a>";
	}
?>
</br>
<?php echo "<a href=\"book.php?updateBook&book_id=" . $book->data["book_id"] . "\"> edit this Book</a>" ; ?>

