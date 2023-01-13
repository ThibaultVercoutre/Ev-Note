/*=======================================================================================================*/
/*========================================= Chargement avis =============================================*/

function ListeNavisLike(section, type, reponse){

  user = document.getElementById("user").getAttribute("data");
  let Savis = document.getElementById(section);

  switch(type){
    case '0': var table = 'likes_avis'; var bool = 'like_bool'; break; 
    case '1': var table = 'dislikes_avis'; var bool = 'dislike_bool'; break; 
    case '2': var table = 'reports_avis'; var bool = 'report_bool'; break; 
  }

  switch(section){
    case 'section-report': var b1 = '<div class="suppr_avis" onclick="genererCode('; var b2 =')">Supprimer cet Avis</div>'; break;
    default: var b1 = '<div class="go_avis" onclick="afficherLieuAvis('; var b2 = ')">Se rendre au lieu de cet avis</div>'; break;
  }

  /* creation n avis */
  var params = new URLSearchParams();
  params.append('user', user);
  params.append('table', table);
  params.append('bool', bool);
  params.append('type', reponse);

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
  .then(response => response.json())
  .then(data => {
    for(var i = 0; i < data.length; i++) {
      Savis.innerHTML += '<div class="avi" id="avis_' + data[i] + '">'
                          + '<div class="compte-note">'
                            + '<div class="img-profil-note"><img src="" alt="image-profil" class="img-profil-note-balise"></div>'
                            + '<div class="nom"></div>'
                            + '<span class="material-symbols-outlined verified"></span>'
                            + '<div class="barres-notations-user"></div>'
                            + b1 + data[i] + b2
                          + '</div>'
                          + '<div class="text-avi"></div>'
                          + '<div class="actions">'
                            + '<span class="material-symbols-outlined up">thumb_up</span><div class="b_up"></div>'
                            + '<span class="material-symbols-outlined down">thumb_down</span><div class="b_down"></div>'
                            + '<span class="material-symbols-outlined report">priority_high</span><div class="b_report"></div>'
                          + '</div>'
                        + '</div>';
    }
  });
}

function ListeNlieuCree(section, type, reponse){

  user = document.getElementById("user").getAttribute("data");
  let Slieu = document.getElementById(section);

  /* creation n lieu */
  var params = new URLSearchParams();
  params.append('user', user);
  params.append('table', 'lieu_tmp');
  params.append('bool', type);
  params.append('type', reponse);

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
    for(var i = 0; i < data[0].length; i++) {
      console.log(data);
      Slieu.innerHTML += '<div class="avi" id="lieu_' + data[0][i] + '" data = "' + data[1][i] + '">'
                          + '<div class="compte-note">'
                            + '<div class="img-profil-note"><img src="" alt="image-profil" class="img-profil-note-balise"></div>'
                            + '<div class="nom"></div>'
                            + '<div class="ajout_suppr">'
                              + '<div class="ajout_lieu" onclick="ajouterLieuCode(' + data[0][i] + ')">Ajouter ce lieu</div>'
                              + '<div class="suppr_lieu" onclick="supprimerLieuCode(' + data[0][i] + ')">Supprimer ce lieu</div>'
                            + '</div>'
                          + '</div>'
                        + '</div>';
    }
  });
}

ListeNavisLike('section-avis-like', '0', '0');
ListeNavisLike('section-avis-dislike', '1', '0');
ListeNavisLike('section-avis-report', '2', '0');
ListeNavisLike('section-report', '2', '0');

ListeNlieuCree('section-nouveau-lieu', '2', '6');

function PlaceElementLieux(s, type, reponse){

  /* Image BDD */
  var params = new URLSearchParams();
  params.append('user', user);
  params.append('table', type);
  params.append('bool', '1  ');
  params.append('type', reponse);

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
  .then(response => response.json())
  .then(data => {
    var images = document.querySelectorAll('#' + s.getAttribute("id") + ' .img-profil-note-balise');
    var adresses = document.querySelectorAll('#' + s.getAttribute("id") + ' .nom');
    
    for(var i = 0; i < data[0].length; i++) {
      images[i].src = "../../" + data[0][i];
      adresses[i].textContent = data[1][i] + " - " + data[2][i];
    }
  });
}

