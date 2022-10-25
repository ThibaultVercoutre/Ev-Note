<?php 
    require_once 'login.php'; // On inclut la connexion à la bdd

    // Si les variables existent et qu'elles ne sont pas vides
    if(isset($_POST['Nom']) && isset($_POST['Prenom']) && isset($_POST['Picture']) && isset($_POST['TypeCompte']) && isset($_POST['NumEtu']) && isset($_POST['Mail']) && isset($_POST['Mdp']))
    {

        // Patch XSS
        $nom = htmlspecialchars($_POST['Nom']);
        $prenom = htmlspecialchars($_POST['Prenom']);
        $picture = htmlspecialchars($_POST['Picture']);
        $type_compte = htmlspecialchars($_POST['TypeCompte']);
        $num_etud = htmlspecialchars($_POST['NumEtu']);
        $email = htmlspecialchars($_POST['Mail']);
        $password = htmlspecialchars($_POST['Mdp']);

        // On vérifie si l'utilisateur existe
        $check = $bdd->prepare('SELECT Nom,Prenom, Mail, NumEtu, Mdp FROM user WHERE Mail = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        $email = strtolower($email);

        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0)
        { 
          if(filter_var($email, FILTER_VALIDATE_EMAIL))
          { // Si l'email est de la bonne forme
                            // On hash le mot de passe
            $password = hash('sha256', $password);
                            
                            // On stock l'adresse IP
            $ip = $_SERVER['REMOTE_ADDR']; 
                             /*
      
                              Verifiez bien que le champ token est présent dans votre table user

                              ATTENTION
                            */
                            // On insère dans la base de données
              $insert = $bdd->prepare('INSERT INTO user(NumEtu, Nom, Prenom, Mail, Mdp, Picture, TypeCompte, Id, Token) VALUES(:NumEtu, :Nom, :Prenom, :Mail, :Mdp, :Picture, :TypeCompte, :Id, :Token)');
              $insert->execute(array(
                'Nom' => $nom,
                'Prenom' => $prenom,
                'Picture' => $picture,
                'TypeCompte' => $type_compte,
                'NumEtu' => $num_etud,
                'Mail' => $email,
                'Mdp' => $password,
                'Id' => $ip,
                'Token' => bin2hex(openssl_random_pseudo_bytes(64))
              ));
                            // On redirige avec le message de succès
              header('Location:user_inscription.php?reg_err=success');
              die();

          }else{ header('Location: user_inscription.php?reg_err=email'); die();}
        }else{ header('Location: user_inscription.php?reg_err=already'); die();}
  }
/*
<html>
<body>
<?

require_once 'login.php';

// recuperation des valeurs du formulaire
$nom = $_POST['Nom'];
$prenom = $_POST['Prénom'];
$picture = $_POST['Picture'];
$type_compte = $_POST['TypeCompte'];
$num_etud = $_POST['NumEtu'];
$email = $_POST['Mail'];
$password= $_POST['Mdp'];  
$id = "12";
$token = "aze";
   
// insertion des valeurs dans la base
$query = "INSERT INTO user(NumEtu,Nom,Prénom,Mail, Mdp,Picture,TypeCompte,Id, Token) VALUES ('$num_etud','$nom','$prenom','$email','$password','$picture','$type_compte','$id','$token')";
$result=mysql_query($query);
mysql_close();
?>
</body>
</html>
*/