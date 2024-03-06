<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Ladda up bild</title>
</head>

<body>
<h2>Bilduppladdningsexempel</h2>
<hr>
<p>Ladda upp en png, jag eller gif-bild. Samtidigt skapas en "thumbnail" med storleken 320px 
(antingen bredd eller höjd). Sparas i en mapp images. Maxstorlek är 4 MB.</p>
<br>
<form action="resize.php" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend>Ladda upp bild</legend>
    <p>
      <label for="image">Välj en bild:</label>
      <input type="file" name="image" id="image">
    </p>
    <p>
      <input type="submit" name="submit" value="Ladda up">
    </p>
  </fieldset>
</form>
</body>
</html>