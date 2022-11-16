<?php
  $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','root', '');
  if(isset($_POST['valider'])){
    $name => $_FILES["image"]["name"];
    $type => $_FILES["image"]["type"];
    $data => file_get_contents($_FILES["image"]["tmp_name"]);
    $insert=$bdd->prepare('INSERT INTO myblob VALUES ('',?,?,?)');
    $insert->bindParam(1, $name);
    $insert->bindParam(2, $type);
    $insert->bindParam(3, $data);
    $insert->execute();
  }
?>

<html>
<!--peut etre un fichier html, pas besoin php-->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="../css/styleconnexion.css" rel="stylesheet" media="screen" type="text/css">
</head>

<body>
  <header>
    <div id="titre">
      <h1>Ev'Note</h1>
    </div>
  </header>

  <div class="boite_inscription">
  <?php
    if(isset($_GET['reg_err']))
    {
      $err = htmlspecialchars($_GET['reg_err']);

      switch($err)
        {
          case 'success':
          ?>
            <div class="alert alert-success">
              Inscription réussie !
            </div>
          <?php
          break;

          case 'password':
          ?>
            <div class="alert alert-danger">
              Le mot de passe ne correspond pas !
            </div>
          <?php
          break;

          case 'email':
          ?>
            <div class="alert alert-danger">
              Email non valide
            </div>
          <?php
          break;

          case 'already';
          ?>
            <div class="alert alert-danger">
              Compte déjà existant
            </div>
          <?php
          break;
        }
    }
    ?>
  <form name="formul" action="donnees_inscription.php" method="post" enctype="multipart/form-data">
    
      <h1>Inscription sur Ev'Note</h1>
      <hr>

      <label for="nom"><b>Nom</b></label>
      <input type="text" placeholder="Entrer votre nom" name="Nom" id="Nom" required>
    
      <label for="prenom"><b>Prénom</b></label>
      <input type="text" placeholder="Entrer votre prénom" name="Prenom" id="Prenom" required>
    
      <label for="picture"><b>Photo de profil</b></label>
      <!--file ou image ??-->
      <input type="file" placeholder="Mettre une photo de profil" name="image" accept="image/png, image/jpeg, image/jpg">
    
      <div class="type_compte"></div>
      <label for="type_compte"><b>Type de compte</b></label>
      <select name="TypeCompte" id="TypeCompte" required>
          <option value="Étudiant">Étudiant</option>
          <option value="Établissement">Établissement</option>
      </select>    
<br>
<br>
      <label for="num_etud"><b>Numéro Étudiant</b></label>
      <input type="number" placeholder="Entrer votre numéro étudiant" name="NumEtu" id="NumEtu" required>
    
      <label for="email"><b>Adresse mail</b></label>
      <input type="text" placeholder="Entrer votre adresse mail" name="Mail" id="Mail" required>

      <label for="password"><b>Mot de passe</b></label>
      <input type="password" placeholder="Entrer votre mot de passe" name="Mdp" id="Mdp" required>

      <!--demander numero etudiant seulement si compte de type etudiant -->
    
      <hr>
      <button type="submit" name="valider" class="inscription">S'inscrire</button> 
  </form>
</div>


</body>
</html>