function PlaceElement(s, type, reponse){
  user = document.getElementById("user").getAttribute("data");

  switch(type){
    case '0': var table = 'likes_avis'; var bool = 'like_bool'; break; 
    case '1': var table = 'dislikes_avis'; var bool = 'dislike_bool'; break; 
    case '2': var table = 'reports_avis'; var bool = 'report_bool'; break; 
  }

  /* Image BDD */
  var params = new URLSearchParams();
  params.append('user', user);
  params.append('table', table);
  params.append('bool', bool);
  params.append('type', reponse);

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
  .then(response => response.json())
  .then(data => {

    var images = document.querySelectorAll('#' + s.getAttribute("id") + ' .img-profil-note-balise');
    var prenoms = document.querySelectorAll('#' + s.getAttribute("id") + ' .nom');
    var verif = document.querySelectorAll('#' + s.getAttribute("id") + ' .verified');
    var notes = document.querySelectorAll('#' + s.getAttribute("id") + ' .barres-notations-user');
    var avis = document.querySelectorAll('#' + s.getAttribute("id") + ' .text-avi');
    var up = document.querySelectorAll('#' + s.getAttribute("id") + ' .b_up');
    var down = document.querySelectorAll('#' + s.getAttribute("id") + ' .b_down');
    var report = document.querySelectorAll('#' + s.getAttribute("id") + ' .b_report');
    
    for(var i = 0; i < data[0].length; i++) {
      images[i].src = data[0][i];
      prenoms[i].textContent = data[1][i];
      if(data[2][i] == 'Developpeur'){
        verif[i].textContent = 'verified';
      }
      notes[i].textContent = data[3][i] + " / 5";
      avis[i].textContent = data[4][i];
      up[i].textContent = data[5][i];
      down[i].textContent = data[6][i];
      report[i].textContent = data[7][i];
    }
  });
}

var button = document.getElementsByClassName('bouton_avis');
var sections = document.getElementsByClassName('section');

function TestBoutonsAvis(i, b, type){
  if(type == '0'){
    if(sections[i].style.display != "block"){
      b[i].style.backgroundColor = "#456fa0";
      sections[i].style.display = "block";
    }else{
      b[i].style.backgroundColor = "";
      sections[i].style.display = "none";
    }
    i += 1;
    b[i%3].style.backgroundColor = "";
    sections[i%3].style.display = "none";
    i += 1;
    b[i%3].style.backgroundColor = "";
    sections[i%3].style.display = "none";
  }else if(type == '1'){
    if(sectionReport[0].style.display != "block"){
      b[0].style.backgroundColor = "#456fa0";
      sectionReport[0].style.display = "block";
    }else{
      b[0].style.backgroundColor = "";
      sectionReport[0].style.display = "none";
    }
  }else{
    if(SectionLieu[0].style.display != "block"){
      b[0].style.backgroundColor = "#456fa0";
      SectionLieu[0].style.display = "block";
    }else{
      b[0].style.backgroundColor = "";
      SectionLieu[0].style.display = "none";
    }
  }
}

button[0].onclick = function(){
  TestBoutonsAvis(0, button, '0');
  PlaceElement(sections[0], '0', '1');
}

button[1].onclick = function(){
  TestBoutonsAvis(1, button, '0');
  PlaceElement(sections[1], '1', '1');
}

button[2].onclick = function(){
  TestBoutonsAvis(2, button, '0');
  PlaceElement(sections[2], '2', '1');
}

/*=======================================================================================================*/
/*========================================= Afficher les avis signalés ==================================*/

var button2 = document.getElementsByClassName('bouton_avis_signalés');
var sectionReport = document.getElementsByClassName('section2');

