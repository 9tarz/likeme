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
            document.getElementById("livesearch").style.border="1px solid #FFFFFF";
            document.getElementById("livesearch").style.color="white";
          }
        }
        xmlhttp.open("GET","book.php?searchKeyword="+str,true);
        xmlhttp.send();
      }
    </script>
  </head>
  <body>
    <div class="pure-u-1 pure-u-md-1-1 pure-u-lg-1-1">
      <div class="pure-u-1 pure-u-md-1-1 pure-u-lg-1-1" style="text-align: center;">
        <h2 style="color:white">Search book by ISBN/Name</h2>
      </div>
      <div class="pure-u-1 pure-u-md-1-3 pure-u-lg-1-3">
      </div>
      <div class="pure-u-1 pure-u-md-1-3 pure-u-lg-1-3">
        <form class="pure-form">
          <input type="text" class="pure-input-rounded" onkeyup="showResult(this.value)">
          <div style="text-align: center;">
            <button type="submit" class="pure-button">Search</button>
          </div>
          <div id="livesearch"></div>
        </form>
      </div>
    </div>

    <div class="pure-u-1 pure-u-md-1-1 pure-u-lg-1-1" style="margin-top:5em">
      <div class="pure-u-1 pure-u-md-1-1 pure-u-lg-1-1">
        <h2 style="color:orange; text-align: center;">Create new book</h2>
      </div>
      <div class="pure-u-1 pure-u-md-1-1 pure-u-lg-1-1">
        <form class="pure-form pure-form-stacked" method="post" action="book.php" name="createBookform">
          <fieldset>
              <div class="pure-g">
                  <div class="pure-u-1 pure-u-md-1-3">
                      <label for="first-name" style="color:white">ISBN</label>
                      <input class="pure-u-23-24" id="createBook_ISBN" type="text" pattern="[0-9]{2,14}" name="book_isbn" required />
                  </div>

                  <div class="pure-u-1 pure-u-md-1-3">
                      <label for="last-name" style="color:white">Book Name</label>
                      <input class="pure-u-23-24" id="createBook_book_name" type="text" name="book_name" required />
                  </div>

                  <div class="pure-u-1 pure-u-md-1-3">
                      <label for="email" style="color:white">Book Description</label>
                      <input class="pure-u-23-24" id="createBook_book_description" type="text" name="book_description" required />
                  </div>
                  <div class="pure-u-1 pure-u-md-1-3">
                  </div>
                  <div class="pure-u-1 pure-u-md-1-3" style="text-align:center">
                    <button type="submit" name="createBook" value="CreateBook" class="pure-button pure-button-primary">Create</button>
                  </div>
              </div>
            </fieldset>
        </form>
        <!-- End of form -->
      </div>
    </div>
  </body>
</html>