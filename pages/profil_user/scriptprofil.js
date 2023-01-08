/*=======================================================================================================*/
/*========================================= Chargement avis =============================================*/

function ListeNavisLike(section, type){

  user = document.getElementById("user").getAttribute("data");
  let Savis = document.getElementById(section);

  switch(type){
    case '0': var table = 'likes_avis'; var bool = 'like_bool'; break; 
    case '1': var table = 'dislikes_avis'; var bool = 'dislike_bool'; break; 
    case '2': var table = 'reports_avis'; var bool = 'report_bool'; break; 
  }

  /* creation n avis */
  var params = new URLSearchParams();
  params.append('user', user);
  params.append('table', table);
  params.append('bool', bool);
  params.append('type', '0');

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
  .then(response => response.json())
  .then(data => {
    console.log(user, table, bool);
    console.log(data);
    for(var i = 0; i < data.length; i++) {
      Savis.innerHTML += '<div class="avi" id="avis_' + data[i] + '">'
                          + '<div class="compte-note">'
                            + '<div class="img-profil-note"><img src="" alt="image-profil" class="img-profil-note-balise"></div>'
                            + '<div class="nom"></div>'
                            + '<span class="material-symbols-outlined verified"></span>'
                            + '<div class="barres-notations-user"></div>'
                            + '<div class="go_avis">Se rendre au lieu de cet avis</div>'
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

ListeNavisLike('section-avis-like', '0');
ListeNavisLike('section-avis-dislike', '1');
ListeNavisLike('section-avis-report', '2');

function PlaceElement(s, type){
  user = document.getElementById("user").getAttribute("data");
  let Savis = document.getElementById(s);

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
  params.append('type', '1');

  fetch('/pages/fonctions_bdd/fonction_php_liste_like.php', {
    method: 'POST',
    body: params
  })
  .then(response => response.json())
  .then(data => {
    /* Image */
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

console.log(button);

function TestBoutonsAvis(i, b){
  b[i].style.backgroundColor = "#456fa0";
  sections[i].style.display = "block";
  i += 1;
  b[i%3].style.backgroundColor = "";
  sections[i%3].style.display = "none";
  i += 1;
  b[i%3].style.backgroundColor = "";
  sections[i%3].style.display = "none";
}

button[0].onclick = function(){
  TestBoutonsAvis(0, button);
  PlaceElement(sections[0], '0');
}

button[1].onclick = function(){
  TestBoutonsAvis(1, button);
  PlaceElement(sections[1], '1');
}

button[2].onclick = function(){
  TestBoutonsAvis(2, button);
  PlaceElement(sections[2], '2');
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