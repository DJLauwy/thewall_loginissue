<?php
	require 'incl/config.incl.php';
	require 'incl/head.incl.php';
	require 'incl/login.status.php';
	logInCheck();

	try{
		$sql = 'SELECT `f`.*, `g`.`voornaam`, `g`.`achternaam`, `g`.`email` FROM `fotos` f LEFT JOIN `gebruikers` g ON `g`.`id` = `f`.`gebruiker_id` WHERE `gebruiker_id` = :gebruiker_id ORDER BY `f`.`datum` DESC';

		$statement = $connection->prepare($sql);

		$params = [
			'gebruiker_id' => $_GET['id']
		];

		$statement->execute($params);
	} catch(\PDOException $e){
		echo $e->getMessage();
		exit();
	}

?>

	<title>Zona | Voornaam</title>
	<link rel="stylesheet" type="text/css" href="css/lightbox.css">
	<script src="https://kit.fontawesome.com/16946e2d22.js" crossorigin="anonymous"></script>
	</head>

	<body>

		<!-- PROFILE NAV -->
		<nav class="profile-nav">
			<a href="home.php">
				<img src="icon/back-icon.svg" height="25px" width="25px">
			</a>
			<h1 class="user-name-overflow">Voornaam</h1>
		</nav>

		<!-- GALLERY -->
		<main class="profile-main">
			
			<!-- POST -->
			<?php foreach($statement as $ppost): ?>
				<!-- THUMBNAIL -->
				<div class="profile-post">
					<img src="uploads/<?php echo $ppost['bestand'] ?>">
				</div>
				<!-- FULL POST -->
				<div class="read-more">
					<p class="author"><?php echo $ppost['voornaam'] ?></p>
					<p><?php echo $ppost['titel'] ?></p>
					<img src="uploads/<?php echo $ppost['bestand'] ?>" class="modaal-img">
					<p class="description"><?php echo $ppost['omschrijving'] ?></p>
				</div>
			<?php endforeach ?>

		</main>

		<script src="script/lightbox.js"></script>

	</body>
</html>