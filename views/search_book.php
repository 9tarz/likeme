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
}
?>
<?php
    if ($book->data) {
        foreach ($book->data as $book_data) {
            echo "<a href = \"book.php?showBook&book_id=" .$book_data["book_id"].  "\" >" . $book_data["book_name"] . "</a>";
        }
    }
?>