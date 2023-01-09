<?php
require_once '../php/login.php';
$nb = $_POST['nombre'];
$post = $_POST['actu'];
$type = $_POST['type'];
$user = $_POST['user'];
$bool = $_POST['bool'];

// Ajoute le like dans les postes
$sql = "UPDATE `form_fil` SET `$type` = $nb WHERE `id_forum` = '$post'";
$bdd->exec($sql);

// On choisit la bonne table
switch ($type) {
    case 'CptPouceBleu':
        $table = "likes_post";
        $id = "id_like";
        $id_bool = "like_bool";
        break;
    case 'CptPouceRouge':
        $table = "dislike_post";
        $id = "id_dislike";
        $id_bool = "dislike_bool";
        break;
    case 'CptReport':
        $table = "reports_post";
        $id = "id_report";
        $id_bool = "report_bool";
        break;
}

// On cherche dans la bonne table

$sql = "SELECT count(*)
        FROM `$table`
        WHERE id_user = '$user' AND id_forum = '$post'";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0)[0];
$check = json_encode($resultats);

//echo($check);

if($check == '"0"'){
    
    $sql = "SELECT max($id)+1 FROM `$table`";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $nb_avis_max = $stmt->fetchAll(PDO::FETCH_COLUMN, 0)[0];

    if($nb_avis_max == ''){
        $nb_avis_max = 1;
    }

    $sql = "INSERT INTO `$table`(`$id`, `id_forum`, `id_user`, `$id_bool`) VALUES ('$nb_avis_max','$post','$user','$bool')";
    $bdd->exec($sql);

    $message = "passé par if";
}else{

    $sql = "UPDATE `$table` SET `$id_bool` = '$bool' WHERE `id_forum` = '$post' AND `id_user` = '$user'";
    $bdd->exec($sql);
    
    $message = "passé par else";
}

//echo(json_encode($nb_avis_max));
echo(json_encode([$id_bool, $table, $id]));

?>