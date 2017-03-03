<?php
include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
$mysqli = $db;
		$res = mysqli_query($mysqli, "SELECT * FROM idiomas");
		if(count($res) > 0){
			echo '<table class="table">';
			echo '<tr>';
				echo '<th> Language Code </th>';
				echo '<th> Language Name </th>';
			echo '</tr>';
			foreach($res as $row){
				echo '<tr>';
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['nombre']."</td>";
				echo '</tr>';
			}
			echo '</table>';
}
mysqli_close($mysqli);
?>