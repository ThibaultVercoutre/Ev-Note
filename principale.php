<html>

<?php
require_once 'pages/php/login.php';
session_start();
if(($_SESSION['email']) !== ""){
  $email = $_SESSION['email'];
  $reponse = $bdd->query('SELECT Nom, Prenom FROM user WHERE Mail="'.$email.'"');
  $donnees = $reponse->fetch();

}
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ev'Note</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
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
  <header>
    <div id="titre">
      <h1>Ev'Note</h1>
      <div id="div-search">
        <input class="button" id="search" placeholder="Rechercher un lieu..."></input>
      </div>
      <div class="button" id="loupe">
        <div id="cercle"></div>
        <div id="barre"></div>
      </div>
    </div>
    <div id="compte"><ul id="menu-demo2"> 
        
          <li class="menu-deroulant">
            <div id="menu"><h2 id="connect"><a href="#"><?php echo $donnees['Prenom']." ".$donnees['Nom'] ; ?>
            <div id="logo-connexion">
          <span class="material-symbols-outlined">account_circle</span>
          <!--<div id="rond-connexion">
            <div id="rond-corps"></div>
            <div id="rond-tete"></div>-->
          </div></a></div>
            <ul class="sous-menu">
            
              <li><a  href="pages/php/user_deconnexion.php">Déconnexion</a></li></h2>
            </ul>
          </li>
        </ul>
      
  

    </div>
  </header>

  <form action="#" method="post">
    <div id="phrase-presentation">
      <p>Vos lieux et événements sur Calais disponibles sur un seul endroit</p>
    </div>
    </div>
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

    <div class="pages">
      <nav>
        <div class="button drop" id="map">
          <div class="carre">
            <span class="material-symbols-outlined">location_on</span>
            <!--
              <span class="material-symbols-outlined">map</span>
              <div id="carte">
              <div id="carte-page-1"></div>
              <div id="carte-page-2"></div>
              <div id="carte-page-3"></div>
            </div>-->
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
      <div id="interact">
        <div class="button drop" id="note">
          <div class="carre">
            <span class="material-symbols-outlined">edit_note</span>
            <!--<div id="manche"></div>
            <div id="pointe-stylo"></div>
            <div id="ecriture"></div>-->
          </div>
        </div>
        <div class="button drop" id="checkbox">
          <div class="carre">
            
            <span class="material-symbols-outlined">checklist</span>
            <!--<div id="manche"></div>
            <div id="pointe-stylo"></div>
            <div id="ecriture"></div>-->
          </div>
        </div>
      </div>
      <div id="map-actu">

        <div class="parent" id="pages-map">
          <div class="page child1" id="section-notation">
            <div id="details-notations">
              <div id="title-batiment">
                <h1 id="batiment-name">Nom de l'établissement</h1>
                <h1 id="ville-name-notation">Ville</h1>
              </div>
              <div id="elements-notations">
                <div class="img"></div>
                <div id="section-avis">
                  <div class="avi">
                    <div class="compte-note">
                      <div class="img-profil-note"><img src="pages/img/alexis.webp"></div>
                      <div class="nom">Alexis</div>
                      <span class="material-symbols-outlined verified">verified</span>
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
                    </div>
                    <div class="text-avi">
                      J'y vais tout les soirs avec mon père. Nous aimons beaucoup y aller car
                      ça montre de nous que nous sommes des personnes riches et civilisés. J'ai
                      beaucoup d'argent et j'aime le montrer. Savez vous que les 26 plus riches milliardaires detiennent
                      plus d'argent que 60% de la population mondial ? Mon père fait partit de ces 26,
                      et vous des 60%. J'ai 7 PS5 ok ? J'ai un écran 4K ? Et pourtant, j'ai trouvé la
                      bombine pour être boursier echelon II, et oui, à I echelon près, j'avais 100 repas gratuit, payé
                      par vos impôt, qu'évidemment mon père ne paies pas.
                      Bonne journée ! 
                    </div>
                    <div class="actions">
                      <span class="material-symbols-outlined up">thumb_up</span>
                      <span class="material-symbols-outlined down">thumb_down</span>
                      <span class="material-symbols-outlined report">priority_high</span>
                    </div>
                  </div>
                  <div class="avi">
                    <div class="compte-note">
                      <div class="img-profil-note"><img src="pages/img/julien.png"></div>
                      <div class="nom">Julien</div>
                      <span class="material-symbols-outlined verified">verified</span>
                    </div>
                    <div class="text-avi">
                       J'y ai été une fois, j'ai vu des étrangers sur scène donc je suis sorti car je me suis dit que dans une société où les noirs ne sont pas vraiment les mêmes que les blancs, il ne faut pas faire de discrimination et laisser les clowns amuser la galerie.
                    </div>
                    <div class="actions">
                      <span class="material-symbols-outlined up">thumb_up</span>
                      <span class="material-symbols-outlined down">thumb_down</span>
                      <span class="material-symbols-outlined report">priority_high</span>
                    </div>
                  </div>
                  <div class="avi">
                    <div class="compte-note">
                      <div class="img-profil-note"><img src="pages/img/florian.webp"></div>
                      <div class="nom">Florian</div>
                      <span class="material-symbols-outlined verified">verified</span>
                    </div>
                    <div class="text-avi">
                      Alors oui bonjour, C'est pour dire que l'endroit est superbe, je prend beaucoup de plaisir à y être.
                      Cela me permet de me recentrer sur moi même et mes chakras, surtout le 3eme chakras.
                    </div>
                    <div class="actions">
                      <span class="material-symbols-outlined up">thumb_up</span>
                      <span class="material-symbols-outlined down">thumb_down</span>
                      <span class="material-symbols-outlined report">priority_high</span>
                    </div>
                  </div>
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
          <div class="page child1 child2" id="section-map"></div>
        </div>
        <div class="parent" id="pages-actu">
          <div class="page child1" id="section-fil-actu">
            <!--< <p id="Description">Cette page à pour but de répertorier, dans un fil, les articles sur les évenements à venir. Vous pouvez y consulter les articles récemments éditer par les organisateurs et/ou informateurs. Vous les trouverez, ci-dessous, trier... </p> >-->

            <aside>
              <p><u>Fonctionnalités :</u><br /></p>
              <p><a href="formulaire.html">Créer un article</a></p>
            </aside>

            <article>
              <p>Soon...</p>
            </article>
          </main>
        </div>
          <div class="page child1 child2" id="section-creer-article">

          <div class="scrollbar"></div>
          <div class="clickScrollbar"></div>
          
          <div id="champ-remplit-art">
          <p><u>Renseignez les éléments suivants pour créer votre article</u></p>
          
          <form method="post" action="#">


            <fieldset>
              <legend id="Legend">Vos coordonnées</legend><br />

              <label for="Nom">Nom</label><br />
              <input type="text" name="Nom" id="Nom" placeholder="Exemple : Vercoutre" size="50" required /></br></br>

              <label for="Prenom">Prénom</label><br />
              <input type="text" name="Prenom" id="Prenom" placeholder="Exemple : Thibault" size="50"
                required /></br></br>

              <label for="Mail">E-Mail</label><br />
              <input type="email" name="Mail" id="Mail" placeholder="Exemple : nom@gmail.com" size="50"
                required /></br></br>

            </fieldset><br />


            <fieldset>
              <legend id="Legend">Informations sur l'événement</legend><br />

              <label for="NomEvent">Nom de l'événement</label><br />
              <input type="text" name="NomEvent" id="NomEvent"
                placeholder="Exemple : Soirée mousse" size="50"
                required /></br></br>

              <label for="Lieu">Adresse de l'événement</label><br />
              <input type="text" name="Lieu" id="Lieu" placeholder="Exemple : 667 rue des tulipes" size="50"
                required /></br></br>

              <label for="Ville">Ville</label><br />
              <input type="text" name="Ville" id="Ville" placeholder="Exemple : Blendecques" size="50"
                required /></br></br>

              <label for="CP">Code postal</label><br />
              <input type="number" name="CP" id="CP" placeholder="Exemple : 62575" required /></br></br>

            </fieldset><br />


            <fieldset>
              <legend id="Legend">Image (optionnel)</legend>

              <label for="IMG">Inserez une image</label></br>
              <input type="file" name="IMG" id="IMG" accept="image/png, image/jpeg" />

            </fieldset>

            <br />

            <fieldset>
              <legend id="Legend">Description de l'événement</legend>

              <label for="Description">Décrivez l'événement en quelques lignes :</label></br></br>
              <textarea name="Description" id="Description" rows="20" cols="100" required></textarea>

            </fieldset>

            </br>

            <input type="submit" value="Envoyer" id="BoutonEnvoie" />

          </form>
          <div id="closeCreerArticle">
              <div class="logo-close button">
                  <div class="croix1"></div>
                  <div class="croix2"></div>
                </div>
            </div>
          </div>
          
        </div>
        </div>
        
        <nav id="bouton-scroll">
        </nav>
      </div>
    </div>
  </form>
  <nav id="nav-fin">
    <div class="button drop" id="scroll">
      <div class="carre">
        <div id="barre-arrow">
          <div id="pointe-arrow"></div>
        </div>
      </div>
    </div>
  </nav>
</body>

<footer id="le-footer">
  <p id="copyright">© 2022 Ev'Note Tous droits réservés</p>
  <div id="foot-gauche">
    <a class="lien-footer" href="conditions.html">Conditions d'utilisation</a>
    <a class="lien-footer"
      href="mailto::thibault.vercoutre@etu.eilco.univ-littoral.fr?subject=Contact - Ev'Note&body=Bonjour M. Vercoutre, ">Nous
      contacter</a>
  </div>
  <h2>Site réalisé dans le cadre d'un projet</br>École d'Ingénieurs du Littoral Côte d'Opale</h2>
  <a class="lien-footer" href="pages/devs.html"><p class="button" id="nos-devs">Nos développeurs</p></a>
  <!--<p>B. Florian</br>K. Julien</p>
  <p>V. Alexis</br>V. Thibault</p>-->
</footer>


<foot>
  <script src="script.js"></script>
</foot>

</body>
</html>    