<?php
	ob_start();
	
if(isset($_POST["submit"])&&$_FILES['image']['size'] <= 4000000){
	/*$_FILES är en vektor med samma namn som det vi gav åt välj fil-knappen
	  Kan skrivas ut med print_r($_FILES);
	*/
	//sparar det temporära namnet
	$uploadFile = $_FILES['image']['tmp_name'];
	
	//tar reda på bildens storlek, get imagesize skapar en vektor
	//bildens bredd finns i [0] och höjd i [1].[2] finns typ av fil
	$sourceProperties = getimagesize($uploadFile); 
	/*
	echo $sourceProperties[0]."<br>";
	echo $sourceProperties[1]."<br>";
	echo $sourceProperties[2];
	*/
	
	//Plockar ut bildens namn
	$fileName = pathinfo($_FILES['image']['name'],PATHINFO_FILENAME);
	$ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
	
	$path = "images/";
	
	//Skapar mappen om den inte finns
	if(!file_exists($path)){
		mkdir($path,0755);
		chmod($path,0755);
	}
	
	//tar reda vilken sort fil, dvs. jpg, gif eller png
	$imageType = $sourceProperties[2];
	
	switch($imageType){
		case IMAGETYPE_PNG:
			 $imageSrc = imagecreatefrompng($uploadFile);
			 $tmp = imageResize($imageSrc, $sourceProperties[0],$sourceProperties[1]);
			 imagepng($tmp, $path.$fileName."_resized.".$ext);
			 break;
		
		case IMAGETYPE_JPEG:
			 $imageSrc = imagecreatefromjpeg($uploadFile);
			 $tmp = imageResize($imageSrc, $sourceProperties[0],$sourceProperties[1]);
			 imagejpeg($tmp, $path.$fileName."_resized.".$ext);
			 break;
		
		case IMAGETYPE_GIF:
			 $imageSrc = imagecreatefromgif($uploadFile);
			 $tmp = imageResize($imageSrc, $sourceProperties[0],$sourceProperties[1]);
			 imagegif($tmp, $path.$fileName."_resized.".$ext);
			 break;
		
		defalt:
		echo "<p>Felaktig filtyp</p>";
		exit;
	}

	//kopiera orginalbilden från tmp_mappen images
	move_uploaded_file($uploadFile, $path.$fileName.".".$ext);
	echo"Bilen har lagrats i mappen images och en kopia skapades i samma mapp.";
	
	#passar på att lagra filnamn och filändelse i databasen
	include "dbconn.php";
	
	$sql = "INSERT INTO tblImages(filename, extension) VALUES('$fileName','$ext')";
	
	$dbconn->query($sql);
	$dbconn->close();
	
	#hoppar till index-sidan
	header("Location:index.php");
	exit();
	
	echo"<p>Bilden och en mindre version sparades i mappen images</p>";
}
else{
	echo"<p>Ingen eller för stor fil!</p>";
	echo"<a href='upload.php'>Försök på nytt</a>";
}
exit;




function imageResize($imageSrc, $imageWidth, $imageHeight){
	//Sätter största bredd eller höjd
	$maxRes = "320";
	
	#Resamplar bilden, försöker med höjden först
	$proportion = $maxRes/$imageWidth;
	$newImageWidth = $maxRes;
	$newImageHeight = $imageHeight * $proportion;
	
	#...om det blir galet, tar vi höjden först
	if($imageHeight>$maxRes){
		$proportion = $maxRes/$imageHeight;
		$newImageHeight = $maxRes;
		$newImageWidth = $imageWidth * $proportion;
	}
	
	#skapar en ny bild med nya mått, med ganska många parametrar
	$newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
	imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);
	
	#returnerar resultatet, som sedan sparas med rätt namn + texten "_resized" och ändelse
	
	return $newImageLayer;
}
	
?>















