<?php
require_once 'pages/php/login.php';
$etoile = $_POST['etoile'];
$avis = $_POST['avis'];
$lieu = $_POST['lieu'];

$sql = "SELECT id_lieu FROM lieu WHERE Adresse = '$lieu'";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$id_lieu = $stmt->fetchAll(PDO::FETCH_COLUMN, 0)[0];

$sql = "SELECT max(id_avis)+1 FROM `avis`";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$id_avis = $stmt->fetchAll(PDO::FETCH_COLUMN, 0)[0];

// Préparation de la requête SQL
//$sql = "INSERT INTO avis (Avis, CptPouceBleu, CptPouceRouge, CptReport, CptEtoile, id_lieu) VALUES ('$avis', '0', '0', '0', '$etoile', '$resultats')";
$sql = "INSERT INTO `avis` (`id_avis`, `id_user`, `Avis`, `CptPouceBleu`, `CptPouceRouge`, `CptReport`, `CptEtoile`, `id_commentaire_avis`, `id_lieu`) VALUES ('$id_avis','8','$avis','0','0','0','$etoile','6','$id_lieu')";
//$sql = "INSERT INTO `avis` (`id_avis`, `id_user`, `Avis`, `CptPouceBleu`, `CptPouceRouge`, `CptReport`, `CptEtoile`, `id_commentaire_avis`, `id_lieu`) VALUES ('6','4','Coucou','0','0','0','4','6','1')";
$bdd->exec($sql);

echo(json_encode($id_avis));

?>