button2[0].onclick = function(){
  TestBoutonsAvis(0, button2, '1');
  PlaceElement(sectionReport[0], '2', '3');
}

/*=======================================================================================================*/
/*========================================= Afficher les avis signalés ==================================*/

var button3 = document.getElementsByClassName('bouton_nouveau_lieu');
var SectionLieu = document.getElementsByClassName('section3');

button3[0].onclick = function(){
  TestBoutonsAvis(0, button3, '2');
  PlaceElementLieux(SectionLieu[0], '2', '7');
}

/*=======================================================================================================*/
/*========================================= supprimer un avis ===========================================*/

function generateString(length) {
  let result = '';
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const charactersLength = characters.length;
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

var txt = '';
var avis_suppr = 0;

function genererCode(avis){
    txt = generateString(10);
    document.getElementById("suite_carac").textContent = txt;
    document.getElementById("verif_suppr").style.display = "flex";
    document.getElementById("verif_suppr").setAttribute("data", "0");
    avis_suppr = avis;
}

function ajouterLieuCode(avis){
  txt = generateString(10);
  document.getElementById("suite_carac").textContent = txt;
  document.getElementById("verif_suppr").style.display = "flex";
  document.getElementById("verif_suppr").setAttribute("data", "1");
  avis_suppr = avis;
}

function supprimerLieuCode(avis){
  txt = generateString(10);
  document.getElementById("suite_carac").textContent = txt;
  document.getElementById("verif_suppr").style.display = "flex";
  document.getElementById("verif_suppr").setAttribute("data", "2");
  avis_suppr = avis;
}

function supprimerAvis(avis){
  var elements = [document.querySelector('#section-report #avis_' + avis),
                document.querySelector('#section-avis-like #avis_' + avis),
                document.querySelector('#section-avis-dislike #avis_' + avis),
                document.querySelector('#section-avis-report #avis_' + avis)];
  
  for(var i = 0; i < elements.length; i++) {
    if(elements[i] != null){
      var parent = elements[i].parentNode;
      parent.removeChild(elements[i]);
    }
  }  

  var params = new URLSearchParams();
  params.append('user', '');
  params.append('table', 'avis');
  params.append('bool', avis);
  params.append('type', '4');

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
}

function supprimerLieu(lieu){
  var elements = [document.querySelector('#section-nouveau-lieu #lieu_' + lieu)];

  for(var i = 0; i < elements.length; i++) {
    if(elements[i] != null){
      var parent = elements[i].parentNode;
      parent.removeChild(elements[i]);
    }
  }  

  var params = new URLSearchParams();
  params.append('user', '');
  params.append('table', 'lieu_tmp');
  params.append('bool', lieu);
  params.append('type', '8');

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
}

function ajouterLieu(lieu){
  var elements = [document.querySelector('#section-nouveau-lieu #lieu_' + lieu)];

  var adresse = document.querySelector('#lieu_' + lieu + ' .nom').textContent;
  var photo = document.querySelector('#lieu_' + lieu).getAttribute('data');

  adresse = adresse.split(' - ');
  console.log(photo);

  for(var i = 0; i < elements.length; i++) {
    if(elements[i] != null){
      var parent = elements[i].parentNode;
      parent.removeChild(elements[i]);
    }
  }  

  var params = new URLSearchParams();
  params.append('user', adresse[0]);
  params.append('table', adresse[1]);
  params.append('bool', lieu);
  params.append('type', photo);

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
}

const input = document.querySelector('#champ_verif');

input.addEventListener('input', () => {
  if(input.value == txt){  
    document.getElementById("verif_suppr").style.display = "none";
    if(document.getElementById("verif_suppr").getAttribute("data") == "0"){
      supprimerAvis(avis_suppr);
    }else if(document.getElementById("verif_suppr").getAttribute("data") == "1"){
      ajouterLieu(avis_suppr);
      supprimerLieu(avis_suppr);
    }else if(document.getElementById("verif_suppr").getAttribute("data") == "2"){
      supprimerLieu(avis_suppr);
    }
  }
});

/*=======================================================================================================*/
/*========================================= Aller au lieu de l'avis =====================================*/

var go_avis = document.getElementById("go_avis");

function afficherLieuAvis(avis){
  window.open('../../principale.php', '_self');
}

/*=======================================================================================================*/
/*========================================= Afficher ou pas section admin ===============================*/

function afficheAdmin(){
  var user = document.getElementById("user").getAttribute("data");
  var section_admin = document.getElementById("sectionAdmin");
  var section_suppr_avis = document.getElementById("section-report");

  var params = new URLSearchParams();
  params.append('user', user);
  params.append('table', 'utilisateur');
  params.append('bool', 'Developpeur');
  params.append('type', '5');

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
  .then(response => response.json())
  .then(data => {
    if(data.length == 0){
      section_admin.parentElement.removeChild(section_admin);
    }
  });
}

afficheAdmin();

/*=======================================================================================================*/
/*========================================= Header ======================================================*/

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var njour = today.getDate();
  var mois = today.getMonth();
  var jour = today.getDay();
  var start = new Date(today.getFullYear(), 0, 0);
  var diff = today - start;
  var oneDay = 1000 * 60 * 60 * 24;
  var day = Math.floor(diff / oneDay);
  var couleur = convertColor(day);
  document.getElementById("gradient").style.background = couleur;
}

