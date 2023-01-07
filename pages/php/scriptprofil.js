/*=======================================================================================================*/
/*========================================= Chargement avis =============================================*/

function ListeNavis(){
    
    var adresse = texte;
    let Savis = document.getElementById('section-avis');
    Savis.innerHTML = '';

    /* creation n avis */
    var params = new URLSearchParams();
    params.append('clave1', '6');
    params.append('clave2', adresse);
    params.append('clave3', '8');

    fetch('fonction_php.php', {
      method: 'POST',
      body: params
    })
    .then(response => response.json())
    .then(data => {
      for (var i = 0; i < data.length; i++) {
        Savis.innerHTML += '<div class="avi" id="avis_' + data[i] + '">'
                          + '<div class="compte-note">'
                            + '<div class="img-profil-note"><img src="" alt="image-profil" class="img-profil-note-balise"></div>'
                            + '<div class="nom"></div>'
                            + '<span class="material-symbols-outlined verified"></span>'
                            + '<div class="barres-notations-user">'
                            + '</div>'
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

ListeNavis();

/*=======================================================================================================*/
/*========================================= Slides actu =================================================*/

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
  });