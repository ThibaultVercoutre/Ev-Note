<?php
require_once '../php/login.php';
$nb = $_POST['nombre'];
$avis = $_POST['avis'];
$type = $_POST['type'];
$user = $_POST['user'];
$bool = $_POST['bool'];

// Ajoute le like dans les postes
$sql = "UPDATE `avis` SET `$type` = $nb WHERE `id_avis` = '$avis'";
$bdd->exec($sql);

// On choisit la bonne table
switch ($type) {
    case 'CptPouceBleu':
        $table = "likes_avis";
        $id = "id_like";
        $id_bool = "like_bool";
        break;
    case 'CptPouceRouge':
        $table = "dislikes_avis";
        $id = "id_dislike";
        $id_bool = "dislike_bool";
        break;
    case 'CptReport':
        $table = "reports_avis";
        $id = "id_report";
        $id_bool = "report_bool";
        break;
}

// On cherche dans la bonne table

$sql = "SELECT count(*)
        FROM `$table`
        WHERE id_user = '$user' AND id_avis = '$avis'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0)[0];
$check = json_encode($resultats);

if($check == '"0"'){
    
    $sql = "SELECT max($id)+1 FROM `$table`";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $nb_avis_max = $stmt->fetchAll(PDO::FETCH_COLUMN, 0)[0];

    $sql = "INSERT INTO `$table`(`$id`, `id_avis`, `id_user`, `$id_bool`) VALUES ('$nb_avis_max','$avis','$user','$bool')";
    $bdd->exec($sql);

    $message = "passé par if";
}else{

    $sql = "UPDATE `$table` SET `$id_bool` = '$bool' WHERE `id_avis` = '$avis' AND `id_user` = '$user'";
    $bdd->exec($sql);
    
    $message = "passé par else";
}

echo(json_encode([$check, $table, $id, $message]));

?>