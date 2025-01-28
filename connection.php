<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Connexion</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>

        <!-- Formulaire de connexion -->

<form method="POST" action="">
    <label for="email">Votre e-mail</label>
    <input type="text" id="email" name="email" placeholder="Entrez votre e-mail..." required><br />
    <br />
    <label for="password">Votre mot de passe</label>
    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe..." required><br />
    <br />
    <input type="submit" value="Se connecter" name="connexion">
</form>

</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['connexion'])) {
    echo '<pre>';
    print_r($_POST);  // affiche toutes les données envoyées dans le formulaire
    echo '</pre>';

    // récupérer les valeurs du formulaire
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    // validation des champs
    if (empty($email) || empty($mdp)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    // connexion à la base de données avec PDO
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "gestionnaire_de_menu";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // vérifier si l'utilisateur existe dans la base de données
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $users['password'])) {
            // l'utilisateur est authentifié
            echo "Connexion réussie!";
        } else {
            // l'email ou le mot de passe est incorrect
            echo "Identifiants incorrects.";
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion
    $conn = null;
}
?>
