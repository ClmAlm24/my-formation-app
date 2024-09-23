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
// require './profil.php';

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
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/tw-elements@latest/dist/index.min.js"></script>
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body class="bg-lightGray text-darkGray">
    <div class="container ">
        <header
            class="flex shadow-md py-4 px-4 bg-lightAccent font-[sans-serif] min-h-[70px] tracking-wide relative z-50">
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

        <!-- Section de profil -->
        <!-- <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Profil de l'utilisateur</h2>
            <div class="bg-white p-6 shadow-md rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Nom: <span id="userName">Doe</span></h3>
                <h3 class="text-xl font-bold mb-2">Prénom: <span id="userFirstName">John</span></h3>
            </div>
            <div class="font-sans p-4">
                <ul class="flex">
                    <li id="scoresTab"
                        class="tab text-blue-600 font-bold text-base text-center bg-gray-50 py-3 px-6 border-b-2 border-blue-600 cursor-pointer transition-all">
                        Scores
                    </li>
                    <li id="completedCoursesTab"
                        class="tab text-gray-600 font-semibold text-base text-center hover:bg-gray-50 py-3 px-6 border-b-2 cursor-pointer transition-all">
                        Cours Terminés
                    </li>
                    <li id="completedChallengesTab"
                        class="tab text-gray-600 font-semibold text-base text-center hover:bg-gray-50 py-3 px-6 border-b-2 cursor-pointer transition-all">
                        Challenges Terminés
                    </li>
                    <li id="additionalInfoTab"
                        class="tab text-gray-600 font-semibold text-base text-center hover:bg-gray-50 py-3 px-6 border-b-2 cursor-pointer transition-all">
                        Autres Informations
                    </li>
                </ul>

                <div id="scoresContent" class="tab-content max-w-2xl block mt-8">
                    <h4 class="text-lg font-bold text-gray-600">Scores</h4>
                    <p class="text-sm text-gray-600 mt-4">Voici vos scores pour les différents cours et défis auxquels
                        vous avez participé.</p>
                    <ul class="list-disc list-inside mt-4">
                        <li>Course 1: 85%</li>
                        <li>Challenge 1: 90%</li>
                    </ul>
                </div>
                <div id="completedCoursesContent" class="tab-content max-w-2xl hidden mt-8">
                    <h4 class="text-lg font-bold text-gray-600">Cours Terminés</h4>
                    <p class="text-sm text-gray-600 mt-4">Voici la liste des cours que vous avez terminés avec succès.
                    </p>
                    <ul class="list-disc list-inside mt-4">
                        <li>Course 1</li>
                        <li>Course 2</li>
                    </ul>
                </div>
                <div id="completedChallengesContent" class="tab-content max-w-2xl hidden mt-8">
                    <h4 class="text-lg font-bold text-gray-600">Challenges Terminés</h4>
                    <p class="text-sm text-gray-600 mt-4">Voici les défis que vous avez complétés avec succès.</p>
                    <ul class="list-disc list-inside mt-4">
                        <li>Challenge 1</li>
                        <li>Challenge 2</li>
                    </ul>
                </div>
                <div id="additionalInfoContent" class="tab-content max-w-2xl hidden mt-8">
                    <h4 class="text-lg font-bold text-gray-600">Autres Informations</h4>
                    <p class="text-sm text-gray-600 mt-4">Vous pouvez inclure ici d'autres informations pertinentes sur
                        l'utilisateur.</p>
                </div>
            </div>

        </div> -->
        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Profil de l'utilisateur</h2>
            <div class="bg-white p-6 shadow-md rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Pseudo: <span id="userPseudo"></span></h3>
                <h3 class="text-xl font-bold mb-2">Email: <span id="userEmail"></span></h3>
                <h3 class="text-xl font-bold mb-2">Date d'inscription: <span id="userInscription"></span></h3>
            </div>
            <div class="font-sans p-4">
                <ul class="flex">
                    <li id="scoresTab"
                        class="tab text-blue-600 font-bold text-base text-center bg-gray-50 py-3 px-6 border-b-2 border-blue-600 cursor-pointer transition-all">
                        Scores</li>
                    <li id="completedCoursesTab"
                        class="tab text-gray-600 font-semibold text-base text-center hover:bg-gray-50 py-3 px-6 border-b-2 cursor-pointer transition-all">
                        Cours Terminés</li>
                    <li id="completedChallengesTab"
                        class="tab text-gray-600 font-semibold text-base text-center hover:bg-gray-50 py-3 px-6 border-b-2 cursor-pointer transition-all">
                        Challenges Terminés</li>
                    <li id="additionalInfoTab"
                        class="tab text-gray-600 font-semibold text-base text-center hover:bg-gray-50 py-3 px-6 border-b-2 cursor-pointer transition-all">
                        Autres Informations</li>
                </ul>

                <div id="scoresContent" class="tab-content max-w-2xl block mt-8"></div>
                <div id="completedCoursesContent" class="tab-content max-w-2xl hidden mt-8"></div>
                <div id="completedChallengesContent" class="tab-content max-w-2xl hidden mt-8"></div>
                <div id="additionalInfoContent" class="tab-content max-w-2xl hidden mt-8"></div>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let tabs = document.querySelectorAll('.tab');
            let contents = document.querySelectorAll('.tab-content');

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function (e) {
                    let targetId = tab.id.replace('Tab', 'Content');

                    // Hide all content divs
                    contents.forEach(function (content) {
                        content.classList.add('hidden');
                    });

                    // Remove active class from all tabs
                    tabs.forEach(function (tab) {
                        tab.classList.remove('text-blue-600', 'font-bold', 'bg-gray-50', 'border-blue-600');
                        tab.classList.add('text-gray-600', 'font-semibold');
                    });

                    // Show the target content
                    document.getElementById(targetId).classList.remove('hidden');

                    // Add active class to the clicked tab
                    tab.classList.add('text-blue-600', 'font-bold', 'bg-gray-50', 'border-blue-600');
                    tab.classList.remove('text-gray-600', 'font-semibold');
                });
            });
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function loadProfileData() {
                fetch('profil.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error(data.error);
                            return;
                        }

                        // Mise à jour des informations de l'utilisateur
                        document.getElementById('userPseudo').textContent = data.pseudo;
                        document.getElementById('userEmail').textContent = data.email;
                        document.getElementById('userInscription').textContent = data.dateInscription;

                        // Fonction pour remplir le contenu des onglets
                        function fillTabContent(elementId, data, titleText) {
                            const element = document.getElementById(elementId);
                            let content = `<h4 class="text-lg font-bold text-gray-600">${titleText}</h4>`;

                            if (Array.isArray(data)) {
                                content += '<ul class="list-disc list-inside mt-4">';
                                data.forEach(item => {
                                    content += `<li>${item.nom || item} ${item.titre ? '- ' + item.titre : ''} ${item.description ? '- ' + item.description : ''}</li>`;
                                });
                                content += '</ul>';
                            } else if (typeof data === 'object') {
                                content += '<ul class="list-disc list-inside mt-4">';
                                for (const [key, value] of Object.entries(data)) {
                                    content += `<li>${key}: ${value}</li>`;
                                }
                                content += '</ul>';
                            }

                            element.innerHTML = content;
                        }

                        // Remplissage des contenus des onglets
                        fillTabContent('scoresContent', data.scores, 'Scores');
                        fillTabContent('completedCoursesContent', data.completedCourses, 'Cours Terminés');
                        fillTabContent('completedChallengesContent', data.completedChallenges, 'Challenges Terminés');
                        fillTabContent('additionalInfoContent', data.availableVulnerabilities, 'Vulnérabilités disponibles');
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Chargement des données du profil au chargement de la page
            loadProfileData();

        });
    </script>
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