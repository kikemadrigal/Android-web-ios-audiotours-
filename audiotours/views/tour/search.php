<?php
include_once("./views/templates/document-start.php"); 
?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Title</th>
	  <th scope="col">GenId</th>
      <th scope="col">Year</th>
      <th scope="col">Publisher</th>
      <th scope="col">Developer</th>
      <th scope="col">System</th>
    </tr>
  </thead>
<?php
//Obtenemos los 10 últimos juegos
//El text search lo obtenemos en el index
$games=GameRepository::getSearchGameByTitle($search);
if($games==NULL) die();
	else{
		foreach ($games as $posicion=>$game){
			if ($game->getTitle()!=NULL){
				echo "<tbody>";
					echo "<tr>";
						echo "<th scope='row'>".$game->getId()."</th>";
						echo "<td><a href='".PATHSERVER."Game/show/".$game->getId()."'>".Util::cortarCadena($game->getTitle())."</a></td>";
						echo "<td><a href='http://www.generation-msx.nl/msxdb/softwareinfo/".$game->getCover()."' target='_blanck'>".$game->getCover()."</a></td>";
						echo "<td>".$game->getYear()."</td>";
						echo "<td>".$game->getPublisher()."</td>";
						echo "<td>".$game->getCountry()."</td>";
						echo "<td>".$game->getFormat()."</td>";
						echo "<td>".$game->getSystem()."</td>";
					echo "</tr>";
				echo "</tbody>";
			}
		}	
	}	
?>
</table>
<?php
include_once("./views/templates/document-end.php"); 
?>