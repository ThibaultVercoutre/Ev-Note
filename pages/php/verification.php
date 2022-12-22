<?php
session_start();
require_once 'login.php';

if((isset($_POST['email'])) && isset($_POST['password']))
{
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);

  $check = $bdd->prepare('SELECT Mail, MotDePasse FROM utilisateur WHERE Mail = ?');
  $check->execute(array($email));
  $data = $check->fetch();
  $row = $check->rowCount();

  if($row == 1)
  {
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $password = hash('sha256', $password);
      if($data['MotDePasse'] === $password)
      {
        $_SESSION['email'] = $email;
        header('Location:../../index.php');
      }else header('Location:user_connexion.php?login_err=password');
    }else header('Location:user_connexion.php?login_err=email');
  }else header('Location:user_connexion.php?login_err=already');
}else header('Location:user_connexion.php');
/*
//applique fonctions mysqli_real_escape_string et htmlspecialchars 
//pour appliquer toute attaque de type injection SQL 
  $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email']));
  $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
  
  if($email !== "" && $password !== "")
  {
    $requete = "SELECT count(*) FROM utilisateur where email = '".$email."' and mot_de_passe = '".$password."' ";
    $exec_requete = mysqli_query($db,$requete);
    $reponse = mysqli_fetch_array($exec_requete);
    $count = $reponse['count(*)'];
    if($count!=0) //email et mot de passe correctes
    {
      $_SESSION['email'] = $email;
      header('Location : principale.php');
    }
    else
    {
      header('Location: user_connexion.php?erreur=1'); //Email ou mot de passe incorrect
    }
  }
  else
  {
    header('Location: user_connexion.php?erreur=2'); //Email ou mot de passe vide
  }
}
else
{
  header('Location: user_connexion.php');  
}
mysqli_close($db); //fermer la connexion
?>

*/