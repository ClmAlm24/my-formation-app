<?php
// Démarrage de la session
session_start();

// Vérifiez si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // Si l'utilisateur est connecté, rediriger vers une autre page
    header('Location: ./home/'); // Remplacez par le chemin de votre page d'accueil ou tableau de bord
    exit;
}

// Si l'utilisateur n'est pas connecté, afficher le formulaire de connexion
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@latest/dist/index.min.js"></script>
    <link rel="stylesheet" href="./dist/output.css">
</head>

<body class="bg-lightGray text-darkGray flex items-center justify-center min-h-screen">
    <div id="container" class="container mx-4 sm:mx-8 lg:mx-auto p-4 sm:p-6 lg:p-8 rounded-lg">
        <header class="mb-6 text-center">
            <a href="./home/">
                <img src="./assets/images/logo-removebg-preview.png" alt="Logo" class="w-24 sm:w-32 lg:w-40 mx-auto">
            </a>
        </header>

        <div class="body flex flex-col lg:flex-row items-center">
            <div class="mb-6 lg:mb-0 lg:mr-6 text-center lg:text-left w-1/2">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-scooter">Bienvenue sur ...</h1>
                <p class="text-viking text-sm sm:text-base lg:text-lg">Vous apprenez pas à pas les vulnérabilités du web
                </p>
            </div>

            <div class="flex flex-col w-full lg:w-1/2">
                <!-- Section Connexion -->
                <div id="connexionSection" class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md">
                    <h2 class="text-darkGray text-center text-xl sm:text-2xl font-bold mb-4">Connexion</h2>

                    <!-- Affichage des erreurs ou message de succès -->
                    <!-- Affichage des erreurs ou message de succès -->
                    <?php if (!empty($_SESSION['errors'])): ?>
                        <div class="bg-red-200 text-red-800 p-4 rounded-md mb-4">
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="bg-green-200 text-green-800 p-4 rounded-md mb-4">
                            <p><?php echo htmlspecialchars($_SESSION['success']); ?></p>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>



                    <form action="./connexion.php" id="connexion" class="mt-6 space-y-4" method="POST">
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Email</label>
                            <div class="relative flex items-center">
                                <input type="email" name="email" placeholder="Entrez votre adresse mail" required
                                    class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                            </div>
                        </div>
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Mot de passe</label>
                            <div class="relative flex items-center">
                                <input type="password" name="password" placeholder="Entrez votre mot de passe" required
                                    class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox"
                                    class="h-4 w-4 text-scooter border-gray-300 rounded">
                                <label for="remember-me" class="ml-3 text-sm text-darkGray">Gardez moi connecté</label>
                            </div>
                            <div class="text-sm">
                                <a href="./forgot_password/" class="text-scooter hover:underline font-semibold">Mot de
                                    passe oublié ?</a>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-lightAccent bg-scooter hover:bg-iceCold">Se
                                connecter</button>
                        </div>

                        <div class="text-sm text-center mt-4">
                            Vous n'avez pas de compte ?
                            <a href="./inscription/" class="text-scooter hover:underline font-semibold">Inscrivez-vous
                                !</a>
                        </div>
                    </form>
                </div>
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