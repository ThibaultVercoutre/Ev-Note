<?php 
    require_once 'login.php'; // On inclut la connexion à la bdd

    // Si les variables existent et qu'elles ne sont pas vides
    if(isset($_POST['Nom']) && isset($_POST['Prenom']) && isset($_POST['Mail']) && isset($_POST['NomEvent']) && isset($_POST['Adresse']) && isset($_POST['Ville']) && isset($_POST['CP']) && isset($_POST['IMG']) && isset($_POST['Annonce']))
    {

        // Patch XSS
        $nom = htmlspecialchars($_POST['Nom']);
        $prenom = htmlspecialchars($_POST['Prenom']);
        $mail = htmlspecialchars($_POST['Mail']);
        $nomevent = htmlspecialchars($_POST['NomEvent']);
        $lieu = htmlspecialchars($_POST['Adresse']);
        $ville = htmlspecialchars($_POST['Ville']);
        $cp = htmlspecialchars($_POST['CP']);
        $img = htmlspecialchars($_POST['IMG']);
        $annonce = htmlspecialchars($_POST['Annonce']);
              // On insère dans la base de données
        $insert = $bdd->prepare('INSERT INTO post(Nom, Prenom, Mail, NomEvent, Adresse, Ville, CP, IMG, Annonce) VALUES(:Nom, :Prenom, :Mail, :NomEvent, :Adresse, :Ville, :CP, :IMG, :Annonce)');
        $insert->execute(array(
            'Nom' => $nom,
            'Prenom' => $prenom,
            'Mail' => $mail,
            'NomEvent' => $nomevent,
            'Adresse' => $lieu,
            'Ville' => $ville,
            'CP' => $cp,
            'IMG' => $img,
            'Annonce' => $annonce,
            ));
                            // On redirige avec le message de succès
        header('Location:../../index.html?reg_err=success');
        die();
    }
    echo "Bonjour";

?>