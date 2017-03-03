<?php
include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
		$res = mysqli_query($mysqli, "SELECT * FROM idiomas");
		if(count($res) > 0){
			echo '<table class="table">';
			echo '<tr>';
				echo '<th> Language Code </th>';
				echo '<th> Language Name </th>';
				echo '<th> Option </th>';
			echo '</tr>';
			foreach($res as $row){
				echo '<tr>';
					echo "<td>".$row['id']."</td>";
					echo "<td>".$row['nombre']."</td>";
					echo '<td><button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-minus aria-hidden="true"></span></button></td>';
				echo '</tr>';
			}
			echo '</table>';
}
mysqli_close($mysqli);
?>