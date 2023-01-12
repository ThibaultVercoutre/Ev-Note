<?php
require_once '../php/login.php';
$clave1 = $_POST['clave1'];
$clave2 = $_POST['clave2'];
$clave3 = $_POST['clave3'];


/*=======================================================================================================*/
/*========================================= Recherche la photo d'un lieu ================================*/

  //Reupération des données pour les avis d'un lieu
  // Préparation de la requête SQL
  $sql = "SELECT Chemin FROM photo_eta WHERE id_p_eta = (SELECT id_p_eta FROM lieu WHERE Adresse = ?)";
  $stmt = $bdd->prepare($sql);

  // Exécution de la requête
  $stmt->execute([$clave2]);

  // Récupération des résultats
  $resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

  // Conversion des résultats en tableau JavaScript
  $img_lieu = json_encode($resultats);

  // Envoi du tableau JavaScript au client
  //echo "<script>var mes_clients = ". $img_lieu .";</script>";


/*=======================================================================================================*/
/*========================================= Recherche des avis du lieu ================================*/

  $sql = "SELECT Avis 
          FROM avis
          WHERE id_lieu = (SELECT id_lieu
                            FROM lieu 
                            WHERE Adresse = ?)";

  $stmt = $bdd->prepare($sql);

  $stmt->execute([$clave2]);

  $resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

  $avis = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Recherche des commenteurs ===================================*/

  $sql = "SELECT utilisateur.Prenom
          FROM utilisateur
          JOIN avis ON avis.id_user = utilisateur.id_user
          JOIN lieu ON lieu.id_lieu = avis.id_lieu
          WHERE lieu.Adresse = ?";

  $stmt = $bdd->prepare($sql);

  $stmt->execute([$clave2]);

  $resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

  $noms = $resultats;

/*=======================================================================================================*/
/*========================================= Recherche des commenteurs ===================================*/

$sql = "SELECT utilisateur.id_user
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$id_noms = $resultats;

/*=======================================================================================================*/
/*========================================= Verification du compte ======================================*/

$sql = "SELECT utilisateur.TypeCompte
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$type = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Image user ==================================================*/

$sql = "SELECT photo_user.chemin
        FROM utilisateur
        JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$img_user = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= N avis ======================================================*/

$sql = "SELECT id_avis
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_avis = $resultats;

$sql = "SELECT Adresse
        FROM lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_adresse = $resultats;

/*=======================================================================================================*/
/*========================================= N pouce up ==================================================*/

$sql = "SELECT CptPouceBleu
        FROM avis
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_up = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= N pouce down ================================================*/

$sql = "SELECT CptPouceRouge
        FROM avis
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_down = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= N pouce report ==============================================*/

$sql = "SELECT CptReport
        FROM avis
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_report = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Note avis lieu ==============================================*/

$sql = "SELECT CptEtoile
        FROM avis
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ?";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$note = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Like avis bool ==============================================*/

$sql = "SELECT avis.id_avis
        FROM likes_avis 
        JOIN avis ON avis.id_avis = likes_avis.id_avis 
        JOIN lieu ON lieu.id_lieu = avis.id_lieu 
        WHERE lieu.Adresse = ? AND likes_avis.id_user = '".$clave3."' AND likes_avis.like_bool = '1'";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$like_bool = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= DisLike avis bool ===========================================*/

$sql = "SELECT avis.id_avis
        FROM dislikes_avis 
        JOIN avis ON avis.id_avis = dislikes_avis.id_avis 
        JOIN lieu ON lieu.id_lieu = avis.id_lieu 
        WHERE lieu.Adresse = ? AND dislikes_avis.id_user = '".$clave3."' AND dislikes_avis.dislike_bool = '1'";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$dislike_bool = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Report avis bool ============================================*/

$sql = "SELECT avis.id_avis
        FROM reports_avis
        JOIN avis ON avis.id_avis = reports_avis.id_avis 
        JOIN lieu ON lieu.id_lieu = avis.id_lieu 
        WHERE lieu.Adresse = ? AND reports_avis.id_user = '".$clave3."' AND reports_avis.report_bool = '1'";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave2]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$report_bool = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Verif User Avis =============================================*/

$sql = "SELECT count(*)
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user 
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = ? AND avis.id_user = '".$clave2."'";

$stmt = $bdd->prepare($sql);

$stmt->execute([$clave3]);

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$nb_avis_user = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Verif User Avis =============================================*/

$sql = "SELECT TypeCompte
        FROM utilisateur
        WHERE id_user = '$clave2'";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$dev = json_encode($resultats);

switch ($clave1) {
    case '0': echo $img_lieu; break;
    case '1': echo json_encode([$noms, $id_noms]); break;
    case '2': echo $type; break;
    case '4': echo $avis; break;
    case '5': echo $img_user; break;
    case '6': echo json_encode([$n_avis, $clave2, $n_adresse]); break;
    case '7': echo $n_up; break;
    case '8': echo $n_down; break;
    case '9': echo $n_down; break;
    case '10': echo $note; break;
    case '11': echo $like_bool; break;
    case '12': echo $dislike_bool; break;
    case '13': echo $report_bool; break;
    case '14': echo $nb_avis_user; break;
    case '15': echo $dev; break;
}
?>