<?php 
    require_once 'login.php'; // On inclut la connexion à la bdd
    session_start();
    if(($_SESSION['email']) !== ""){
        $email = $_SESSION['email'];
        $reponse = $bdd->query('SELECT NumEtu, Nom, Prenom, Mail, Picture FROM user WHERE Mail="'.$email.'"');
        $donnees = $reponse->fetch();
      
    }
    date_default_timezone_set('Europe/Paris');
    // Si les variables existent et qu'elles ne sont pas vides
    if(isset($_POST['NomEvent']) && isset($_POST['Adresse']) && isset($_POST['Ville']) && isset($_POST['CP']) && isset($_POST['IMG']) && isset($_POST['Annonce']))
    {

        // Patch XSS
        //$nom = htmlspecialchars($_POST['Nom']);
        //$prenom = htmlspecialchars($_POST['Prenom']);
        //$mail = htmlspecialchars($_POST['Mail']);
        $numetu = $donnees['NumEtu'];
        $nomevent = htmlspecialchars($_POST['NomEvent']);
        $lieu = htmlspecialchars($_POST['Adresse']);
        $ville = htmlspecialchars($_POST['Ville']);
        $cp = htmlspecialchars($_POST['CP']);
        $img = htmlspecialchars($_POST['IMG']);
        $annonce = htmlspecialchars($_POST['Annonce']);
        $date = date("y-m-d H:i:s");
              // On insère dans la base de données
        $insert = $bdd->prepare('INSERT INTO testpost(NumEtu, NomEvent, Adresse, Ville, CP, IMG, Annonce, DateCreation) VALUES(:NumEtu, :NomEvent, :Adresse, :Ville, :CP, :IMG, :Annonce, :DateCreation)');
        $insert->execute(array(
            'NumEtu' => $numetu,
            'NomEvent' => $nomevent,
            'Adresse' => $lieu,
            'Ville' => $ville,
            'CP' => $cp,
            'IMG' => $img,
            'Annonce' => $annonce,
            'DateCreation' => $date,
            ));
                            // On redirige avec le message de succès
        header('Location:../../principale.php?reg_err=success');
        die();
    }

?>