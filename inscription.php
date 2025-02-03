

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

        echo "Inscription réussie!";
        header("Location: connexion.html");
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        header("Location: index.html");
    }

    // Fermer la connexion
    $conn = null;
}
?>
