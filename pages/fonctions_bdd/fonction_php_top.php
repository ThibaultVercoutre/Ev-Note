<?php
require_once '../php/login.php';
$type = $_POST['type'];
$id_lieu = $_POST['id_lieu'];

/* liste Adresse Avis */

$sql = "SELECT lieu.Adresse
        FROM lieu
        JOIN avis ON avis.id_lieu = lieu.id_lieu
        GROUP BY lieu.Adresse
        ORDER BY AVG(CptEtoile) DESC";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$lieux = $resultats;

/* liste Notes Avis */

$sql = "SELECT AVG(CptEtoile)
        FROM lieu
        JOIN avis ON avis.id_lieu = lieu.id_lieu
        GROUP BY lieu.Adresse
        ORDER BY AVG(CptEtoile) DESC";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$lieux_note = $resultats;

/* liste Image Avis */

$sql = "SELECT photo_eta.Chemin
        FROM photo_eta
        JOIN lieu ON lieu.id_p_eta = photo_eta.id_p_eta
        JOIN avis ON avis.id_lieu = lieu.id_lieu
        GROUP BY photo_eta.Chemin
        ORDER BY AVG(CptEtoile) DESC";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$lieux_photo = $resultats;

/* liste Id Avis */

$sql = "SELECT lieu.id_lieu
        FROM lieu
        JOIN avis ON avis.id_lieu = lieu.id_lieu
        GROUP BY lieu.Adresse
        ORDER BY AVG(CptEtoile) DESC";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$id_lieux = $resultats;

/* Lieu Clique */

$sql = "SELECT Adresse
        FROM lieu
        WHERE id_lieu = ?";

$stmt = $bdd->prepare($sql);
$stmt->execute([$id_lieu]);
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$Nom_lieu = $resultats;

/* Ville clique */

$sql = "SELECT Ville
        FROM lieu
        WHERE id_lieu = ?";

$stmt = $bdd->prepare($sql);
$stmt->execute([$id_lieu]);
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$Ville_lieu = $resultats;

switch($type){
    case '0': echo(json_encode([$lieux, $lieux_note, $lieux_photo, $id_lieux])); break;
    case '1': echo(json_encode([$Nom_lieu[0], $Ville_lieu[0]])); break;
}

?>