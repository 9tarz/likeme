<?php

    require_once("libraries/password_compatibility_library.php");

	require_once("config/db_config.php");

	require_once("classes/Book.php");

	require_once("classes/Profile.php");

	require_once("classes/Tag.php");

	$profile = new Profile();
	$book = new Book();
	$tag = new Tag();

?>
<html>
  <head>
  	<meta charset="utf-8">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
      	<?php 
        $users_id = $book->getUsersID(); 

		for ($i = 0; $i < count($users_id) ; $i++) {
			$book->updatedUserTag($users_id[$i]["uid"]); // updateUserTagTable
		}

		$arr_tag_id = $book->getUserStatus($_GET["uid"],1);
		$arr_tag_name = $book->getUserStatus($_GET["uid"],3);

		for ($i = 0; $i < count($arr_tag_id) ;$i++ ) {
			
			$users_use_same_tag = $book->searchByTag($arr_tag_id[$i], $_GET["uid"]);

			$count_sum = $users_use_same_tag["count_sum"];

			if ($count_sum != NULL) {
				//echo "<p>" . $arr_tag_name[$i] . "</p>";
				echo "var options_". $i . " = {
        		legend: 'none',
        		pieSliceText: 'label',
        		pieStartAngle: 100,";
        		echo "title: '" . $arr_tag_name[$i]. "' }; ";
			} 

        	echo "var data_" .$i. " = google.visualization.arrayToDataTable(["; 
        	
        		?>
         	
         	['Tag Name', 'Similarity (%)'],

         <?php
			for ($j = 0; $j < count($users_use_same_tag) - 1 ; $j++) {
				echo "['" . $users_use_same_tag[$j]["username"] . "', " . ($users_use_same_tag[$j]["tag_count"]/$count_sum)*100 . "]";
				if ($j < count($users_use_same_tag) - 2)
					echo ",";

			}
			echo "]);";
		}

        for ($i = 0; $i < count($arr_tag_id) ;$i++ ) {

	        echo "var chart_" . $i . "= new google.visualization.PieChart(document.getElementById('piechart_" . $i . "'));
	        chart_" . $i .".draw(data_" . $i . ", options_" . $i . ");";

    	}

        ?>

      }
    </script>
  </head>
  <body>
  	<?php
  	for ($i = 0; $i < count($arr_tag_id) ;$i++ ) {
    	echo "<div id=\"piechart_" .$i . "\" style=\"width: 900px; height: 500px;\"></div>";
    }
    ?>
  </body>
</html>