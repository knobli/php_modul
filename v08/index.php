<?php 
	include( 'inc/config.php');
	include( 'inc/autoload.php');
	
	include( 'inc/initDB.php');
	
	include( 'class/post.php');
	include( 'class/lebewesen.php');
	include( 'class/mensch.php');
	include( 'class/schweizer.php');	
?>
<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8" />
	<title>Vorlesung 8</title>
</head>
<body>
	<h1>Aufgabe 1</h1>
	<img src="uml.png" />
	
	<h1>Aufgabe 2-3</h1>
	
	<?php
	$mensch = new Mensch("Test Mensch", "männlich");
	
	echo "Name von Mensch: " . $mensch->getName() . "<br>";
	
	$mensch->umbennen("Tester Mensch");
	
	echo "Alter von Mensch: " . $mensch->getAlter() . "<br>";
	
	if($mensch instanceof Mensch){
		echo $mensch->getName() . " stammt von einem Menschen ab" . "<br>";
	} else {
		echo $mensch->getName() . " stammt NICHT von einem Menschen ab" . "<br>";
	}
	
	echo "Vorfahre von Mensch: " . $mensch->getVorfahre() . "<br>";
	
	$mensch->neueEvolutionstheorie("=Alien=");
	
	echo "Neue Vorfahre von Mensch: " . $mensch->getVorfahre() . "<br>";
	
	$schweizer = new Schweizer("Testin Schweizer", "weiblich");
	
	try{
		$schweizer->umbennen("Testerin Schweizer");
	} catch (Exception $e){
		echo "Exception thrown: " . $e->getMessage();
	}
	?>	
	
	<h1>Aufgabe 4 - 5</h1>
	Row Data Gateway Pattern mit optimistischem Locking	
	<table border="1">
		<thead>
			<th>User 1</th>
			<th>User 2</th>
		</thead>
		<tbody>
			<tr>
				<td><?php
					echo "<b>Create Post1:</b><br>";
					$post1 = new Post();
					$post1->create(array('content' => 'init content'));
					
					echo "Content of Post1: " . $post1->getContent();
				?></td>
				<td></td>
			</tr>		
			<tr>
				<td></td>
				<td><?php
					echo "<b>Load Post1:</b><br>";
					$loadedPost1 = new Post();
					$loadedPost1->findByID( 1 );
					echo "<b>Update Post1:</b><br>";
					$loadedPost1->update(array('content' => 'new content'));
					
					echo "Content of Post1: " . $loadedPost1->getContent();
				?></td>
			</tr>
			<tr>
				<td><?php
					echo "<b>Try to update the still existing reference of Post1:</b><br>";
					try{
						$post1->update(array('content' => 'try update content'));
					} catch(Exception $e){
						echo "<div style='background: red'>Exception thrown with message: " . $e->getMessage() . "</div>";
					}
					
					echo "Content of Post1: " . $post1->getContent();
				?></td>
				<td></td>
			</tr>
		</tbody>
	</table> 
		 
	<br/>
	<br/>
	Beim optimistischen Locking wird die Zeile nicht gelockt, sondern lediglich die Version bei einer Änderung angepasst. Bevor eine Änderung durchgeführt werden kann, wird geschaut, ob die Version der Datenbank noch mit der Version des Objekts übereinstimmen. Falls nicht, wird der User darüber informiert. Falls die Version übereinstimmt, werden die Anpassungen gespeichert.
	 
	<h1>Aufgabe 6</h1>
	Ein Deadlock tritt auf, wenn zwei oder mehrere konkurrierende Aktionen aufeinander warten bis jeweils ein anderer beendet wird. Die Aktionen blockieren sich dadurch gegenseitig und der Deadlock kann sich selber nicht mehr lösen.<br>
	 Beispiel (MySQL - InnoDB):
	 <table border="1">
	 	<thead>
	 		<tr>
	 			<th>User 1</th>
	 			<th>User 2</th>
	 		</tr>
	 	</thead>
	 	<tbody>
			<tr>
		 		<td>Lade Data-Row von Tabelle (Shared Lock)</td>
		 		<td></td>
		 	</tr>
			<tr>
		 		<td></td>
		 		<td>Lösche Data-Row von Tabelle (Exclusiv Lock) - warten bis User 1 Row freigegeben hat</td>
		 	</tr>
			<tr>
		 		<td>Lösche Data-Row von Tabelle (Exclusiv Lock) - warten bis User 2 Row freigegeben hat</td>
		 		<td></td>
		 	</tr>	
		 	<tr>
		 		<td colspan="2">==> Deadlock</td>
		 	</tr>	 		 				 			 		 		
	 	</tbody>
	 </table>
	 
	 
	<h1>Aufgabe 7</h1>
	<ul>
	 	<li>Lost update</li>
	 	<li>Non repeatable read</li>
	</ul>
	 
	 <hr>
	 
</body>
</html>