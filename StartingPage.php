<!DOCTYPE html>
<html>
<body>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<div class = "whitebox">
	<span>
		<a class = 'big' style="text-decoration:none" href="http://lindebaaijens.nl/BKWMusicRecommendation/StartingPage.php"> BKW</a>
	</span>
	<span>
	 <a class = 'small' style="text-decoration:none" href="http://lindebaaijens.nl/BKWMusicRecommendation/StartingPage.php" >Music Recommendation</a>
	</span>
</div>
<form class = "box" action="Playlist.php" method="get">
	<span style = "padding-left: 30px ; ">
	 <input class = "search" name= search type="text" value="Search">
	</span>
	<span style = "padding-left: 50px ; "> 
		<select name = type class = "dropdown">
		  <option value="single">Single</option>
		  <option value="album">Album</option>
		  <option value="artist">Artist</option>
		</select></span>
	<span style = "padding-left: 50px ; "> 
		<input class = "button" type="submit" value="Create Playlist!">
	</span>
</form>



</body>
</html>