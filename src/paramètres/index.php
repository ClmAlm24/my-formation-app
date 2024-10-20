<?php
// Démarrage de la session
session_start();

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Inclusion du fichier de connexion à la base de données
require_once '../db_connect.php';
require_once 'parametres.php';

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];

    if (isset($_POST['update_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        if (updatePassword($userId, $currentPassword, $newPassword)) {
            $message = "Mot de passe mis à jour avec succès.";
        } else {
            $error = "Erreur lors de la mise à jour du mot de passe.";
        }
    } elseif (isset($_POST['update_email'])) {
        $newEmail = $_POST['new_email'];
        $password = $_POST['password'];
        $result = updateEmail($userId, $newEmail, $password);
        if ($result === true) {
            $message = "Email mis à jour avec succès.";
            $_SESSION['email'] = $newEmail;
        } elseif ($result === 'email_exists') {
            $error = "Cet email est déjà utilisé par un autre compte.";
        } else {
            $error = "Erreur lors de la mise à jour de l'email.";
        }
    } elseif (isset($_POST['update_username'])) {
        $newUsername = $_POST['new_username'];
        $password = $_POST['password'];
        $result = updateUsername($userId, $newUsername, $password);
        if ($result === true) {
            $message = "Pseudo mis à jour avec succès.";
            $_SESSION['pseudo'] = $newUsername;
        } elseif ($result === 'username_exists') {
            $error = "Ce pseudo est déjà utilisé par un autre compte.";
        } else {
            $error = "Erreur lors de la mise à jour du pseudo.";
        }
    }
}

// Récupération des informations de l'utilisateur
$stmt = $pdo->prepare("SELECT email, pseudo FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@latest/dist/index.min.js"></script>
    <link rel="stylesheet" href="../dist/output.css">
    <script src="../script.js"></script>

</head>
<body class="bg-lightGray text-darkGray">
    <div class=" mx-auto">
        <!-- Header (comme dans votre code original) -->
        <header class="flex shadow-md py-4 px-4 bg-lightAccent font-[sans-serif] min-h-[70px] tracking-wide relative z-50">
        <div class="flex items-center justify-between w-full">
            <!-- Logo -->
            <a href="javascript:void(0)">
                <img src="../assets/images/logo-removebg-preview.png" alt="Logo" class="w-12" />
            </a>

            <div class="flex-grow flex justify-center">
                <div class="text-darkGray font-semibold">
                    <?php echo isset($_SESSION['pseudo']) ? htmlspecialchars($_SESSION['pseudo']) : 'Invité'; ?>
                </div>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden lg:flex items-center space-x-6">
                <a href="../home" class="text-darkGray font-semibold hover:text-primary">Home</a>
                <a href="../profil/" class="text-darkGray font-semibold hover:text-primary">Profil</a>
                <a href="../deconnexion" class="text-darkGray font-semibold hover:text-primary">Deconnexion</a>
                <button
                    class="bg-scooter text-lightAccent px-4 py-2 rounded hover:bg-secondaryLight transition-all duration-300">
                    <a href="../paramètres/" class="block">Paramètres</a>
                </button>
            </nav>

            <!-- Hamburger menu for mobile -->
            <button id="toggleMenu" class="lg:hidden">
                <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <!-- Hidden mobile menu (by default) -->
        <div id="mobileMenu" class="fixed top-0 left-0 w-full h-full bg-lightAccent z-50 p-6 lg:hidden hidden">
            <!-- Close button inside the mobile menu -->
            <button id="closeMenu" class="absolute top-4 right-4">
                <svg class="w-6 h-6" fill="#000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M6.225 4.811a1 1 0 011.415 0L12 9.171l4.36-4.36a1 1 0 111.415 1.415l-4.36 4.36 4.36 4.36a1 1 0 01-1.415 1.415L12 11.998l-4.36 4.36a1 1 0 01-1.415-1.415l4.36-4.36-4.36-4.36a1 1 0 010-1.415z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Mobile navigation menu -->
            <ul class="space-y-4 mt-8">
                <li><a href="../home/" class="text-darkGray font-semibold hover:text-primary">Home</a></li>
                <li><a href="../profil/" class="text-darkGray font-semibold hover:text-primary">Profil</a></li>
                <li><a href="../deconnexion" class="text-darkGray font-semibold hover:text-primary">Deconnexion</a>
                </li>
                <button
                    class="bg-secondary text-lightAccent px-4 py-2 rounded hover:bg-secondaryLight transition-all duration-300">
                    <a href="../paramètres/" class="block">Paramètres</a>
                </button>
            </ul>
        </div>
    </header>
        <!-- Section des paramètres -->
        <div class="mt-6">
            <h2 class="text-2xl font-bold text-center mb-4">Paramètres du Compte</h2>
            
            <?php if (isset($message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $message; ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <!-- Formulaire pour changer le mot de passe -->
            <div class="bg-white p-4 rounded shadow mb-6 mx-auto w-[80%] space-y-4 font-[sans-serif]">
                <h3 class="text-xl font-semibold mb-2">Changer le Mot de Passe</h3>
                <form action="" method="POST">
                    <input type="password" name="current_password" placeholder="Mot de passe actuel" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-secondary rounded" required>
                    <input type="password" name="new_password" placeholder="Nouveau mot de passe" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-secondary rounded" required>
                    <button type="submit" name="update_password" class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-secondary text-white rounded hover:bg-blue-600">Sauvegarder le mot de passe</button>
                </form>
            </div>

            <!-- Formulaire pour changer l'email -->
            <div class="bg-white p-4 rounded shadow mb-6 mx-auto w-[80%] space-y-4 font-[sans-serif]">
                <h3 class="text-xl font-semibold mb-2">Changer l'Email</h3>
                <form action="" method="POST">
                    <input type="email" name="new_email" placeholder="Nouvel email" value="<?php echo htmlspecialchars($user['email']); ?>" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-secondary rounded" required>
                    <input type="password" name="password" placeholder="Mot de passe" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-secondary rounded" required>
                    <button type="submit" name="update_email" class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-secondary text-white rounded hover:bg-blue-600">Sauvegarder l'email</button>
                </form>
            </div>

            <!-- Formulaire pour changer le pseudo -->
            <div class="bg-white p-4 rounded shadow mx-auto w-[80%] space-y-4 font-[sans-serif]">
                <h3 class="text-xl font-semibold mb-2">Changer le Pseudo</h3>
                <form action="" method="POST">
                    <input type="text" name="new_username" placeholder="Nouveau pseudo" value="<?php echo htmlspecialchars($user['pseudo']); ?>" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-secondary rounded" required>
                    <input type="password" name="password" placeholder="Mot de passe" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-secondary rounded" required>
                    <button type="submit" name="update_username" class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-secondary text-white rounded hover:bg-blue-600">Sauvegarder le pseudo</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // JavaScript to toggle the mobile menu
        document.getElementById('toggleMenu').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });

        document.getElementById('closeMenu').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.add('hidden');
        });
    </script>
</body>
</html>