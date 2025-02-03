<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Pizza-de-la-mama-Connexion</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <main>
        <!-- Formulaire de connexion -->
        <div class="container">
            <div class="formulaire">
                <h1>Connexion</h1>
                <form method="POST" action="">
                    <label for="email">Votre e-mail</label>
                    <input type="text" id="email" name="email" placeholder="Entrez votre e-mail..." required><br />
                    <br />
                    <label for="password">Votre mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe..."
                        required><br />
                    <br />
                    <input type="submit" value="Se connecter" name="connexion">
                    <a href="inscription.php">inscription</a>
                </form>
            </div>
        </div>
    </main>
</body>

</html>

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