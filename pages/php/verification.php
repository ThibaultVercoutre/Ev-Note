<?php
session_start();
require_once '../php/login.php';

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
        header('Location:../../principale.php');
      }else header('Location:../connexion/user_connexion.php?login_err=password');
    }else header('Location:../connexion/user_connexion.php?login_err=email');
  }else header('Location:../connexion/user_connexion.php?login_err=already');
}else header('Location:../connexion/user_connexion.php');
?>