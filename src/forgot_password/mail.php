<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Inclure le fichier autoload de Composer

function sendResetEmail($to, $subject, $resetLink) {
    $mail = new PHPMailer(true); // Instancier la classe PHPMailer

    try {
        // Configuration du serveur SMTP de Mailtrap
        $mail->isSMTP();
        $mail->Host       = 'smtp.mailtrap.io'; // Serveur SMTP Mailtrap
        $mail->SMTPAuth   = true;
        $mail->Username   = '7d03d7c85a9a49'; // Remplacez par votre nom d'utilisateur Mailtrap
        $mail->Password   = 'a7dccfb58177a8'; // Remplacez par votre mot de passe Mailtrap
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // Port pour SMTP sécurisé

        // Expéditeur et destinataire
        $mail->setFrom('no-reply@yourdomain.com', 'Your App Name'); // Remplacez par votre adresse e-mail et nom d'expéditeur
        $mail->addAddress($to); // Adresse du destinataire

        // Contenu de l'e-mail
        $mail->isHTML(true); // Utiliser le format HTML
        $mail->CharSet = 'UTF-8'; // Spécifier l'encodage UTF-8

        // Créer le message HTML avec du style en ligne
        $mail->Subject = $subject;
        $mail->Body    = '
            <html>
            <head>
                <style>
                    .container { width: 100%; max-width: 600px; margin: auto; padding: 20px; }
                    .header { background-color: #f3f4f6; padding: 10px; text-align: center; }
                    .content { background-color: #ffffff; padding: 20px; border-radius: 8px; }
                    .footer { text-align: center; font-size: 12px; color: #6b7280; margin-top: 20px; }
                    .button { display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #3b82f6; color: #ffffff; text-decoration: none; border-radius: 5px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Réinitialisation de Mot de Passe</h1>
                    </div>
                    <div class="content">
                        <p>Vous avez demandé une réinitialisation de votre mot de passe.</p>
                        <p>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :</p>
                        <a href="' . htmlspecialchars($resetLink) . '" class="button">Réinitialiser le Mot de Passe</a>
                        <p>Ce lien expirera dans 1 heure.</p>
                    </div>
                    <div class="footer">
                        <p>Si vous n\'avez pas demandé cette réinitialisation, veuillez ignorer cet email.</p>
                    </div>
                </div>
            </body>
            </html>
        ';
        $mail->AltBody = strip_tags($mail->Body); // Texte alternatif pour les clients de messagerie qui ne supportent pas HTML

        // Envoyer l'e-mail
        $mail->send();
        echo 'L\'email de réinitialisation a été envoyé.';
    } catch (Exception $e) {
        echo "Erreur d'envoi de l'email. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
