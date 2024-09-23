
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <div class="mb-6 lg:mb-0 lg:mr-6 text-center lg:text-left flex-1">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-scooter">Bienvenue sur ...</h1>
                <p class="text-viking text-sm sm:text-base lg:text-lg">Vous apprenez pas à pas les vulnérabilités du web</p>
            </div>

            <div class="flex flex-col flex-1">
                <!-- Section Inscription -->
                <div id="inscriptionSection" class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md">
                    <h2 class="text-darkGray text-center text-xl sm:text-2xl font-bold mb-4">Inscription</h2>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="text-red-500 text-center mb-4">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="text-green-500 text-center mb-4">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="./inscription.php" method="POST" id="inscription" class="mt-6 space-y-4">
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Email</label>
                            <input type="email" name="email" placeholder="Entrez votre adresse mail" required
                                class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                        </div>
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Pseudo</label>
                            <input type="text" name="pseudo" placeholder="Entrez votre pseudo" required
                                class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                        </div>
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Mot de passe</label>
                            <input type="password" name="password" placeholder="Entrez votre mot de passe" required
                                class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                        </div>
                        <div>
                            <label class="text-darkGray text-sm mb-2 block">Confirmez le mot de passe</label>
                            <input type="password" name="c_password" placeholder="Confirmez votre mot de passe"
                                required class="w-full text-darkGray text-sm border border-gray-300 px-4 py-2 rounded-md outline-scooter">
                        </div>
                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-scooter border-gray-300 rounded" required>
                            <label for="terms" class="ml-3 text-sm text-darkGray">J'ai lu tous les thèmes</label>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-lightAccent bg-scooter hover:bg-iceCold">S'inscrire</button>
                        </div>

                        <div class="text-sm text-center mt-4">
                            Vous avez déjà un compte ?
                            <a href="../" class="text-scooter hover:underline font-semibold">Connectez-vous !</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/script.js"></script>
</body>

</html>
