<?php 
    $bdd = mysqli_connect("localhost", "utilisateur", "projetweb2022", "projet");// On inclut la connexion à la bdd
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
      //$check = $bdd->prepare('SELECT Nom,Prenom, Mail, NumEtu, Mdp FROM user WHERE Mail = ?');
      //$check->execute([$email]);
      //$data = $check->fetch();
      //$row = $check->rowCount();

      $email = strtolower($email);
      //$req2="SELECT * FROM compte WHERE Adresse = '".$EMAIL."'";// requete de la verif de l'existence de l'email dans la BDD
       //         $verif2=mysqli_query($connect,$req2);//execution de la requette
                 
      //          if($verif2){//si adresse présente dans la BDD
          //          echo "L'adresse possede deja un compte sur ce site...<br/>";                   
         //       }
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
        ?>
        <script> 
        function Inscription_reussie(){
          alert("Inscription réussie !");
        }
        </script>
        <?php
        header('Location: ../../index.php?reg_err=success');
        //header('Location:user_inscription.php?reg_err=success');
        die();

      }else{ header('Location: user_inscription.php?reg_err=email'); die();}
    }
        //$email = strtolower($email);
        //$nom = htmlspecialchars($_POST['Nom']);
        //$prenom = htmlspecialchars($_POST['Prenom']);
        //$image = $_FILES['image']['name'];
        //$picture = htmlspecialchars($_POST['image']);
        //$target = "uploads/".basename($image);
        //$sql = "INSERT INTO image_upload (image) VALUES ('$image')";
        //mysqli_query($db, $sql);
  	    //move_uploaded_file($_FILES['image']['tmp_name'], $target);

        //$type_compte = htmlspecialchars($_POST['TypeCompte']);
        //$num_etud = htmlspecialchars($_POST['NumEtu']);
        //$email = htmlspecialchars($_POST['Mail']);
        //$password = htmlspecialchars($_POST['Mdp']);

        // On vérifie si l'utilisateur existe
        //$check = $bdd->prepare('SELECT Nom,Prenom, Mail, NumEtu, Mdp FROM user WHERE Mail = ?');
        //$check->execute(array($email));
        //$data = $check->fetch();
        //$row = $check->rowCount();

        //$email = strtolower($email);

        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        //if($row == 0)
        //{ 
         // if(filter_var($email, FILTER_VALIDATE_EMAIL))
         // { // Si l'email est de la bonne forme
                            // On hash le mot de passe
           // $password = hash('sha256', $password);
                            
                            // On stock l'adresse IP
            //$ip = $_SERVER['REMOTE_ADDR']; 
                             /*
      
                              Verifiez bien que le champ token est présent dans votre table user

                              ATTENTION
                            */
                            // On insère dans la base de données
              //$insert = $bdd->prepare('INSERT INTO user(NumEtu, Nom, Prenom, Mail, Mdp, image, TypeCompte, Id, Token) VALUES(:NumEtu, :Nom, :Prenom, :Mail, :Mdp, :image, :TypeCompte, :Id, :Token)');
              //$insert->execute(array(
               // 'Nom' => $nom,
              //  'Prenom' => $prenom,
               // 'image' => $picture,
               // 'TypeCompte' => $type_compte,
               // 'NumEtu' => $num_etud,
               // 'Mail' => $email,
               // 'Mdp' => $password,
               // 'Id' => $ip,
               // 'Token' => bin2hex(openssl_random_pseudo_bytes(64))
              //));
                            // On redirige avec le message de succès
              //header('Location:user_inscription.php?reg_err=success');
              //die();

         // }else{ header('Location: user_inscription.php?reg_err=email'); die();}
       // }else{ header('Location: user_inscription.php?reg_err=already'); die();}
    //  }
?>
<html>
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
      <button type="submit" name="upload" onclick="Inscription_reussie()" class="inscription">S'inscrire</button>
  </form>
</div>


</body>
</html>