function convertColor(jour) {
  var couleur;
  if (jour >= 79 && jour < 171) {
    couleur = "linear-gradient(45deg, rgb(51, 144, 2), rgb(133, 255, 108))";
  }
  else if (jour >= 171 && jour < 265) {
    couleur = "linear-gradient(45deg, yellow, rgb(3, 208, 254))";
  }
  else if (jour >= 265 && jour < 355) {
    couleur = "linear-gradient(45deg, red, yellow)";
  }
  else {
    couleur = "linear-gradient(45deg, rgb(57, 229, 255), rgb(234, 255, 254))";
  }
  return couleur;
}

 
startTime();

/*=============================================================================================
===============================================================================================*/
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

let slideIndexSignale = 1;
showSlides(slideIndexSignale);

// Next/previous controls
function plusSlidesSignale(n) {
  showSlidesSignale(slideIndexSignale += n);
}

// Thumbnail image controls
function currentSlideSignale(n) {
  showSlidesSignale(slideIndexSignale = n);
}

function showSlidesSignale(n) {
  let i;
  let slides = document.getElementsByClassName("fadesignale");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
/*========================================================================================
=======================================FORMULAIRE CHANGEMENT DE MOT DE PASSE=================================================*/

document.getElementById("button_suppr").addEventListener("click", function() {
  if (confirm("Voulez-vous vraiment supprimer votre compte ?")) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ev-notelikeok/pages/profil_user/monprofil.php", true);
    xhr.send();
  }
});

var formulaireAffiche = false;
document.getElementById("button_mdp").addEventListener("click", function() {
  if (formulaireAffiche) {
    formulaireAffiche = false;
    document.getElementById("formulaire_mdp").style.display = "none";
  } else {
    formulaireAffiche = true;
    document.getElementById("formulaire_mdp").style.display = "block";
  }
});


/*===========================================================================
=========================BOUTON POUR AFFICHER SLIDER================*/

    // Cibler les formulaires
    var likeForm = document.getElementById("like-form");
    var dislikeForm = document.getElementById("dislike-form");
    var reportForm = document.getElementById("report-form");

    // Cibler le conteneur du diaporama
    var slideshowContainer = document.getElementById("slideshow-container");

    // Ajouter un écouteur d'événements de soumission sur les formulaires
    likeForm.addEventListener("submit", function(event) {
        slideshowContainer.style.display = "block";
    });
    dislikeForm.addEventListener("submit", function(event) {
        slideshowContainer.style.display = "block";
    });
    reportForm.addEventListener("submit", function(event) {
        slideshowContainer.style.display = "block";
    });

