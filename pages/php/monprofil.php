<?php
$bdd = mysqli_connect("localhost", "utilisateur", "projetweb2022", "projet");// On inclut la connexion à la bdd
session_start();
  if(($_SESSION['email']) !== ""){
    $email = $_SESSION['email'];
    $table_inner = $bdd->query('SELECT * FROM form_fil INNER JOIN utilisateur ON form_fil.id_user = utilisateur.id_user INNER JOIN photo_user ON utilisateur.id_image_user = photo_user.id_image_user INNER JOIN image_event ON form_fil.id_image_event = image_event.id_image_event WHERE Mail="'.$email.'"');
    $user = $bdd->query('SELECT * FROM utilisateur WHERE Mail = "'.$email.'"');
    $test = mysqli_fetch_assoc($table_inner);
    $donnees_user = mysqli_fetch_assoc($user);
  }
  if(isset($_GET['mdp_err']))
    {
      $err = htmlspecialchars($_GET['mdp_err']);
      switch($err)
        {
          case 'invalid_password':
            ?><div class="incorrect_mdp">
              <p>Mot de passe incorrect</p>
            </div>
          <?php
          break;

          case 'dont_match';
          ?>
            <div class="missmatch_mdp">
              <p>Les deux mots de passe ne correspondent pas</p>
            </div>
          <?php
          break;
        }
    }
  if ((isset($_POST['current_password'])) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    // Récupération des données du formulaire
    $current_password = $_POST['current_password'];
    $current_password = hash('sha256', $current_password);
    $id_user = $donnees_user['id_user'];
    // Récupération du hash du mot de passe actuel de l'utilisateur depuis la base de données
    $query = "SELECT MotDePasse FROM utilisateur WHERE id_user = ?";
    $stmt = mysqli_prepare($bdd, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);
    // Vérification de la correspondance du mot de passe actuel
    if ($result == $current_password) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        // Le mot de passe actuel est correct, on peut mettre à jour le mot de passe
        if ($new_password == $confirm_password) {
            $confirm_password = hash('sha256', $confirm_password);
            $query = "UPDATE utilisateur SET MotDePasse =? WHERE id_user =?";
            $stmt = mysqli_prepare($bdd, $query);
            mysqli_stmt_bind_param($stmt, "si", $confirm_password, $id_user);
            mysqli_stmt_execute($stmt);
            //echo "<script>alert('Mot de passe a été mis à jour');</script>";
            echo "Mot de passe changé !";
        } else header('Location:monprofil.php?mdp_err=dont_match');
    } else header('Location:monprofil.php?mdp_err=invalid_password');
  }
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="../css/styleprofil.css" rel="stylesheet" media="screen" type="text/css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
  <header>
    <div id="titre">
      <h1>Ev'Note</h1>
      <a href="../../principale.php"><span class="material-symbols-outlined">home</span></a>
      
    </div>
  </header>

  <div id="contenu">
    <h2>Mon profil</h2>
    <hr>
    <!-- a changer car donnees dispo que si il a deja poste un post-->
    <img src="<?php echo $test['chemin'];?>" class="photo_profil">
    <p>Nom : <?php echo $test['Nom']; ?></p>
    <p>Prénom : <?php echo $test['Prenom']; ?></p>
    <p>Adresse mail : <?php echo $test['Mail']; ?></p>
    <p>Nombre de posts : 0</p> <!-- Faire une table pour enregistrer tous les posts (une sauvegarde) -->
    <p>Posts likés : liste des posts depuis bdd sauvegarde</p> 
<button type="submit" name="change" id="button_mdp">Changer de mot de passe</button>
  </div>
<div id="menu_mdp">
<form id="formulaire_mdp" action="monprofil.php" method="post" style="display:none;" >
  <label for="current_password">Mot de passe actuel :</label><br>
  <input type="password" id="current_password" name="current_password"><br>
  <label for="new_password">Nouveau mot de passe :</label><br>
  <input type="password" id="new_password" name="new_password"><br>
  <label for="confirm_password">Confirmez le nouveau mot de passe :</label><br>
  <input type="password" id="confirm_password" name="confirm_password"><br>
  <button type="submit1" class="change_mdp">Changer de mot de passe</button> 
  <!--<input type="submit" value="Changer de mot de passe">-->
</form> 
</div>

<script>
  var formulaireAffiche = false;
  document.getElementById("button_mdp").addEventListener("click", function() {
    if (formulaireAffiche) {
      formulaireAffiche = false;
      document.getElementById("formulaire_mdp").style.display = "none";
    } else {
      formulaireAffiche = true;
      document.getElementById("formulaire_mdp").style.display = "block";
    }
  });

</script>
</body>

</html>
<!--Desactiver compte 
<button onclick="confirmDeactivation()">Désactiver mon compte</button>
function confirmDeactivation() {
  if (confirm("Êtes-vous sûr de vouloir désactiver votre compte ?")) {
    // l'utilisateur a cliqué sur "OK", on peut appeler la fonction de désactivation du compte
    deactivateAccount();
  } else {
    // l'utilisateur a cliqué sur "Annuler", on ne fait rien
  }
}
-->
