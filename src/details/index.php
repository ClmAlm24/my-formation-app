<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../db_connect.php';


$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
// var_dump($slug);
if (!empty($slug)) {
    
    $stmt = $pdo->prepare('SELECT * FROM vulnerabilites WHERE slug = :slug');
    $stmt->execute(['slug' => $slug]);
    $vuln = $stmt->fetch();

    if ($vuln) {
        $stmt = $pdo->prepare('SELECT is_finished FROM cours WHERE vuln_id = :vuln_id');
        $stmt->execute(['vuln_id' => $vuln['id']]);
        $cours = $stmt->fetch() ?: ['is_finished' => 0];

        $stmt = $pdo->prepare('SELECT * FROM challenges WHERE vuln_id = :vuln_id');
        $stmt->execute(['vuln_id' => $vuln['id']]);
        $challenges = $stmt->fetchAll();

        $finishedText = (isset($cours['is_finished']) && $cours['is_finished']) ? 'Annuler la confirmation' : 'Marquer comme terminé';
    } else {
        $vuln = null;
        $challenges = [];
        $cours = ['is_finished' => 0];
        $finishedText = 'Marquer comme terminé';
    }
} else {
    $vuln = null;
    $challenges = [];
    $cours = ['is_finished' => 0];
    $finishedText = 'Marquer comme terminé';
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']);

if ($message) {
    $messageClass = $message['type'] === 'success' ? 'bg-green-500' : 'bg-red-500';
    echo "<p class='$messageClass p-4'>{$message['text']}</p>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/tw-elements@latest/dist/index.min.js"></script>
    
    <link rel="stylesheet" href="../dist/output.css">
    <script src="../script.js"></script>

</head>

<body class="bg-lightGray text-darkGray">
    <div class="">
        <header
            class="flex shadow-md py-4 px-4 bg-lightAccent font-[sans-serif] min-h-[70px] tracking-wide relative z-50">
            <div class="flex items-center justify-between w-full">
                <!-- Logo -->
                <a href="javascript:void(0)">
                    <img src="../assets/images/logo-removebg-preview.png" alt="Logo" class="w-12" />
                </a>

                <!-- Centrage du pseudo -->
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

        <!-- Section de détails -->
        <div class="flex">
            <!-- Barre verticale de menu -->
            <aside
                class="bg-white shadow-lg h-screen  top-0 left-0 w-1/4 py-6 px-4 font-[sans-serif] border-r border-darkGray overflow-auto">
                <h2 class="text-xl font-semibold mb-4">Menu</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="#cours"
                            class="text-black hover:text-blue-600 text-[15px] block hover:bg-blue-50 rounded px-4 py-2.5 transition-all">
                            Cours
                        </a>
                    </li>
                    <li>
                        <a href="#challenges"
                            class="text-black hover:text-blue-600 text-[15px] block hover:bg-blue-50 rounded px-4 py-2.5 transition-all">
                            Challenges
                        </a>
                    </li>
                    <li>
                        <a href="#guides"
                            class="text-black hover:text-blue-600 text-[15px] block hover:bg-blue-50 rounded px-4 py-2.5 transition-all">
                            Guides
                        </a>
                    </li>
                </ul>



            </aside>


            <!-- Contenu principal -->
            <main class="w-3/4 bg-white">
                <h2 class="text-2xl font-bold mb-4 p-4">
                    <?php echo htmlspecialchars($vuln ? $vuln['nom'] : 'Vulnérabilité'); ?>
                </h2>

                <!-- Contenu basé sur la sélection -->
                <div id="contenu" class="space-y-6">
                    <!-- Cours -->
                    <div id="cours" class="p-4 rounded shadow hidden">
                        <h3 class="text-xl font-semibold mb-2">Cours</h3>
                        <p>Informations sur le cours lié à cette vulnérabilité.</p>
                        <form action="update_course.php" method="POST">
                        <input type="hidden" name="vuln_id" value="<?php echo $vuln['id']; ?>">
                            <input type="hidden" name="is_finished"
                                value="<?php echo $cours['is_finished'] ? '0' : '1'; ?>">
                            <button type="submit"
                                class="bg-secondary text-lightAccent py-2 px-4 rounded hover:bg-secondaryLight transition duration-200">
                                <?php echo $finishedText; ?>
                            </button>
                        </form>
                    </div>


                    <!-- Challenge -->
                    <div id="challenges" class="bg-white p-4 rounded shadow hidden">
                        <h3 class="text-xl font-semibold mb-2">Challenges</h3>
                        <?php if (!empty($challenges)): ?>
                            <ul class="space-y-4">
                                <?php foreach ($challenges as $challenge): ?>
                                    <li class="p-4 border border-gray-300 rounded">
                                        <div class="mb-2 text-gray-700 flex justify-between items-start">
                                            <span
                                                class="w-[60%]"><?php echo htmlspecialchars($challenge['description']); ?></span>
                                            <!-- Afficher le statut du challenge -->
                                            <span
                                                class="font-bold p-4 text-white <?php echo $challenge['is_solved'] ? 'bg-green-500' : 'bg-red-500'; ?>">
                                                <?php
                                                //  echo $challenge['is_solved'] ? 'Résolu' : 'Non résolu'; 
                                                 ?>
                                            </span>
                                        </div>
                                        <a href="<?php echo htmlspecialchars($challenge['link']); ?>" target="_blank"
                                            class="block text-blue-500 font-semibold hover:underline mb-4 w-auto">Accéder au
                                            challenge</a>
                                        <form action="challenge.php" method="POST" class="space-y-4">
                                            <input type="hidden" name="challenge_id"
                                                value="<?php echo htmlspecialchars($challenge['id']); ?>">
                                            <input type="text" name="flag" placeholder="FLAG{FAKE_FLAG}"
                                                class="p-3 border border-darkGray rounded w-full text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary transition-colors duration-300">
                                            <button type="submit"
                                                class="w-full px-4 py-2 bg-blue-500 text-lightAccent rounded hover:bg-primaryLight focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-300">
                                                Soumettre
                                            </button>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Aucun challenge associé à cette vulnérabilité.</p>
                        <?php endif; ?>
                    </div>





                    <!-- Guide -->
                    <div id="guides" class="bg-white p-4 rounded shadow hidden">
                        <h3 class="text-xl font-semibold mb-2">Guide</h3>
                        <p>Informations sur le guide associé.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get all the sections
            const coursSection = document.getElementById("cours");
            const challengesSection = document.getElementById("challenges");
            const guidesSection = document.getElementById("guides");

            // Get all the menu links
            const coursLink = document.querySelector('a[href="#cours"]');
            const challengesLink = document.querySelector('a[href="#challenges"]');
            const guidesLink = document.querySelector('a[href="#guides"]');

            // Function to hide all sections
            function hideAllSections() {
                coursSection.classList.add("hidden");
                challengesSection.classList.add("hidden");
                guidesSection.classList.add("hidden");
            }

            // Function to show the selected section
            function showSection(section) {
                hideAllSections();
                section.classList.remove("hidden");
            }

            // Add event listeners for each menu link
            coursLink.addEventListener("click", function () {
                showSection(coursSection);
            });

            challengesLink.addEventListener("click", function () {
                showSection(challengesSection);
            });

            guidesLink.addEventListener("click", function () {
                showSection(guidesSection);
            });

            // Check the URL fragment and show the corresponding section
            const hash = window.location.hash;
            if (hash === "#challenges") {
                showSection(challengesSection);
            } else if (hash === "#cours") {
                showSection(coursSection);
            } else if (hash === "#guides") {
                showSection(guidesSection);
            } else {
                // Default to showing "Cours" section if no hash is provided
                showSection(coursSection);
            }

            // Handle the mobile menu
            document.getElementById('toggleMenu').addEventListener('click', function () {
                document.getElementById('mobileMenu').classList.toggle('hidden');
            });

            document.getElementById('closeMenu').addEventListener('click', function () {
                document.getElementById('mobileMenu').classList.add('hidden');
            });
        });

        // document.getElementById('confirmCourse').addEventListener('click', function () {
        //     var button = this;
        //     var coursDiv = document.getElementById('cours');

        //     if (coursDiv.classList.contains('finished')) {
        //         // Afficher le div du cours
        //         coursDiv.classList.remove('finished'); // Afficher le div
        //         button.textContent = 'Annuler la confirmation'; // Changer le texte du bouton
        //     } else {
        //         // Cacher le div du cours
        //         coursDiv.classList.add('finished'); // Cacher le div
        //         button.textContent = 'Marquer le cours comme terminé'; // Réinitialiser le texte du bouton
        //     }
        // });
    </script>
    <script src="../js/script.js"></script>
</body>

</html>