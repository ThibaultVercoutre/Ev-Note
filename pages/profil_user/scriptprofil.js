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

ListeNavisLike('section-avis-like', '0', '0');
ListeNavisLike('section-avis-dislike', '1', '0');
ListeNavisLike('section-avis-report', '2', '0');
ListeNavisLike('section-report', '2', '0');

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
    console.log(data);

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
  }else{
    if(sectionReport[0].style.display != "block"){
      b[0].style.backgroundColor = "#456fa0";
      sectionReport[0].style.display = "block";
    }else{
      b[0].style.backgroundColor = "";
      sectionReport[0].style.display = "none";
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
    avis_suppr = avis;
}

function supprimerAvis(avis){
  document.getElementById("verif_suppr").style.display = "none";

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

const input = document.querySelector('#champ_verif');

input.addEventListener('input', () => {
  if(input.value == txt){
    supprimerAvis(avis_suppr)
  }
});

/*=======================================================================================================*/
/*========================================= Aller au lieu de l'avis =====================================*/

var go_avis = document.getElementById("go_avis");

function afficherLieuAvis(avis){
  window.open('../../principale.php', '_self');
}

/*=======================================================================================================*/
/*========================================= Slides actu =================================================*/
/*
document.getElementById("button_suppr").addEventListener("click", function() {
    if (confirm("Voulez-vous vraiment supprimer votre compte ?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "ev-note/pages/php/monprofil.php", true);
      xhr.send();
    }
  });
  
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
  
  var formulaireAffiche = false;
  document.getElementById("button_mdp").addEventListener("click", function() {
    if (formulaireAffiche) {
      formulaireAffiche = false;
      document.getElementById("formulaire_mdp").style.display = "none";
    } else {
      formulaireAffiche = true;
      document.getElementById("formulaire_mdp").style.display = "block";
    }
  });*/