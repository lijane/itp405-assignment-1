<?php

$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username='student';
$password = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);

$title = $_GET['title'];

$sql ="
	SELECT title, genre_name, format_name, rating_name
	FROM dvds 
	INNER JOIN genres 
	ON dvds.genre_id = genres.id
	INNER JOIN formats 
	ON dvds.format_id = formats.id
	INNER JOIN ratings
	ON dvds.rating_id = ratings.id
	WHERE title LIKE ?
	ORDER BY title
";

$statement = $pdo->prepare($sql); //Prepared statement
$like = '%'.$_GET['title'].'%';
$statement->bindParam(1,$like);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

if ($title === NULL){
	header('Location:index.php');
}

echo "You searched for '". $title. "':";
// echo $statement->rowCount();

$results = $statement->rowCount();

if ($results == 0){
	echo " Nothing was found. ";
	echo "Return to <a href='index.php'>Search Page.</a>";
}

?>

<hr>

<?php foreach ($dvds as $dvd):?>
	<div>
		<h2><?= $dvd->title ?></h2>
		<p>Genre: <?= $dvd->genre_name ?></p>
		<p>Format: <?= $dvd->format_name ?></p>
<!-- 		<p>Rating: <?= $dvd->rating ?></p>
 -->		<p>
			Rating: 
			<a href="ratings.php?rating=<?= $dvd->rating_name ?>">
				<?= $dvd->rating_name ?>
			</a>
		</p>
	</div>
<?php endforeach; ?>