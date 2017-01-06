
<h2>Söögid</h2>
<?php 
	$html="<table>";
		$html .="<tr>";
			$html .="<th>ID</th>";
			$html .="<th>Toidunimi</th>";
			$html .="<th>Päev</th>";
			$html .="<th>Hind</th>";
	$html .="</tr>";
	//iga liikmekohta masssiiivis
	foreach($people as $p){
		$html .="<tr>";
			$html .="<td>".$p->id."</td>";
			$html .="<td>".$p->Food."</td>";
			$html .="<td>".$p->Day."</td>";
			$html .="<td>".$p->Price."</td>";
			$html .= "<td><a href='edit.php?id=".$p->id."'>edit.php</a></td>";
	$html .="</tr>";	
	}
	$html .="</table>";
	echo $html;
	
	
?>