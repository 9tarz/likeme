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
       // echo json_encode($book->data);
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
  xmlhttp.open("GET","book.php?searchKeyword="+str,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<h2> My books</h2>
<?php
    if ($book->data) {
        foreach ($book->data as $book_data) {
            echo "<li>" . $book_data["book_name"] . "</li>";
        }
    }
?>
</br>
<form>
    <label>Search book by ISBN/Name</label>
    <input type="text" size="30" onkeyup="showResult(this.value)">
    <div id="livesearch"></div>
</form>

<form method="post" action="book.php" name="createBookform">

    <label for="createBook_ISBN">ISBN</label>
    <input id="createBook_ISBN" type="text" pattern="[0-9]{2,14}" name="book_isbn" required />

    <label for="createBook_book_name">Book Name</label>
    <input id="createBook_book_name" type="text" name="book_name" required />

    <label for="creatBook_book_description">Book Description</label>
    <input id="createBook_book_description" type="text" name="book_description" required />


    <input type="submit"  name="createBook" value="CreateBook" />

</form>


</body>
</html>