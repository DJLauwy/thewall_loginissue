<?php
	require 'incl/config.incl.php';
	require 'incl/head.incl.php';
	require 'incl/login.status.php';
	logInCheck();

	try{
		//Ik moet alleen mijn table 'likes' nog koppelen aan de user_id en post_id.
		//De like-knop zit in de foreach. Op die knop moet de ingelogde gebruiker worden
		//	gekoppeld aan de post_id en de like.
		$sql = 'SELECT `f`.*, `g`.`voornaam`, `g`.`achternaam`, `g`.`email` FROM `fotos` f LEFT JOIN `gebruikers` g ON `g`.`id` = `f`.`gebruiker_id` WHERE `gebruiker_id` = :gebruiker_id ORDER BY `f`.`datum` DESC';

		$statement = $connection->prepare($sql);

		$data = [
			'gebruiker_id' => $_GET['id']
		];

		$statement->execute($data);
		$posts = $statement->fetchAll();
	} catch(\PDOException $e){
		echo $e->getMessage();
		exit();
	}

?>

	<title>Zona | <?php echo $posts[0]['voornaam'] . ' ' . $posts[0]['achternaam'] ?></title>
	<link rel="stylesheet" type="text/css" href="css/lightbox.css">
	<link rel="stylesheet" type="text/css" href="css/like.css">
	<script src="https://kit.fontawesome.com/16946e2d22.js" crossorigin="anonymous"></script>
	</head>

	<body>

		<!-- PROFILE NAV -->
		<nav class="profile-nav">
			<a href="home.php">
				<img src="icon/back-icon.svg" height="25px" width="25px">
			</a>
			<h1 class="user-name-overflow"><?php echo $posts[0]['voornaam'] . ' ' . $posts[0]['achternaam']; ?></h1>
		</nav>

		<!-- GALLERY -->
		<main class="profile-main">
			<div class="profile-main-div">
				
				<!-- POST -->
				<?php foreach($posts as $ppost): ?>
					<!-- THUMBNAIL -->
					<div class="profile-post">
						<img src="uploads/<?php echo $ppost['bestand'] ?>">
					</div>
					<!-- FULL POST -->
					<div class="read-more">
						<p class="author"><?php echo $ppost['voornaam'] . ' ' . $ppost['achternaam'] ?></p>
						<p><?php echo $ppost['titel'] ?></p>
						<img src="uploads/<?php echo $ppost['bestand'] ?>" class="modaal-img">

						<!-- Hier is de like-knop per post -->
						<label for="likeKnop" class="like-post">
							<input type="checkbox" id="likeKnop">
							<i class="far fa-star ster"></i>
						</label>
						<p class="description"><?php echo $ppost['omschrijving'] ?></p>
					</div>
				<?php endforeach ?>

			</div>
		</main>

		<script src="script/lightbox.js"></script>

	</body>
</html>