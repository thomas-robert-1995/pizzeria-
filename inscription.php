<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inscription</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="index.css">
</head>


<!-- Formulaire d'inscription -->
<div class="formulaire">
    <h1>Inscription</h1>
<form method="POST" action="">
    <label for="nom">Votre nom</label>
    <input type="text" id="nom" name="nom" placeholder="Entrez votre nom..." required><br />
    <br />
    <label for="prenom">Votre prénom</label>
    <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prenom..." required><br />
    <br />
    <label for="pseudo">Votre pseudo</label>
    <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo..." required><br />
    <br />
    <label for="email">Votre e-mail</label>
    <input type="text" id="email" name="email" placeholder="Entrez votre e-mail..." required><br />
    <br />
    <label for="password">Votre mot de passe</label>
    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe..." required><br />
    <br />
    <input type="submit" value="M'inscrire" name="inscription">
</form>
</div>

</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<pre>';
    print_r($_POST);  // affiche toutes les données envoyées dans le formulaire
    echo '</pre>';

    // récupérer les valeurs du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    // validation des champs
    if (empty($nom) || empty($prenom) || empty($pseudo) || empty($email) || empty($mdp)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    // Hashage du mot de passe avant insertion
    $hashed_mdp = password_hash($mdp, PASSWORD_DEFAULT);

    // connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "gestionnaire_de_menu";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prépare la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO users (nom, prenom, pseudo, email, mdp) VALUES (?, ?, ?, ?, ?)");

        // lier les paramètres et exécuter la requête
        $stmt->execute([$nom, $prenom, $pseudo, $email, $hashed_mdp]);

        // Affichage de la réussite de l'inscription
        echo "Inscription réussie!";

        // Redirection vers la page connexion.php après une inscription réussie
        header("Location: connexion.php");
        exit(); // Stoppe l'exécution du script après la redirection

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion
    $conn = null;
}
?>

