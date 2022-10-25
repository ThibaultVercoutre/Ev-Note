<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="pages/css/styleconnexion.css" rel="stylesheet" media="screen" type="text/css">
</head>

<body style='background:#fff;'>
  <div id="contenu">
    <!-- tester si l'utilisateur est connecté -->
    <?php
        session_start();
        if(($_SESSION['email']) !== "")
        {
            $email = $_SESSION['email'];
            echo "Vous êtes connecté à votre compte à l'adresse $email";
        }
    ?>
  </div>
</body>
</html>
    
  
  