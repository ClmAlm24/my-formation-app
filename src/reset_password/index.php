<?php
// Démarrage de la session
session_start();

// Inclure le fichier de connexion à la base de données
require '../db_connect.php';

// Vérifier si le token est présent dans l'URL
if (!isset($_GET['token'])) {
    header('Location: ../forgot_password/');
    exit;
}

$token = $_GET['token'];

// Vérifier la validité du token
$stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token AND expiration > NOW()");
$stmt->execute(['token' => $token]);
$resetRequest = $stmt->fetch();

if (!$resetRequest) {
    echo "Lien de réinitialisation invalide ou expiré.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@latest/dist/index.min.js"></script>
    <link rel="stylesheet" href="../dist/output.css">
    <script src="../script.js"></script>

</head>

<body class="bg-lightGray text-darkGray flex items-center justify-center min-h-screen">
    <div id="container" class="container mx-4 sm:mx-8 lg:mx-auto p-4 sm:p-6 lg:p-8 rounded-lg">
        <header class="mb-6 text-center">
            <a href="../home/">
                <img src="../assets/images/logo-removebg-preview.png" alt="Logo" class="w-24 sm:w-32 lg:w-40 mx-auto">
            </a>
        </header>

        <div class="body flex flex-col lg:flex-row items-center">
            <div class="mb-6 lg:mb-0 lg:mr-6 text-center lg:text-left w-1/2">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-scooter">Réinitialiser votre mot de passe</h1>
                <p class="text-viking text-sm sm:text-base lg:text-lg">Entrez un nouveau mot de passe pour votre compte.</p>
            </div>

            <div class="flex flex-col w-full lg:w-1/2">
                <div id="resetPasswordSection" class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md">
                    <form action="./reset_password_process.php" method="POST" class="mt-6 space-y-4">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Nouveau mot de passe</label>
                            <input type="password" name="password" placeholder="Entrez votre nouveau mot de passe" required
                                class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-lightAccent bg-scooter hover:bg-iceCold">Réinitialiser le mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
