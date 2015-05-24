<?php
if (isset($book)) {
    if ($book->errors) {
        foreach ($book->errors as $error) {
            echo $error;
        }
    }
}
?>
<!-- book_id, book_name, book_description -->
<div class="pure-u-1 pure-u-md-1-1 pure-u-lg-1-1">
    <h2 class="content-head content-head-ribbon" style="text-align: center;">Books</h2>
</div>
<?php
    if ($book->data) {
        foreach ($book->data as $book_data) {
            echo "<div class=\"pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4\">
                    <div style=\"border: 3px solid white; width: 100%px; height: 100px; margin: 10px 10px 10px 10px;\">
                        <p style =\"display: block; text-align: center; color: white; font-size: 1.5em;\">"
                        .$book_data["book_name"]
                        ."</p>
                        <p style =\"display: block; text-align: center; margin-top: -20px;\">"
                        .$book_data["book_description"]
                        ."</p>
                    </div>
                </div>";
        }
    }
?>

<!--
<div class="pure-u-1-2 pure-u-md-1-3 pure-u-lg-1-4">
    <div style="border: 3px solid white; width: 100%px; height: 100px; margin: 10px 10px 10px 10px;">
        <p style ="display: block; text-align: center; color: white; font-size: 1.5em;">xx</p>
        <p style ="display: block; text-align: center; margin-top: -20px;">xxx</p>
    </div>
</div>
-->