<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['connexion'])) {
    // Récupérer les valeurs du formulaire
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    // Validation des champs
    if (empty($email) || empty($mdp)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "gestionnaire_de_menu";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête pour vérifier si l'email et le mot de passe existent dans la base de données
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        // Vérifier si l'utilisateur existe
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user['mdp'])) { // Vérifier si le mot de passe correspond
            echo "Connexion réussie!";
            
            // Vous pouvez également démarrer une session et stocker des informations utilisateur
            session_start();
            header("Location: plat.html");
            $_SESSION['user_id'] = $user['id']; // Par exemple, enregistrer l'ID de l'utilisateur
            $_SESSION['user_email'] = $user['email'];
            
        } else {
            echo "E-mail ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion
    $conn = null;
}
?>