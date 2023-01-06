<?php
//require_once 'pages/php/login.php';
$bdd = mysqli_connect("localhost", "root", "", "projet");// On inclut la connexion à la bdd
session_start();
if(($_SESSION['email']) !== ""){
  $email = $_SESSION['email'];
  $table_inner = $bdd->query("SELECT * FROM form_fil INNER JOIN utilisateur ON form_fil.id_user = utilisateur.id_user INNER JOIN photo_user ON utilisateur.id_image_user = photo_user.id_image_user INNER JOIN image_event ON form_fil.id_image_event = image_event.id_image_event ORDER BY form_fil.DateCreation DESC;");
  $reponse = $bdd->query('SELECT id_user, Nom, Prenom FROM utilisateur WHERE Mail="'.$email.'"');
  //$post = $bdd->query('SELECT id_user, NomEvent, Adresse, Ville, CP, id_image_event, id_commentaire_fil, Annonce, DateCreation, CptPouceBleu, CptPouceRouge, CptReport FROM form_fil'); 
  //$img = $bdd->query('SELECT id_image_event, Chemin FROM image_event, form_fil WHERE image_event.id_image_event = form_fil.id_image_event');
  $test = mysqli_fetch_assoc($table_inner);
  $donnees = mysqli_fetch_assoc($reponse);
  $cpt_row = mysqli_num_rows($table_inner);

}
  date_default_timezone_set('Europe/Paris');
    // Si les variables existent et qu'elles ne sont pas vides
    //if(isset($_POST['NomEvent']) && isset($_POST['Adresse']) && isset($_POST['Ville']) && isset($_POST['CP']) && isset($_POST['image']) && isset($_POST['Annonce']))
    if(isset($_POST['upload']))
    {
        $image = $_FILES['image']['name'];
        $path = 'img_event/'.$image;
        // Patch XSS
        $id_user = $donnees['id_user'];
        $nomevent = htmlspecialchars($_POST['NomEvent']);
        $lieu = htmlspecialchars($_POST['Adresse']);
        $ville = htmlspecialchars($_POST['Ville']);
        $cp = htmlspecialchars($_POST['CP']);
        $annonce = htmlspecialchars($_POST['Annonce']);
        $date = date("y-m-d H:i:s"); 
        $reponse = mysqli_query($bdd, "SELECT * FROM image_event");
        $nb_ligne = mysqli_num_rows($reponse);
        $sql4 = $bdd->query("INSERT INTO form_fil(id_user, NomEvent, Adresse, Ville, CP, id_image_event, id_commentaire_fil, Annonce, DateCreation, CptPouceBleu, CptPouceRouge, CptReport) VALUES ('$id_user','$nomevent','$lieu','$ville','$cp','$nb_ligne', '1', '$annonce','$date','0','0','0')");
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
                            // On redirige avec le message de succès
        header('Location:../../principale.php?reg_err=success');
        die();
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="img/favicon-32x32.png" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
    integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
    integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>

  <script src="https://unpkg.com/esri-leaflet@3.0.8/dist/esri-leaflet.js"
    integrity="sha512-E0DKVahIg0p1UHR2Kf9NX7x7TUewJb30mxkxEm2qOYTVJObgsAGpEol9F6iK6oefCbkJiA4/i6fnTHzM6H1kEA=="
    crossorigin=""></script>

  <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css"
    integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
    crossorigin="">
  <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"
    integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A=="
    crossorigin=""></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://stamen-maps.a.ssl.fastly.net/js/tile.stamen.js"></script>
</head>

<body>
<div id="page-principale">
  <header>
  <div id="titre">
      <div id="effecten">
        <h1 data-text="Ev'Note" id="evnote">Ev'Note</h1>
        <div id = "gradient" class="gradient"></div>
        <div class="spotlight"></div>
      </div>
      <span id="time-animation" class="material-symbols-outlined"></span>
      <div id="time"></div>
      <span id="meteo" class="material-symbols-outlined"></span>
      <div id="div-search">
        <input type="text" id="search" placeholder="Rechercher un lieu..."/>
        <ion-icon id="la-loupe" name="search-outline"></ion-icon>
      </div>
      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    </div>
    <div id="compte_connect">
      <div id="actions_compte">
        <div id="monprofil"><a href="pages/php/monprofil.php"><span class="material-symbols-outlined button drop">account_circle</span></a></div>
        <div id="deconnexion"><a  href="pages/php/user_deconnexion.php"><span class="material-symbols-outlined button drop">power_settings_new</span></a></div>
      </div>
      <div id="boutton_compte" class="button drop" etat="0">
        <div id="user" data="<?php echo $donnees['id_user']; ?>"><?php echo $donnees['Prenom']?></div>
        <div><?php echo $donnees['Nom']?></div>
      </div>
    </div>
<!--<ul id="menu-demo2"> 
          <li class="menu-deroulant">
            <div id="menu"><h2 id="connect"><a href="#" id="user" data="<?php echo $donnees['id_user']; ?>"><?php echo $donnees['Prenom']." ".$donnees['Nom'] ; ?>
            <div id="logo-connexion">
          <span class="material-symbols-outlined">account_circle</span>
          </div></a></div>
            <ul class="sous-menu"> 
              <li><a  href="pages/php/monprofil.php">Voir mon profil</a></li></h2>
              <li><a  href="pages/php/user_deconnexion.php">Déconnexion</a></li></h2>
            </ul>
          </li>
        </ul> -->

  </header>

  <div id="general">
    <div id="phrase-presentation">
      <p><span>V</span>os <span>l</span>ieux et <span>é</span>vénements disponibles sur un seul <span>e</span>ndroit !</p>
    </div>
<!-- ================================================================================================================================ -->
<!-- ======================================================================================================================== MARQUEE -->
<!-- ================================================================================================================================ -->
<div class="marquee">
      <div class="elements-marquee">
        <div class="element">
          <div class="photo 1"></div>
          <div class="informations">
            <h4>Bar 1</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 2"></div>
          <div class="informations">
            <h4>Bar 2</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 3"></div>
          <div class="informations">
            <h4>Bar 3</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 4"></div>
          <div class="informations">
            <h4>Bar 4</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 5"></div>
          <div class="informations">
            <h4>Bar 5</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 6"></div>
          <div class="informations">
            <h4>Bar 6</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 7"></div>
          <div class="informations">
            <h4>Bar 7</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 8"></div>
          <div class="informations">
            <h4>Bar 8</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 9"></div>
          <div class="informations">
            <h4>Bar 9</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 10"></div>
          <div class="informations">
            <h4>Bar 10</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 1"></div>
          <div class="informations">
            <h4>Bar 1</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 2"></div>
          <div class="informations">
            <h4>Bar 2</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 3"></div>
          <div class="informations">
            <h4>Bar 3</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 4"></div>
          <div class="informations">
            <h4>Bar 4</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
        <div class="element">
          <div class="photo 5"></div>
          <div class="informations">
            <h4>Bar 5</h4>
            <div class="note">⭐⭐⭐⭐⭐</div>
          </div>
        </div>
      </div>
    </div>
<!-- ============================================================================================================================== -->
<!-- ======================================================================================================================== Pages -->
<!-- ============================================================================================================================== -->
    <div class="pages">
      
<!-- ================================================================================================================== Boutons nav -->
      <nav>
        <div class="button drop" id="map">
          <div class="carre">
            <span class="material-symbols-outlined">location_on</span>
          </div>
        </div>
        <div class="button drop" id="actu">
          <div class="carre">
            <div>
              <div id="carre-photo"></div>
              <div class="barre" id="barre1"></div>
            </div>
            <div class="barre" id="barre2"></div>
            <div class="barre" id="barre3"></div>
          </div>
          </div>
        </nav>

<!-- ========================================================================================================== Boutons interaction -->
      <div id="interact">
        <div class="button drop" id="note">
          <div class="carre">
            <span class="material-symbols-outlined">edit_note</span>
          </div>
        </div>
        <div class="button drop" id="checkbox">
          <div class="carre">
            <span class="material-symbols-outlined">checklist</span>
          </div>
        </div>
        <div class="button drop" id="filter_check">
          <div class="carre">
            <span class="material-symbols-outlined">filter_alt</span>
          </div>
        </div>
      </div>
      <div id="map-actu"></div>
<!-- ===================================================================================================================== Page map -->
        <div class="parent" id="pages-map">
<!-- -------------------------------------------------------------------------------------------------------------- Page Creer avis -->
          <div class="page child1" id="section_creer_avis">
            <div id="closeCreerAvis">
              <div class="logo-close button">
                <div class="croix1"></div>
                <div class="croix2"></div>
              </div>
            </div>
            <div id="formulaire_creer_avis">
              <p id="message_envoie_avis"></p>
              <div>
                <p class="titre_champ">Mettez une note au lieu</p>
                <input type="number" min="0" max="5" class="champ_rep"></input>
              </div>
              <div>
                <p class="titre_champ">Quel est votre avis sur le lieu ?</p>
                <textarea type="text" class="champ_rep"></textarea>
              </div>
              <div id="envoyer_avis" class="button drop">Envoyer</div>
              <p id="message_envoie_validation"></p>
            </div>
          </div>
<!-- --------------------------------------------------------------------------------------------------------------- Page notations -->
          <div class="page child1" id="section-notation">
            <div id="details-notations">
              <div id="first-line">
                <div id="title-batiment">
                  <h1 id="batiment-name">Nom de l'établissement</h1>
                  <h1 id="ville-name-notation">Ville</h1>
                </div>
                <div class="button drop" id="creer-avis">
                  <div class="carre">
                    <span class="material-symbols-outlined">drive_file_rename_outline</span>
                  </div>
                </div>
              </div>
              <div id="elements-notations">
                <div class="img">
                  
                  <img src="" id="image_batiment_section_avis" alt="Image">
                  <div class="barres-notations">
                    <div class="barres-1">
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                    </div>
                    <div class="barres-2">
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                      <div class="barre-notation"></div>
                    </div>
                  </div>
                </div>
                <div id="section-avis">
                </div>
              </div>
            </div>
            <div id="closeNotation">
              <div class="logo-close button">
                <div class="croix1"></div>
                <div class="croix2"></div>
              </div>
            </div>
          </div>

<!-- --------------------------------------------------------------------------------------------------------------------- Page GPS -->

          <div class="page child1" id="section-gps">
            <div id="title-gps">
              <h3>Voulez-vous autoriser Ev'Note à accéder à votre localisation ?</h3>
              <div id="boutons-popup">
                <div class="button anim-button" id="oui-gps">Oui</div>
                <div class="button anim-button" id="non-gps">Non</div>
              </div>
            </div>
          </div>
          <div class="page child1" id="itineraire-gps">
            <div>
              <h1 id="titre-text-gps" data-text="Itinéraire">Itinéraire</h1>
              <div id="les-inputs-gps">
                <div class="inputBox">
                  <input type="text" required="required" id="input-depart-gps" value=""></input>
                  <span>Départ</span>
                </div>
                <div class="inputBox">
                  <input type="text" required="required" id="input-arrivee-gps" value=""></input>
                  <span>Arrivée</span>
                </div>
              </div>
              <div class="button anim-button" id="go-itineraire">
                <span class="material-symbols-outlined">roundabout_right</span>
              </div>
            </div>
          </div>

<!-- --------------------------------------------------------------------------------------------------------------------- Page map -->
          <div class="page child1 child2" id="section-map"></div>
        </div>
<!-- ==================================================================================================================== Page actu -->
        <div class="parent" id="pages-actu">
<!-- -------------------------------------------------------------------------------------------------------------------- Page actu -->
          <div class="page child1" id="section-fil-actu">
            <main>
              <div class="slideshow-container" id="articles">
                <div class="mySlides fade">
                  <div id="Article">
                    <div class ="article-header">
                      <img src="" class="avator">
                        <!--<div class="container" id="ArticleSansDesc">-->
                      <div class="article-header-info">
                        Prenom
                        <span>date de creation</span>
                        <p class="TitreArticle"><br/><b><u>Nom Event</u></b></p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti sunt dolorem est perspiciatis, odit voluptate sint neque delectus officiis explicabo distinctio? Ex in cumque nihil beatae. In tempore animi nam!</p>
                      </div>
                    </div>
                    
                    <div class="article-img-wrap">
                        <img src="img_event\photo 1.png" class="article-img">
                    </div>
                    
                    <div class="article-info-counts">
                      <div class="comments">
                        <svg class="feather feather-message-circle sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <div class="comment-count">33</div>
                      </div>
                      <div class="likes">
                        <svg class="feather feather-heart sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        <div class="likes-count">Pouce Bleu</div>
                      </div>
                      <div class="retweets">
                        <svg class="feather feather-repeat sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                        <div class="retweet-count">Pouce Rouge</div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
              </div>
              
            <br>

              <!-- The dots/circles -->
              <div style="text-align:center" id="dot_points">
                <span class="dot" onclick="currentSlide(1)"></span>
                <!--<span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>-->
              </div>
            </main>
          </div>
<!-- -------------------------------------------------------------------------------------------------------------- Page creer actu -->
          <div class="page child1 child2" id="section-creer-article">   
            <div class="scrollbar"></div>
            <div class="clickScrollbar"></div>
            <div id="champ-remplit-art">
              <p><u>Renseignez les éléments suivants pour créer votre article</u></p>
              <form method="post" action="./pages/php/donnees_formulaire.php">
               <fieldset>
                  <legend>Vos coordonnées</legend><br />
                  <label for="Nom">Nom</label><br />
                  <input type="text" name="Nom" id="Nom" placeholder="Exemple : Vercoutre" size="50" required /><br /><br />
                  <label for="Prenom">Prénom</label><br />
                  <input type="text" name="Prenom" id="Prenom" placeholder="Exemple : Thibault" size="50" required /><br /><br />
                  <label for="Mail">E-Mail</label><br />
                  <input type="email" name="Mail" id="Mail" placeholder="Exemple : xyz@leraciste.noob" size="50" required /><br /><br />
                </fieldset><br />
                <fieldset>
                  <legend>Informations sur l'événement</legend><br />
                  <label for="NomEvent">Nom de l'événement</label><br />
                  <input type="text" name="NomEvent" id="NomEvent" placeholder="Exemple : Compet OW2, qui aura un meilleur shoot que tibo ??" size="50" required /><br /><br />
                  <label for="Lieu">Adresse de l'événement</label><br />
                  <input type="text" name="Adresse" id="Adresse" placeholder="Exemple : 666 rue des ames damnées" size="50" required /><br /><br />
                  <label for="Ville">Ville</label><br />
                  <input type="text" name="Ville" id="Ville" placeholder="Exemple : Blendecques" size="50" required /><br /><br />
                  <label for="CP">Code postal</label><br />
                  <input type="number" name="CP" id="CP" placeholder="Exemple : 62575" required /><br /><br />
                </fieldset><br />
                <fieldset>
                  <legend>Image (optionnel)</legend>
                  <label for="IMG">Inserez une image</label><br />
                  <input type="file" name="IMG" id="IMG" accept="image/png, image/jpeg" required/>
                </fieldset>
                <br />
                <fieldset>
                  <legend>Description de l'événement</legend>
                  <label for="Annonce">Décrivez l'événement en quelques lignes :</label><br /><br />
                  <textarea name="Annonce" id="Description" placeholder="Quel est votre évènement ?" rows="20" cols="100" required></textarea>
                </fieldset>
                <br />
                <fieldset>
                  <legend>Tri par Thème</legend>
                  <p id="Accroche"><u>Veuillez selectionner un thème</u> :</p>
                  <div id="ListeTheme">
                    <div id="Ligne">
                      <div>
                        <input type="checkbox" id="filter1" name="filter1" value="1">
                        <label for="filter1">Jeux vidéos</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter2" name="filter2" value="1">
                        <label for="filter2">Sport</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter3" name="filter3" value="1">
                        <label for="filter3">Littérature</label>
                      </div>
                    </div>
                    <div id="Ligne">
                      <div>
                        <input type="checkbox" id="filter4" name="filter4" value="1">
                        <label for="filter4">Culture</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter5" name="filter5" value="1">
                        <label for="filter5">Peinture</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter6" name="filter6" value="1">
                        <label for="filter6">Exposition</label>
                      </div>
                    </div>

                    <div id="Ligne">

                      <div>
                        <input type="checkbox" id="filter7" name="filter7" value="1">
                        <label for="filter7">Soirée</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter8" name="filter8" value="1">
                        <label for="filter8">Bar</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter9" name="filter9" value="1">
                        <label for="filter9">Politique</label>
                      </div>

                    </div>

                    <div id="Ligne">

                      <div>
                        <input type="checkbox" id="filter10" name="filter10" value="10">
                        <label for="filter10">Réduction/Offre</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter11" name="filter11" value="1">
                        <label for="filter11">Cinéma</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter12" name="filter12" value="1">
                        <label for="filter12">Rencontre</label>
                      </div>

                    </div>

                  </div>

                </fieldset>
                <br /><br />
                <input type="submit" value="Envoyer" id="BoutonEnvoie" />
                <br /><br /><br /><br /><br />
              </form>
            </div>
            <div id="closeCreerArticle">
              <div class="logo-close button">
                <div class="croix1"></div>
                <div class="croix2"></div>
              </div>
            </div>
          </div>
<!-- --------------------------------------------------------------------------------------------------------- Page applique filtre -->
          <div class="page child1 child2" id="filtres_actu">
            <button id="filtre-button"><span class="material-symbols-outlined">close</span></button>
            <div class="carre"></div>
            <div id="filtre-menu" style="">
              <p><u>Bienvenue dans l'interface de tri des postes</u></p>
              <div method="post" action="./pages/php/donnees_formulaire.php">
                <fieldset>
                  <legend>Tri par Thème</legend>
                  <p id="Accroche"><u>Veuillez selectionner les thèmes que vous désirez afficher</u> :</p>
                  <div id="ListeTheme">
                    <div id="Ligne">
                      <div>
                        <input type="checkbox" id="filter1" name="filter" value="1">
                        <label for="filter1">Jeux vidéos</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter2" name="filter" value="1">
                        <label for="filter2">Sport</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter3" name="filter" value="1">
                        <label for="filter3">Littérature</label>
                      </div>
                    </div>
                    <div id="Ligne">
                      <div>
                        <input type="checkbox" id="filter4" name="filter" value="1">
                        <label for="filter4">Culture</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter5" name="filter" value="1">
                        <label for="filter5">Peinture</label>
                      </div>
                      <div>
                        <input type="checkbox" id="filter6" name="filter" value="1">
                        <label for="filter6">Exposition</label>
                      </div>
                    </div>

                    <div id="Ligne">

                      <div>
                        <input type="checkbox" id="filter7" name="filter" value="1">
                        <label for="filter7">Soirée</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter8" name="filter" value="1">
                        <label for="filter8">Bar</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter9" name="filter" value="1">
                        <label for="filter9">Politique</label>
                      </div>

                    </div>

                    <div id="Ligne">

                      <div>
                        <input type="checkbox" id="filter10" name="filter10" value="10">
                        <label for="filter10">Réduction/Offre</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter11" name="filter11" value="1">
                        <label for="filter11">Cinéma</label>
                      </div>

                      <div>
                        <input type="checkbox" id="filter12" name="filter12" value="1">
                        <label for="filter12">Rencontre</label>
                      </div>

                    </div>

                  </div>

                </fieldset><br />

                <fieldset class="Filtrage">
                  <legend>Autres méthodes de filtrage</legend>

                  <p id="Accroche"><u>Voici une liste d'autres fonctionalités de filtrage</u> :</p>

                  <div id="Titre">

                    <div id="TriLike">

                      <p class="SectionTri">Par nombre de Likes :</p>
                      <br>
                      <label for="filterlike1">Du plus liké au moins liké</label>
                      <input type="radio" id="filterlike1" name="filtercommentslikedate" value="1">
                      <input type="radio" id="filterlike2" name="filtercommentslikedate" value="1">
                      <label for="filterlike2">Du moins liké au plus liké</label>

                    </div>

                    <br>

                    <div id="TriComments">

                      <p class="SectionTri">Par nombre de commentaires :</p>
                      <br>
                      <label for="filtercomments1">Du plus commenté au moins commenté</label>
                      <input type="radio" id="filtercomments1" name="filtercommentslikedate" value="1">
                      <input type="radio" id="filtercomments2" name="filtercommentslikedate" value="1">
                      <label for="filtercomments2">Du moins commenté au plus commenté</label>

                    </div>

                    <br>

                    <div id="TriDate">

                      <p class="SectionTri">Par date de création :</p>
                      <br>
                      <label for="filterdate1">Du plus récent au moins récent</label>
                      <input type="radio" id="filterdate1" name="filtercommentslikedate" value="1">
                      <input type="radio" id="filterdate2" name="filtercommentslikedate" value="1">
                      <label for="filterdate2">Du moins récent au plus récent</label>

                    </div>

                    <br>

                  </div>

                </fieldset><br />

                <br />
                <button value="Appliquer" name="uploadfiltre" id="BoutonEnvoieFiltres" >Appliquer</button>
                <br /><br /><br /><br /><br />
              </div>
            </div>
          </div>
        </div>
        <nav id="bouton-scroll"></nav>
    </div> <!-- ==================================================== FIN Corps de la page -->
  </div>
  <nav id="nav-fin">
    <div class="button drop" id="scroll">
      <div class="carre">
        <div id="barre-arrow">
          <div id="pointe-arrow"></div>
        </div>
      </div>
    </div>
  </nav>
  <footer id="le-footer">
    <p id="copyright">© 2022 Ev'Note Tous droits réservés</p>
    <div id="foot-gauche">
      <a class="lien-footer" href="./pages/conditions.html">Conditions d'utilisation</a>
      <a class="lien-footer"
        href="mailto::thibault.vercoutre@etu.eilco.univ-littoral.fr?subject=Contact-Ev'Note&body=Bonjour,">Nouscontacter</a>
    </div>
    <h2>Site réalisé dans le cadre d'un projet<br />École d'Ingénieurs du Littoral Côte d'Opale</h2>
    <a class="lien-footer" href="pages/devs.html"><p class="button" id="nos-devs">Nos développeurs</p></a>
  </footer>
</div>

<div id="page-chargement">
  <img id="logo-site-chargement" src="img/EvNote_1.png" alt="Logo-Site">
  <div id="progress-chargement"></div>
</div>
</body>


</html>

<!--
  <div class="stars-notations">
    <div class="stars-1">
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
  </div>
  <div class="stars-2">
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
    <span class="material-symbols-outlined">star</span>
  </div>
</div>
-->
<script src="script.js"></script>