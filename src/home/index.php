<?php
// Démarrage de la session
session_start();

if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: ../index.php'); // Remplacez par le chemin de votre page de connexion
    exit;
}

// Si l'utilisateur est connecté, vous pouvez continuer avec le reste du code de la page
require '../db_connect.php';

// Récupérer les données des vulnérabilités
$query = "SELECT * FROM vulnerabilites";
$stmt = $pdo->query($query);
$vulnerabilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/tw-elements@latest/dist/index.min.js"></script>
    <link rel="stylesheet" href="../dist/output.css">
    <script src="../script.js"></script>

</head>

<body class="bg-lightGray text-darkGray">
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
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="bg-green-200 text-green-800 p-4 rounded-md mb-4">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <!-- Search section -->
    <form action="" class="my-7 flex items-center space-x-2 border-2 relative border-gray-300 rounded-lg bg-white">
        <div class="relative flex w-full">
            <input type="search"
                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary"
                placeholder="Rechercher..." aria-label="Rechercher" id="searchInput" aria-describedby="searchButton" />
            <label for="searchInput"
                class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-gray-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary">Rechercher</label>
            <button
                class="relative z-[2] -ms-0.5 flex items-center rounded-e bg-primary px-5 text-xs font-medium uppercase leading-normal text-lightAccent shadow-primary-3 transition duration-150 ease-in-out hover:bg-primaryLight focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2"
                type="submit" id="searchButton" aria-labelledby="searchInput">
                <span class="[&>svg]:h-5 [&>svg]:w-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
            </button>
        </div>
    </form>

    <div class="vulnerabilites flex flex-wrap gap-4">
        <?php foreach ($vulnerabilities as $vulnerability): ?>
            <div class="vulnerabilite bg-white p-4 rounded-lg shadow-md w-full md:w-1/3" id="<?php echo htmlspecialchars($vulnerability['slug']); ?>">
                <div class="card-image">
                    <img src="https://readymadeui.com/Imagination.webp" alt="Image symbolisant la vulnérabilité <?php echo htmlspecialchars($vulnerability['nom']); ?>" class="w-full rounded-t-lg">
                </div>
                <div class="card-content p-4">
                    <h3 class="vuln-name text-primary text-xl font-semibold"><?php echo htmlspecialchars($vulnerability['nom']); ?></h3>
                    <p class="vuln-description text-darkGray"><?php echo htmlspecialchars($vulnerability['description']); ?></p>
                    <button class="bg-secondary text-lightAccent py-2 px-4 rounded hover:bg-secondaryLight transition duration-200">
                        <a href="../details/?slug=<?php echo urlencode($vulnerability['slug']); ?>">En savoir plus</a>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <!-- Script pour le menu mobile -->
    <script>
        document.getElementById('toggleMenu').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });

        document.getElementById('closeMenu').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.add('hidden');
        });
    </script>
</body>

</html>