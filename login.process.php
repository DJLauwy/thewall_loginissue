<?php

//Hier ergens gaat iets fout. Als je verkeerde gegevens hebt ingevuld komt er
//	niets in beeld.

require 'incl/config.incl.php';
require 'incl/head.incl.php';

?>
<title>Zona | Logging in...</title>

<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    $sql = 'SELECT * FROM `gebruikers` WHERE `email` = :email';

    $statement = $connection->prepare($sql);

    $data = [
        'email' => $email
    ];

    $result = $statement->execute($data);

    // Check of er één user is met dit email adres
    if ($statement->rowCount() === 1) {
        $gebruiker = $statement->fetch();

        if (password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
            $_SESSION['user_id'] = $gebruiker['id'];
            $_SESSION['voornaam'] = $gebruiker['voornaam'];
            $_SESSION['achternaam'] = $gebruiker['achternaam'];
            header('Location: home.php');
        } else {
            $errors['wachtwoord'] = 'Wrong password!';
        }
    } else {
        echo 'users found for this email: ' . $statement->rowCount();
        echo 'login failed: no user found or more than one!';
        echo '<a href="login.php">return</a>';
    }
}


?>