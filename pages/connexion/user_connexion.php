<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="styleconnexion.css" rel="stylesheet" media="screen" type="text/css">
</head>

<body>
  <header>
    <div id="titre">
      <h1>Ev'Note</h1>
    </div>
  </header>
  
  <div class="boite_connexion">
  <?php
    if(isset($_GET['login_err']))
    {
      $err = htmlspecialchars($_GET['login_err']);

      switch($err)
        {
          case 'password':
          ?>
            <div class="erreur_password">
              Mot de passe incorrect
            </div>
          <?php
          break;

          case 'email':
          ?>
            <div class="erreur_mail">
              Email incorrect
            </div>
          <?php
          break;

          case 'already';
          ?>
            <div class="erreur_compte">
              Compte non existant
            </div>
          <?php
          break;
        }
    }
    ?>
  <form action="../php/verification.php" method="post">
    
      <h1>Se connecter</h1>
      <hr>

      <label for="email"><b>Adresse mail</b></label>
      <input type="text" placeholder="Entrer votre adresse mail" name="email" id="email" required>

      <label for="password"><b>Mot de passe</b></label>
      <input type="password" placeholder="Entrer votre mot de passe" name="password" id="password" required>
      <hr>

      <button type="submit" class="connexion">Se connecter</button> 
  </div>
    

    <div class="boite_inscription">
      <p>Pas de compte ? <a href="user_inscription.php">Inscrivez-vous !</a></p>
    </div>
  </form>


</body>
</html>

