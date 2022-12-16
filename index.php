<?php
    require_once 'pages/php/login.php'; // On inclut la connexion à la bdd
    session_start();
    $reponse = $bdd->query('SELECT NumEtu, NomEvent, Adresse, Ville, CP, IMG, Annonce, DateCreation FROM projet');
    //$donnees = $reponse->fetch();
    if ($reponse = 0){
        echo "Aucun post";
    }



//function make_query($bdd)
//{
//    $query = " SELECT * FROM testpost ORDER BY DateCreation DESC";
//    $resultat = mysql_query($bdd, $query);
//    return $resultat;
//}
  
//function make_slide_indicators($conn)
//{
//   $output = '';
//    $count = 0;
//   $result = make_query($conn);
//    while($row = mysqli_fetch_array($result))
//    {
//        if($count == 0)
//        {
//            $output .= '<li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>
//            ';
//        } else {
//            $output .= '<li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>';
//        }
//        $count = $count + 1 ;
//    }
//    return $output;
//}

//function make_slides($conn)
//{
//    $output = '';
//    $count = 0;
//    $result = make_query($conn);
//    while($row = mysqli_fetch_array($result))
//    {
//        if($count == 0)
//        {
//            $output .= '<div class="item active">';
//        } else {
//            $output .= '<div class="item">';
//        }
//        $output .= '<img src="images/notes/'.$row["image"]
//                .'" alt="'.$row["denomination"].'" style=" width: 100%;height: 300px;" /> 
//                <div class="carousel-caption"> 
//                <h3>' .$row['price'].'</h3>
//                </div>';
//        $count = $count +1;
//    }
//    return $output;
//}
//    <?php
//    function SlideShow($slide){
//        $conn = mysqli_connect("localhost", "root", "", "tsl_tv_system");
//        $image_details  = mysqli_query($conn, "SELECT * FROM slides limit $slide, 1");
//        $row = mysqli_fetch_array($image_details);
//        echo "<img src='upload/upload/".$row['attachment_loc']."'>";
//    }
    
//    $n = isset($_POST['n']) ? intval($_POST['n']) : -1;
//    fin php
//<?php
//    SlideShow($n + 1);
//  fin php

?>


<!DOCTYPE html>
<html lang="fr">

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

  <script src="fonction_php.php"></script>
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
    <div id="compte"><a href="pages/php/user_connexion.php">
        <h2 id="connect">Connexion</h2>
        <div id="logo-connexion">
          <span class="material-symbols-outlined">account_circle</span>
          <!--<div id="rond-connexion">
            <div id="rond-corps"></div>
            <div id="rond-tete"></div>
          </div>-->
        </div>
      </a>
    </div>
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
            <!--<div id="manche"></div>
            <div id="pointe-stylo"></div>
            <div id="ecriture"></div>-->
          </div>
        </div>
      </div>
      <div id="map-actu"></div>
