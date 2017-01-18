<?php

$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username='student';
$password = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);

$rating = $_GET['rating'];

$sql ="
	SELECT title, genre_name, format_name, rating_name
	FROM dvds 
	INNER JOIN genres 
	ON dvds.genre_id = genres.id
	INNER JOIN formats 
	ON dvds.format_id = formats.id
	INNER JOIN ratings
	ON dvds.rating_id = ratings.id
	WHERE ratings.rating_name = ?
	ORDER BY title
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1,$rating);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);
// var_dump($dvds);
?>

<?php foreach ($dvds as $dvd):?>
	<div>
		<h2><?= $dvd->title ?></h2>
		<p>Genre: <?= $dvd->genre_name ?></p>
		<p>Format: <?= $dvd->format_name ?></p>
		<p>Rating: <?= $dvd->rating_name ?></p>
	</div>
<?php endforeach; ?>
