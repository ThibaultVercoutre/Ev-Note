<?php
require_once 'pages/php/login.php';
$clave1 = $_POST['clave1'];
$clave2 = $_POST['clave2'];


/*=======================================================================================================*/
/*========================================= Recherche la photo d'un lieu ================================*/

  //Reupération des données pour les avis d'un lieu
  // Préparation de la requête SQL
  $sql = "SELECT Chemin FROM photo_eta WHERE id_p_eta = (SELECT id_p_eta FROM lieu WHERE Adresse = '".$clave2."')";
  $stmt = $bdd->prepare($sql);

  // Exécution de la requête
  $stmt->execute();

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
                            WHERE Adresse = '".$clave2."')";

  $stmt = $bdd->prepare($sql);

  $stmt->execute();

  $resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

  $avis = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Recherche des commenteurs ===================================*/

  $sql = "SELECT utilisateur.Prenom
          FROM utilisateur
          JOIN avis ON avis.id_user = utilisateur.id_user
          JOIN lieu ON lieu.id_lieu = avis.id_lieu
          WHERE lieu.Adresse = '".$clave2."'";

  $stmt = $bdd->prepare($sql);

  $stmt->execute();

  $resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

  $noms = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Verification du compte ======================================*/

$sql = "SELECT utilisateur.TypeCompte
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = '".$clave2."'";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$type = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= Verification du compte ======================================*/

$sql = "SELECT photo_user.chemin
        FROM utilisateur
        JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = '".$clave2."'";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$img_user = json_encode($resultats);

/*=======================================================================================================*/
/*========================================= N avis ======================================================*/

$sql = "SELECT count(user.Prenom)
        FROM utilisateur
        JOIN avis ON avis.id_user = utilisateur.id_user
        JOIN lieu ON lieu.id_lieu = avis.id_lieu
        WHERE lieu.Adresse = '".$clave2."'";

$stmt = $bdd->prepare($sql);

$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$n_avis = json_encode($resultats);

switch ($clave1) {
  case '0':
      echo $img_lieu;
      break;
  case '1':
      echo $noms;
      break;
  case '2':
      echo $type;
      break;
  case '4':
      echo $avis;
      break;
  case '5':
      echo $img_user;
      break;
  case '6':
      echo $n_avis;
      break;
}

?>