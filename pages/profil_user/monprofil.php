<?php
//Enlever toutes les erreurs PHP car requete false possible
$bdd = mysqli_connect("localhost", "root", "", "projet");// On inclut la connexion à la bdd
session_start();
  if(($_SESSION['email']) !== ""){
    $email = $_SESSION['email'];
    //Requetes pour voir les likes/dislikes/reports de l'utilisateur connecté
    //Requete pour like post
    $user = $bdd->query('SELECT * FROM utilisateur WHERE Mail = "'.$email.'"');
    $user = mysqli_fetch_assoc($user);
    $id_user = $user['id_user'];
    $sql = $bdd->query('SELECT *
                    FROM likes_post
                    JOIN form_fil ON form_fil.id_forum = likes_post.id_forum
                    JOIN utilisateur ON utilisateur.id_user = form_fil.id_user
                    JOIN image_event ON image_event.id_image_event = form_fil.id_image_event
                    JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
                    WHERE likes_post.like_bool = 1 AND likes_post.id_user = "'.$id_user.'"');
    //Requete pour dislike post
    $sql1 = $bdd->query('SELECT *
                    FROM dislike_post
                    JOIN form_fil ON form_fil.id_forum = dislike_post.id_forum
                    JOIN utilisateur ON utilisateur.id_user = form_fil.id_user
                    JOIN image_event ON image_event.id_image_event = form_fil.id_image_event
                    JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
                    WHERE dislike_post.dislike_bool = 1 AND dislike_post.id_user = "'.$id_user.'"');
    //Requete pour report post
    $sql2 = $bdd->query('SELECT *
                    FROM reports_post
                    JOIN form_fil ON form_fil.id_forum = reports_post.id_forum
                    JOIN utilisateur ON utilisateur.id_user = form_fil.id_user
                    JOIN image_event ON image_event.id_image_event = form_fil.id_image_event
                    JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
                    WHERE reports_post.report_bool = 1 AND reports_post.id_user = "'.$id_user.'"');
    $table_inner = $bdd->query("SELECT * FROM form_fil INNER JOIN utilisateur ON form_fil.id_user = utilisateur.id_user INNER JOIN photo_user ON utilisateur.id_image_user = photo_user.id_image_user INNER JOIN image_event ON form_fil.id_image_event = image_event.id_image_event ORDER BY form_fil.DateCreation DESC;");
    $user = $bdd->query('SELECT * FROM utilisateur INNER JOIN photo_user ON utilisateur.id_image_user = photo_user.id_image_user WHERE Mail = "'.$email.'"');
    $donnees_user = mysqli_fetch_assoc($user);
    $cpt_row = mysqli_num_rows($sql);
    $sql_admin = $bdd->query('SELECT *
                        FROM reports_post
                        JOIN form_fil ON form_fil.id_forum = reports_post.id_forum
                        JOIN utilisateur ON utilisateur.id_user = form_fil.id_user
                        JOIN image_event ON image_event.id_image_event = form_fil.id_image_event
                        JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
                        WHERE reports_post.report_bool = 1');
     $cpt_signale = mysqli_num_rows($sql_admin);
    
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
            $sql5 = "UPDATE utilisateur SET MotDePasse ='$confirm_password' WHERE id_user ='$id_user'";
            if ($bdd->query($sql5) === TRUE) {
              echo "Mot de passe changé !";
            } else {
              echo "Erreur de changement de mot de passe : " . $bdd->error;
            }
            
        } else header('Location:monprofil.php?mdp_err=dont_match');
    } else header('Location:monprofil.php?mdp_err=invalid_password');
  }
  if (isset($_POST['supprimer'])){
    $id_user = $donnees_user['id_user'];
    $query = "DELETE FROM utilisateur WHERE id_user='$id_user'";
    $query2 ="DELETE FROM form_fil WHERE id_user='$id_user'"; 
    mysqli_query($bdd, $query);
    mysqli_query($bdd, $query2);
    session_destroy();
    header('Location:../../index.php');
  }
  if (isset($_POST['supprimer_post'])) {
    $id_forum = $_POST['supprimer_post'];
    $query = "DELETE FROM form_fil WHERE id_forum = ?";
    $stmt = $bdd->prepare($query);
    $stmt->bind_param("i", $id_forum);
    $stmt->execute();
  
  }
    
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="styleprofil.css" rel="stylesheet" media="screen" type="text/css">
  <link rel="shortcut icon" href="../../img/favicon-32x32.png" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
  <header>
    <div id="titre">
      <a id="home" href="javascript:history.go(-1)" style="text-decoration: none;">
      <div id="effecten">
        <h1 data-text="Ev'Note" id="evnote">Ev'Note</h1>
        <div id = "gradient" class="gradient"></div>
        <div class="spotlight"></div>
      </div>
      </a>
      <span id="time-animation" class=""></span>
      <div id="time">Mon profil</div>
    </div>
  </header>

  <div id="verif_suppr">
    <p>Recopiez la suite de caractères suivante pour valider la suppression :</p>
    <p id="suite_carac"></p>
    <input type="text" id="champ_verif">
  </div>
  <div id="contenu">
    <h2 id="user" data="<?php echo $donnees_user['id_user']?>"></h2>
    <hr>
    <img src="<?php echo $donnees_user['chemin'];?>" class="photo_profil">
    <p>Nom : <?php echo $donnees_user['Nom']; ?></p>
    <p>Prénom : <?php echo $donnees_user['Prenom']; ?></p>
    <p>Adresse mail : <?php echo $donnees_user['Mail']; ?></p>
    
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

    <div id="sectionAdmin">
      <p>En tant que développeur, vous pouvez supprimer les avis signalés</p>
      <div class="bouton_avis_signalés">Voir tout les avis signalés</div>
      <div id="section-report" class="section2"></div>

      <p>Vous pouvez aussi valider les nouveaux lieux</p>
      <div class="bouton_nouveau_lieu">Voir les nouveaux lieux créés</div>
      <div id="section-nouveau-lieu" class="section3"></div>
    </div>
    <hr/>

    
    <div id="choix_post_like_dislike_report">
      <form id="like-form" action="monprofil.php" method="POST">
      <input type="hidden" name="like" value="1">
      <input type="submit" class="bouton_post" value="Posts likés">
      </form>
      <form id="dislike-form" action="monprofil.php" method="POST">
      <input type="hidden" name="dislike" value="1">
      <input type="submit" class="bouton_post" value="Posts dislikés">
      </form>
      <form id="report-form" action="monprofil.php" method="POST">
      <input type="hidden" name="report" value="1">
      <input type="submit" class="bouton_post" value="Posts signalés">
      </form>
    </div>
    <main>
    <div class="slideshow-container" id="slideshow-container">
              <?php 
                if (isset($_POST['like'])){
                  if ($sql == false) {
                    ?>
                    <div id="article-img-wrap"><?php echo "Aucun post like"; ?></div><?php
                  }
                  $cpt_row = mysqli_num_rows($sql);
                  if ($cpt_row > 0){
                    $sql = $bdd->query('SELECT *
                    FROM likes_post
                    JOIN form_fil ON form_fil.id_forum = likes_post.id_forum
                    JOIN utilisateur ON utilisateur.id_user = form_fil.id_user
                    JOIN image_event ON image_event.id_image_event = form_fil.id_image_event
                    JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
                    WHERE likes_post.like_bool = 1 AND likes_post.id_user = "'.$id_user.'"');
                  } 
                }
                else if (isset($_POST['dislike'])){
                  if ($sql1 == false) {
                    ?>
                    <div id="article-img-wrap"><?php echo "Aucun post dislike"; ?></div><?php
                  }
                  $cpt_row = mysqli_num_rows($sql1);
                  if ($cpt_row > 0){
                    $sql = $bdd->query('SELECT *
                    FROM dislike_post
                    JOIN form_fil ON form_fil.id_forum = dislike_post.id_forum
                    JOIN utilisateur ON utilisateur.id_user = form_fil.id_user
                    JOIN image_event ON image_event.id_image_event = form_fil.id_image_event
                    JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
                    WHERE dislike_post.dislike_bool = 1 AND dislike_post.id_user = "'.$id_user.'"');
                  } 
                }
                else if (isset($_POST['report'])){
                  if ($sql2 == false) {
                    ?>  
                    <div id="article-img-wrap"><?php echo "Aucun post signale"; ?></div>
                    <?php
                  }
                  $cpt_row = mysqli_num_rows($sql2);
                  if ($cpt_row > 0){
                    $sql = $bdd->query('SELECT *
                    FROM reports_post
                    JOIN form_fil ON form_fil.id_forum = reports_post.id_forum
                    JOIN utilisateur ON utilisateur.id_user = form_fil.id_user
                    JOIN image_event ON image_event.id_image_event = form_fil.id_image_event
                    JOIN photo_user ON photo_user.id_image_user = utilisateur.id_image_user
                    WHERE reports_post.report_bool = 1 AND reports_post.id_user = "'.$id_user.'"');
                  } 
                } else {
                  $test = mysqli_fetch_assoc($sql);
                }
                  for($i=0; $i<$cpt_row;$i++){
                    while ($test = mysqli_fetch_assoc($sql)){
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
                    
                    <div class="article-info-counts">
                      <div class="likes">
                        <span class="material-symbols-outlined up like-button" id="like-button">thumb_up</span>
                        <div class="like-count"><?php echo $test['CptPouceBleu'];?></div>
                      </div>
                      <div class="dislikes">
                        <span class="material-symbols-outlined down dislike-button" id="dislike-button">thumb_down</span>
                        <div class="dislike-count"><?php echo $test['CptPouceRouge'];?></div>
                      </div>
                      <div class="report">
                        <span class="material-symbols-outlined report">priority_high</span>
                        <div class="report-count"><?php echo $test['CptReport'];?></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                    }
                  }
              ?>
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
              </div>
            </main>
              </div>
      <div id="sectionAdmin2">
      <hr/>
      <p>En tant que développeur, vous pouvez supprimer les posts signalés</p>
      <main>
        <?php
                  for($i=0; $i<$cpt_signale;$i++){
                    while ($test_admin = mysqli_fetch_assoc($sql_admin)){
                    ?>
                  <div id="Articlesignale">
                    <div class ="article-header">
                      <img src="<?php echo $test_admin['chemin'];?>" class="avatorsignale">
                      <div class="article-header-infosignale">
                        <?php echo $test_admin['Prenom']." ".$test_admin['Nom'];?>
                    <span> <?php echo $test_admin['DateCreation'] ; ?> </span>
                    <span> <?php echo $test_admin['Adresse'] ; ?> </span>
                    <span> <?php echo $test_admin['Ville'] ; ?> </span>
                        
                        <p class="TitreArticle"><br/><b><u><?php echo $test_admin['NomEvent'];?></u></b></p>
                        <p> <?php echo $test_admin['Annonce'] ; ?></p>
                        <img src="../../<?php echo $test_admin['Chemin'];?>" class="article-imgsignale">  
                        <button type="submit" value="<?php echo $test_admin['id_forum']; ?>" name="supprimer_post" id="button_suppr_post" onclick="deletePost(this)">Supprimer le post</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php 
                    }
                  }
                ?>
              </div>
            </main>
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
</form> 
</div>
<form id="suppr" action="monprofil.php" method="post">
<button type="submit" name="supprimer" id="button_suppr">Supprimer mon compte</button>
</form>

<?php
function getUserInfo($email, $bdd) {
  $query = "SELECT * FROM utilisateur WHERE Mail = ?";
  $stmt = $bdd->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user_mail = $result->fetch_assoc();
  $stmt->close();
  return $user_mail;
}
$user_mail = getUserInfo($email, $bdd);
?>
  
<script> 
var user = <?php echo json_encode($user_mail); ?>;
if (user.TypeCompte !== "Developpeur") {
  document.getElementById("sectionAdmin2").style.display = "none";
}

function deletePost(element) {
  var id_forum = element.value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "monprofil.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var parent = element.parentNode.parentNode.parentNode;
      parent.style.display = "none";
    }
  };
  xhr.send("supprimer_post=" + id_forum);
}

</script>
<script src="../../header.js"></script>
<script src="scriptprofil.js"></script>

</body>

</html>

