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

    //var_dump($book->getBookTagCount(1));
}
?>
</br>
<h2> My books</h2>
<?php
    if ($book->data) {
        foreach ($book->data as $book_data) {
            echo "<li>" . $book_data["book_name"] . "</li>";
        }
    }
?>
</br>

<?php
    if ($book->data) {
        foreach ($book->data as $book_data) {
            //var_dump($book->getBookTagCount($book_data["book_id"]));
        }
    }
    //var_dump($book->getUserStatus($_GET["uid"], 1));
?>