<!-- ===================================================================================================================== Page map -->
        <div class="parent" id="pages-map">
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
                  
                  <img src="img/TheatreCalais.jpg" alt="Image">
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
                  <div class="avi">
                    <div class="compte-note">
                      <div class="img-profil-note"><img src="pages/img/alexis.webp" alt="image-profil"></div>
                      <div class="nom">Alexis</div>
                      <span class="material-symbols-outlined verified">verified</span>
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
                    <div class="text-avi">
                      J'adore m'y rendre. J'y vais quasiment tout les soirs. Je vais commencer à parler latin car j'aurais plus d'inspi.
                      Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam debitis nam similique dolores vero quae dolorum, optio eligendi asperiores sunt quam consectetur necessitatibus! Dicta, rerum illum! Pariatur iste officia ratione!
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam sunt provident debitis, repellat velit voluptatum quidem consequatur, nostrum aliquid nisi iste ut? Molestias odit placeat eius deleniti? Rem, rerum delectus?
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quis error iusto maiores molestiae, dicta magni ab laborum nulla accusantium iure nihil vitae quia saepe eum nostrum dolores commodi debitis vel.
                      
                    </div>
                    <div class="actions">
                      <span class="material-symbols-outlined up">thumb_up</span>
                      <span class="material-symbols-outlined down">thumb_down</span>
                      <span class="material-symbols-outlined report">priority_high</span>
                    </div>
                  </div>
                  <div class="avi">
                    <div class="compte-note">
                      <div class="img-profil-note"><img src="pages/img/julien.png" alt="image-profil"></div>
                      <div class="nom">Julien</div>
                      <span class="material-symbols-outlined verified">verified</span>
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
                    <div class="text-avi">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam rerum labore sit, vitae mollitia tenetur unde vero voluptatibus tempore. Quas consequuntur excepturi laboriosam quod temporibus, magni reiciendis. Voluptate, reprehenderit ipsam.
                    </div>
                    <div class="actions">
                      <span class="material-symbols-outlined up">thumb_up</span>
                      <span class="material-symbols-outlined down">thumb_down</span>
                      <span class="material-symbols-outlined report">priority_high</span>
                    </div>
                  </div>
                  <div class="avi">
                    <div class="compte-note">
                      <div class="img-profil-note"><img src="pages/img/florian.webp" alt="image-profil"></div>
                      <div class="nom">Florian</div>
                      <span class="material-symbols-outlined verified">verified</span>
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
                  <div class="avi">
                    <div class="compte-note">
                      <div class="img-profil-note"><img src="pages/img/thibault.jpg" alt="image-profil"></div>
                      <div class="nom">Thibault</div>
                      <span class="material-symbols-outlined verified">verified</span>
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
                    <div class="text-avi">
                      C'était pas mal en vrai
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
              <div class="slideshow-container">

                <!-- Full-width images with number and caption text -->
                <div class="mySlides fade">
                  <div class="numbertext">1 / 3</div>
                  
                  <div id="Article">
                    <div class ="article-header">
                      <img src="https://fs-prod-cdn.nintendo-europe.com/media/images/10_share_images/portals_3/2x1_SuperMarioHub.jpg" class="avator">
                        <!--<div class="container" id="ArticleSansDesc">-->
                      <div class="article-header-info">
                        Thierry Henry
                    <span> Test </span>
                        
                        <p class="TitreArticle"><br/><b><u>Tournoi Mario Kart</u></b></p>
                        <p>Vous aimez les courses effrénées, les véhicules en tout genre et les jeux vidéos ? Si c'est le cas cet événement est parfait pour vous ! En effet, dans celui-ci, organiser par Mr Vandenbroucke le détenant du titre, vous pourrez affronter les plus grands pilotes Calesiens dans un tournois rocambolesque mélant conduites et stratégies</p>
                      </div>
                    </div>
                    
                    <div class="article-img-wrap">
                        <img src="https://fs-prod-cdn.nintendo-europe.com/media/images/10_share_images/portals_3/2x1_SuperMarioHub.jpg" class="article-img">
                    </div>
                    
                    <div class="article-info-counts">
                      <div class="comments">
                        <svg class="feather feather-message-circle sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <div class="comment-count">33</div>
                      </div>
              
                      <div class="retweets">
                        <svg class="feather feather-repeat sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                        <div class="retweet-count">397</div>
                      </div>
              
                      <div class="likes">
                        <svg class="feather feather-heart sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        <div class="likes-count">2.6k</div>
                      </div>
                    </div>
                  </div>
                  
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">2 / 3</div>
                  <img src="img2.jpg" style="width:100%">
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">3 / 3</div>
                  <img src="img3.jpg" style="width:100%">
                </div>

                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
              </div>
              
            <br>

              <!-- The dots/circles -->
              <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
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
                <input type="submit" value="Envoyer" id="BoutonEnvoie" />
              </form>
            </div>
            <div id="closeCreerArticle">
              <div class="logo-close button">
                <div class="croix1"></div>
                <div class="croix2"></div>
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
    <script src="script.js"></script>
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

<?php 
    // Récupération du contenu HTML d'une page web
    $html = file_get_contents('index.php');

    // Création d'un objet DOM
    $dom = new DOMDocument();

    // Chargement du HTML dans l'objet DOM
    /*$dom->loadHTML($html);

    // Récupération de la première balise p du document
    $balise_p = $dom->getElementById('adresse-note');

    // Récupération du contenu texte de la balise p
    $contenu = $balise_p->nodeValue;

    // Affichage du contenu texte
    echo "<script>var balise_p = '". $contenu ."';
    console.log(balise_p);

    </script>";*/

    //Recupération des données pour les avis d'un lieu
    // Préparation de la requête SQL
    $sql = "SELECT Chemin FROM photo_eta WHERE id_p_eta = (SELECT id_p_eta FROM lieu WHERE Adresse = 'Grand théâtre de Calais')";
    $stmt = $bdd->prepare($sql);

    // Exécution de la requête
    $stmt->execute();

    // Récupération des résultats
    $resultats = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Conversion des résultats en tableau JavaScript
    $img_lieu = json_encode($resultats);

    // Envoi du tableau JavaScript au client
    echo "<script>var mes_clients = ". $img_lieu .";
                  console.log(mes_clients);

                  </script>";
?>

<!--
<div id="TitreArticle">
                        <p><u><?php echo $donnees['NomEvent']; ?></u></p>
                      </div>

                      <?php 
                      echo '<img src="uploads/' . $donnees["IMG"] . '">';?>
                      <div id="DescriptionArticle">
                        <h3><u>Description de l'événement </u> :</h3>
                        <p><?php echo $donnees['Annonce']; ?></p>  
                      </div>
                    </div>
                  </li>
-->