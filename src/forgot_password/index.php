<?php
// Démarrage de la session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements@latest/dist/index.min.js"></script>
    <link rel="stylesheet" href="../dist/output.css">
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
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-scooter">Mot de passe oublié</h1>
                <p class="text-viking text-sm sm:text-base lg:text-lg">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>
            </div>

            <div class="flex flex-col w-full lg:w-1/2">
                <div id="forgotPasswordSection" class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md">
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

                    <form action="./forgot_password_process.php" method="POST" class="mt-6 space-y-4">
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Email</label>
                            <input type="email" name="email" placeholder="Entrez votre adresse email" required
                                class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-lightAccent bg-scooter hover:bg-iceCold">Envoyer le lien de réinitialisation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
