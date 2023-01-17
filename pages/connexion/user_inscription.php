<?php 
    $bdd = mysqli_connect("localhost", "root", "", "projet");// On inclut la connexion à la bdd
    // Si les variables existent et qu'elles ne sont pas vides
    if(isset($_POST['upload'])){
      $image = $_FILES['image']['name'];
      $path = '../../img_compte/'.$image;
      $nom = htmlspecialchars($_POST['Nom']);
      $prenom = htmlspecialchars($_POST['Prenom']);
      $type_compte = htmlspecialchars($_POST['TypeCompte']);
      $num_etud = htmlspecialchars($_POST['NumEtu']);
      $email = htmlspecialchars($_POST['Mail']);
      $password = htmlspecialchars($_POST['Mdp']);
      $email = strtolower($email);
      $select = mysqli_query($bdd, "SELECT * FROM utilisateur WHERE Mail = '".$email."'");
      if(mysqli_num_rows($select)){
        header('Location: user_inscription.php?reg_err=already'); 
        die();
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL))  
      { // Si l'email est de la bonne forme
            // On hash le mot de passe
        $password = hash('sha256', $password); 
        $sql2 = $bdd->query("INSERT INTO photo_user(chemin) VALUES ('$path')");
        $reponse = mysqli_query($bdd, "SELECT * FROM photo_user");
        $test = mysqli_num_rows($reponse);
        $sql = $bdd->query("INSERT INTO utilisateur(Nom, Prenom, NumEtudiant, Mail, MotDePasse, TypeCompte, id_image_user) VALUES ('$nom','$prenom','$num_etud','$email','$password','$type_compte', '$test')");
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
        echo "Inscription réussie !";
        header('Refresh: 3; url=../../index.php?reg_err=success');
        die();

      }else{ header('Location: user_inscription.php?reg_err=email'); die();}
    }

?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="styleconnexion.css" rel="stylesheet" media="screen" type="text/css">
  <link rel="shortcut icon" href="../../img/favicon-32x32.png" type="image/x-icon">
</head>

<body>
  <header>
    <div id="titre">
      <a id="home" href="javascript:history.go(-2)" style="text-decoration: none;">
      <div id="effecten">
        <h1 data-text="Ev'Note" id="evnote">Ev'Note</h1>
        <div id = "gradient" class="gradient"></div>
        <div class="spotlight"></div>
      </div>
      </a>
      <span id="time-animation" class="material-symbols-outlined"></span>
      <div id="time">Page de Inscription</div>
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
  <form method="POST" action="user_inscription.php" enctype="multipart/form-data">
    
      <h1>Inscription sur Ev'Note</h1>
      <hr>

      <label for="nom"><b>Nom</b></label>
      <input type="text" placeholder="Entrer votre nom" name="Nom" id="Nom" required>
    
      <label for="prenom"><b>Prénom</b></label>
      <input type="text" placeholder="Entrer votre prénom" name="Prenom" id="Prenom" required>
    
      <label for="picture"><b>Photo de profil</b></label>
      <input type="file" placeholder="Mettre une photo de profil" name="image" id="image" accept="image/png, image/jpeg, image/jpg" required>
    
      <div class="type_compte"></div>
      <label for="type_compte"><b>Type de compte</b></label>
      <select name="TypeCompte" id="TypeCompte" required>
          <option value="Etudiant">Etudiant</option>
          <option value="Etablissement">Etablissement</option>
      </select>    
<br>
<br>
      <label for="num_etud"><b>Numéro Étudiant</b></label>
      <input type="number" placeholder="Entrer votre numéro étudiant" name="NumEtu" id="NumEtu" required>
    
      <label for="email"><b>Adresse mail</b></label>
      <input type="text" placeholder="Entrer votre adresse mail" name="Mail" id="Mail" required>

      <label for="password"><b>Mot de passe</b></label>
      <input type="password" placeholder="Entrer votre mot de passe" name="Mdp" id="Mdp" required>

      <hr>
      <button type="submit" name="upload" class="inscription">S'inscrire</button>
  </form>
</div>


</body>
</html>

<script src="../../header.js"></script>