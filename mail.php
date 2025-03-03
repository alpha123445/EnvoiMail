<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once "vendor/autoload.php";

    $debug = true;

    if(isset($_POST["envoyer"])){
        $nom = $_POST["nom"];
        $email = $_POST["email"];

        
        if (empty($nom) || empty($email)) {
            echo "Veuillez remplir tous les champs.";
            exit;
        }

        try {
            $mail = new PHPMailer($debug);

            /*if ($debug) {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            }*/
        
            // Authentification via SMTP
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            // Connexion
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->Username = "tonemail"; 
            $mail->Password = "tonpassword"; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->setFrom('tonemail', 'tonnom');
            $mail->addAddress($email, $nom); 
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre inscription';
            $mail->Body = 'Bonjour ' . $nom . ', <br><br> Merci de vous être inscrit sur notre site. <br><br> Cordialement, <br>f';
            $mail->AltBody = 'Ceci est un email de test avec PHPMailer';

            if ($mail->send()) {
                echo "L'email a été envoyé avec succès.";
            } else {
                echo "L'email n'a pas pu être envoyé. Erreur: " . $mail->ErrorInfo;
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: " . $e->getMessage();
        }
    }
?>
