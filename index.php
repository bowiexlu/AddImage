<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Bildgalleri</title>
    <link href="layout.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
    	<h1>Bildgalleri</h1>
    </header>
    <nav>
    	<li><a href="upload.php">Lägg till ny bild</a></li>
    
    </nav>
    <section>
    	<?php
			/*Lista upp innehållet med hjälp av databasens innehåll*/
			include "dbconn.php";
			$path = "images/";
			$resized = "_resized.";
			
			$sql = "SELECT * FROM tblImages";
			$result = $dbconn -> query ($sql);
			
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					echo"<article>";
						$image = $path.$row['filename'].$resized.$row['extension'];
						echo"<img src='".$image."'>";
					echo"</article>";
					
				}
			}
			else{
				echo"<article>";
					echo"<p>Det finns inga bilder!</p>";
				echo"</article>";
			}
			
			$dbconn -> close();
		
		?>
    </section>
    <footer>
    	<p>&copy; Made by Lu</p>
    </footer>
</body>
</html>