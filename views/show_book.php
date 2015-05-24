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
<script>
function removeTag() {
  var arr_tag_id = [ <?php
    if ($tag->data) {
        for ($j = 0 ; $j< count($tag->data) ; $j++ )  {
            echo " \"" . $tag->data[$j]["tag_id"] . "\"";
            if ($j < count($tag->data) - 1) 
              echo ",";
        }
    }
    ?>];
  for(i=0; i< <?php echo count($tag->data); ?> ; i++){
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {

        }
      }
        xmlhttp.open("GET","tag.php?removeTag&book_id=<?php echo $_GET["book_id"]; ?>&tag_id="+ arr_tag_id[i],true);
        xmlhttp.send();
    }
  }

</script>
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
		echo "<a href= \"book.php?deleteBook&book_id=" . $book->data["book_id"] . "\" onclick=\"removeTag()\" > remove from my collection</a>";
	} else {
		echo "<a href= \"book.php?addBook&book_id=" . $book->data["book_id"] . "\" >add to collection</a>";
	}
?>
</br>
<?php echo "<a href=\"book.php?updateBook&book_id=" . $book->data["book_id"] . "\"> edit this Book</a>" ; ?>

<h2> Book status </h2>
<?php
    if ($book->data["book_tag_status"]) {
        for ($i =0 ; $i < count($book->data["book_tag_status"]) ; $i++) {
            echo "<li>" . $book->data["book_tag_status"][$i]["tag_name"] . " : " . $book->data["book_tag_status"][$i]["count"] .  "</li>";
        }
    }
?>

