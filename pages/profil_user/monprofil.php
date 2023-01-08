<?php
$bdd = mysqli_connect("localhost", "root", "", "projet");// On inclut la connexion à la bdd
session_start();
  if(($_SESSION['email']) !== ""){
    $email = $_SESSION['email'];
    $table_inner = $bdd->query('SELECT * FROM form_fil INNER JOIN utilisateur ON form_fil.id_user = utilisateur.id_user INNER JOIN photo_user ON utilisateur.id_image_user = photo_user.id_image_user INNER JOIN image_event ON form_fil.id_image_event = image_event.id_image_event');
    $user = $bdd->query('SELECT * FROM utilisateur INNER JOIN photo_user ON utilisateur.id_image_user = photo_user.id_image_user WHERE Mail = "'.$email.'"');
    $test = mysqli_fetch_assoc($table_inner);
    $donnees_user = mysqli_fetch_assoc($user);
    $cpt_row = mysqli_num_rows($table_inner);
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
    $stmt->close();
    // Vérification de la correspondance du mot de passe actuel
    if ($result == $current_password) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        // Le mot de passe actuel est correct, on peut mettre à jour le mot de passe
        if ($new_password == $confirm_password) {
            $confirm_password = hash('sha256', $confirm_password);
            $sql = "UPDATE utilisateur SET MotDePasse ='$confirm_password' WHERE id_user ='$id_user'";
            if ($bdd->query($sql) === TRUE) {
              echo "Mot de passe changé !";
            } else {
              echo "Erreur de changement de mot de passe : " . $bdd->error;
            }
            
        } else header('Location:monprofil.php?mdp_err=dont_match');
    } else header('Location:monprofil.php?mdp_err=invalid_password');
  }
  $data = $_POST;
  if (isset($_POST['supprimer'])){
    $id_user = $donnees_user['id_user'];
    $query = "DELETE FROM utilisateur WHERE id_user='$id_user'";
    $query2 ="DELETE FROM form_fil WHERE id_user='$id_user'"; 
    mysqli_query($bdd, $query);
    mysqli_query($bdd, $query2);
    session_destroy();
    header('Location:../../index.php');
  }
    
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="styleprofil.css" rel="stylesheet" media="screen" type="text/css">
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
    <h2 id="user" data="<?php echo $donnees_user['id_user']?>">Mon profil</h2>
    <hr>
    <img src="<?php echo $donnees_user['chemin'];?>" class="photo_profil">
    <p>Nom : <?php echo $donnees_user['Nom']; ?></p>
    <p>Prénom : <?php echo $donnees_user['Prenom']; ?></p>
    <p>Adresse mail : <?php echo $donnees_user['Mail']; ?></p>
    <p>Nombre de posts : 0</p> <!-- Faire une table pour enregistrer tous les posts (une sauvegarde) -->
    <div id="choix_like_dislike_report">
      <div class="bouton_avis">Avis likés</div>
      <div class="bouton_avis">Avis dislikés</div>
      <div class="bouton_avis">Avis signalés</div>
    </div>
    <div id="sections">
      <div id="section-avis-like" class="section"></div>
      <div id="section-avis-dislike" class="section"></div>
      <div id="section-avis-report" class="section"></div>
    </div>
    <p>Posts likés : liste des posts depuis bdd sauvegarde</p> 
    <!--Slider des posts likés -->
    <div class="post_like">
      <main>
      <div class="slideshow-container">
        <?php 
        mysqli_data_seek($table_inner, 0);
        for($i=0; $i<$cpt_row;$i++){
          while ($test = mysqli_fetch_assoc($table_inner)){
          ?>
          <div class="mySlides fade">
            <div id="Article">
                <div class ="article-header">
                  <img src="<?php echo $test['chemin'];?>" class="avator">
                    <div class="article-header-info">
                      <?php echo $test['Prenom']." ".$test['Nom']?>
                      <span> <?php echo $test['DateCreation'] ; ?> </span>
                      <p class="TitreArticle"><br/><b><u><?php echo $test['NomEvent'];?></u></b></p>
                      <p> <?php echo $test['Annonce'] ; ?></p>
                    </div>
                </div>
              <div class="article-img-wrap">
              <img src="../../<?php echo $test['Chemin'];?>" class="article-img">
              </div>
            </div>
          </div>
        <?php
          }
        } ?>
                <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>
           <!-- The dots/circles -->
              <div style="text-align:center">
              <?php 
              for($i=1; $i<$cpt_row+1;$i++){ 
                ?>
                <span class="dot" onclick="currentSlide(<?php echo $i ;?>)"></span>
                <?php } ?>
              </div>

            </main>
          </div>
  </div>
<button type="submit" name="change" id="button_mdp">Changer de mot de passe</button>

<div id="menu_mdp">
<form id="formulaire_mdp" action="monprofil.php" method="post" style="display:none;" >
  <label for="current_password">Mot de passe actuel :</label><br>
  <input type="password" id="current_password" name="current_password"><br>
  <label for="new_password">Nouveau mot de passe :</label><br>
  <input type="password" id="new_password" name="new_password"><br>
  <label for="confirm_password">Confirmez le nouveau mot de passe :</label><br>
  <input type="password" id="confirm_password" name="confirm_password"><br>
  <button type="submit" class="change_mdp">Changer de mot de passe</button> 
  <!--<input type="submit" value="Changer de mot de passe">-->
</form> 
</div>
<form id="suppr" action="monprofil.php" method="post">
<button type="submit" name="supprimer" id="button_suppr">Supprimer mon compte</button>
</form>

<script src="scriptprofil.js"></script>

</body>

</html>