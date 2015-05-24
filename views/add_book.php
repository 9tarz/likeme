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
<html>
<head>
<meta charset="UTF-8">
<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","tag.php?searchKeyword="+str+"&book_id="+ <?php echo $book->data["book_id"]; ?>,true);
  xmlhttp.send();
}

function sentOldTag() {
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
        xmlhttp.open("GET","tag.php?addTag&book_id=<?php echo $_GET["book_id"]; ?>&tag_id="+ arr_tag_id[i],true);
        xmlhttp.send();
    }
  }

</script>
</head>
<body>

<form method="post" action="book.php?addBook&book_id=<?php echo $book->data["book_id"]; ?>" name="editProfileform">

    <label for="editBook_ISBN">ISBN</label>
    <?php echo $book->data["book_ISBN"]; ?>

    <label for="editBook_book_name">Book Name</label>
    <input id="editBook_book_name" type="text" name="book_name" value="<?php echo $book->data["book_name"]; ?>" required />

    <label for="editBook_book_description">Book Description</label>
    <textarea id="editBook_book_description" name="book_description"><?php echo $book->data["book_description"]; ?></textarea>

    <input type="submit"  name="addBook" onclick= "sentOldTag()" value="AddBook" />

</form>


<form>
    <label>Search tag by Name</label>
    <input type="text" size="30" onkeyup="showResult(this.value)">
    <div id="livesearch"></div>
</form>

</body>
</html>