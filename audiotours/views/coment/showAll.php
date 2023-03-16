<?php 


include_once("./views/templates/document-start.php"); 
?>


<table class="table">
  <thead>
    <tr>
      <th scope="col">Position</th>
      <th scope="col">Name</th>
	  <th scope="col">Score</th>
      <th scope="col">date</th>
    </tr>
  </thead>
	<?php
	if($this->scores==NULL) die();
	else{
		$count=1;
		foreach ($this->scores as $posicion=>$score){
			if ($score->getId()!=NULL){
				echo "<tbody>";
					echo "<tr>";
						echo "<th scope='row'>".$count."</th>";
						echo "<td><a href='".PATHSERVER."score/show/".$score->getId()."'>".$score->getName()."</a></td>";
						echo "<td>".$score->getScore()."</td>";
						echo "<td>".$score->getDate()."</td>";
					echo "</tr>";
				echo "</tbody>";
			}
			$count++;		
		}	
	}
	?>
</table>

<?php include_once("./views/templates/document-end.php");?>

		

