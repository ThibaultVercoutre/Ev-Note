<?php
require_once '../php/login.php';
$clave1 = $_POST['clave1'];
$clave2 = $_POST['clave2'];

/*=======================================================================================================*/
/*========================================= N avis ======================================================*/

$sql = "SELECT id_forum FROM form_fil ";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_article = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= N avis filtre ===============================================*/

$sql = "SELECT COUNT(*)
        FROM utilisateur
        JOIN form_fil ON form_fil.id_user = utilisateur.id_user
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_article_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Prenom filtre ===============================================*/

$sql = "SELECT utilisateur.Prenom
        FROM utilisateur
        JOIN form_fil ON form_fil.id_user = utilisateur.id_user
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$nom_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Prenom sans filtre ==========================================*/

$sql = "SELECT utilisateur.Prenom
        FROM utilisateur
        JOIN form_fil ON form_fil.id_user = utilisateur.id_user";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$nom = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Date filtre =================================================*/

$sql = "SELECT DateCreation
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$date_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Date sans filtre ============================================*/

$sql = "SELECT DateCreation
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$date = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= PP filtre =================================================*/

$sql = "SELECT photo_user.chemin
        FROM utilisateur
        JOIN form_fil ON form_fil.id_user = utilisateur.id_user
        JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$pp_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= PP ==========================================================*/

$sql = "SELECT photo_user.chemin
        FROM utilisateur
        JOIN form_fil ON form_fil.id_user = utilisateur.id_user
        JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$pp = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Titre filtre ================================================*/

$sql = "SELECT NomEvent
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Titre_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Titre =======================================================*/

$sql = "SELECT NomEvent
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Titre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Annonce filtre ==============================================*/

$sql = "SELECT Annonce
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Annonce_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Annonce =====================================================*/

$sql = "SELECT Annonce
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Annonce = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Photo Post Filtre ===========================================*/

$sql = "SELECT image_event.Chemin
        FROM image_event
        JOIN form_fil ON form_fil.id_image_event = image_event.id_image_event
        WHERE form_fil.TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Photo_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Photo Post ==================================================*/

$sql = "SELECT image_event.Chemin
        FROM image_event
        JOIN form_fil ON form_fil.id_image_event = image_event.id_image_event";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Photo = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Fond Post ===================================================*/

$sql = "SELECT image_event.Chemin
        FROM image_event
        JOIN form_fil ON form_fil.id_image_event = image_event.id_image_event AND image_event.id_image_event = ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Fond = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Like Post Filtre ============================================*/

$sql = "SELECT CptPouceBleu
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Bleu_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Like Post ===================================================*/

$sql = "SELECT CptPouceBleu
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Bleu = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Report Post Filtre ==========================================*/

$sql = "SELECT CptReport
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Report_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Report Post =================================================*/

$sql = "SELECT CptReport
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Report = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Dislike Post =================================================*/

$sql = "SELECT CptPouceRouge
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Dislike = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Dislike Post Filtre =================================================*/

$sql = "SELECT CptPouceRouge
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Dislike_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Lieu Filtre =================================================*/

$sql = "SELECT Ville
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Lieu_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Lieu Post Filtre =================================================*/

$sql = "SELECT Ville
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Lieu = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Adresse Filtre =================================================*/

$sql = "SELECT Adresse
        FROM form_fil
        WHERE TypeEvenement IN ($clave2)";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Adresse_filtre = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Adresse Post Filtre =================================================*/

$sql = "SELECT Adresse
        FROM form_fil";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$Adresse = json_encode($resultats);

switch ($clave1) {
    case '0':
        echo $n_article;
        break;
    case '1':
        echo $n_article_filtre;
        break;
    case '2':
        echo $nom_filtre;
        break;
    case '3':
        echo $nom;
        break;
    case '4':
        echo $date_filtre;
        break;
    case '5':
        echo $date;
        break;
    case '6':
        echo $pp_filtre;
        break;
    case '7':
        echo $pp;
        break;
    case '8':
        echo $Titre_filtre;
        break;
    case '9':
        echo $Titre;
        break;
    case '10':
        echo $Annonce_filtre;
        break;
    case '11':
        echo $Annonce;
        break;
    case '12':
        echo $Photo_filtre;
        break;
    case '13':
        echo $Photo;
        break;
    case '14':
        echo $Bleu_filtre;
        break;
    case '15':
        echo $Bleu;
        break;
    case '16':
        echo $Report_filtre;
        break;
    case '17':
        echo $Report;
        break;
    case '18':
        echo $Dislike_filtre;
        break;  
    case '19':
        echo $Dislike;
        break;       
    case '20':
        echo $Lieu_filtre;
        break; 
    case '21':
        echo $Lieu;
        break; 
    case '22':
        echo $Adresse_filtre;
        break; 
    case '23':
        echo $Adresse;
        break;
}


?>