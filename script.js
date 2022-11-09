/*=======================================================================================================*/
/*==================================== Creation map chargement de la page ===============================*/

/* Map ===================================*/
var mymap = L.map('section-map').setView([50.95129, 1.858686], 11);

/* marqueur ==============================*/
var marqueur = L.marker([50.95129, 1.858686]).addTo(mymap);

window.onload = () => {
  // Nous initialisons la carte et nous la centrons sur Paris

  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '',
    minZoom: 13,
    maxZoom: 18
  }).addTo(mymap);
  //var command = L.control({position: 'topright'});
  
};

/*=======================================================================================================*/
/*============================= Ajout section filtre map (bars, lycées ...) =============================*/

var cats = ["Bars", "Parcs","Culture", "FastFood", "Lycees"];
/*for (var i = 0; i < geojson.length; i++) {
  var cat = getCat(cats, geojson[i].properties.categorie2);
  if (cat === undefined) {
      cat = {
          "interestPoints" : createInterestPoints(),
          "id" : "cat" + i,
          "label" : geojson[i].properties.categorie2
      }
      cats.push(cat);
  }
  cat["interestPoints"].addData(geojson[i]);
}*/
//console.log(cats);

var stamen = new L.StamenTileLayer("toner-lite");

var command = L.control({position: 'topright'});
command.onAdd = function (mymap) {
    var div = L.DomUtil.create('div', 'command');
    div.innerHTML += '<div style="text-align:center;"><span style="font-size:18px;">Points d\'intérêt</span><br /><span style="color:grey;font-size:14px;">(ville d\'Issy-Les-Moulineaux)</span></div>';
    for (var i = 0; i < cats.length; i++) {
        div.innerHTML += '<form><input id="' + cats[i] + '" type="checkbox"/>' + cats[i] + '</form>';
    }
    return div;
};
command.addTo(mymap);

/*=======================================================================================================*/
/*============================== Icon Leaflet pour bar / parcs ... ======================================*/

var greenIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

/*=======================================================================================================*/
/*============================= Liste bar / restaurant / parcs ... ======================================*/


var bars = L.layerGroup([
  L.marker([50.9600393, 1.8506475], {icon : greenIcon}).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">Pop Rock</div></br>'), 
  L.marker([50.9603772,1.8484158], {icon : greenIcon}).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">Purple Cafe</div></br>')]);

var parcs = L.layerGroup([
  L.marker([50.9559974,1.8519496921045282]).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">Parc Richelieu</div></br>'), 
  L.marker([50.96344995,1.8797239818798321]).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">Bois Dubrulle</div></br>')]);

var culture = L.layerGroup([
  L.marker([50.95210063553772,1.8505847454071047]).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">Musée de mémoire 1939 - 1945</div></br>'), 
  L.marker([50.9569106930028,1.8516576290130617]).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">Musée des Beaux-Arts</div></br>')]);


var filtre = [bars, parcs, culture];

/*=======================================================================================================*/
/*========================================= Var section / boutons ... ===================================*/

/* boutons ===============================*/
let Bmap = document.getElementById("map");
let Bactu = document.getElementById("actu");
let Bnotation = document.getElementById("notation");
let BcloseNotation = document.getElementById("closeNotation");
let BcloseCreerArticle = document.getElementById("closeCreerArticle");
let BcreerArt = document.getElementById("note");
let Bcheckbox = document.getElementById("checkbox");
let Badressenote = null;
let Bsearch = document.getElementById("div-search");
let Bloupe = document.getElementById("loupe");
// like dislike report
let Bup = document.querySelectorAll(".up");
let Bdown = document.querySelectorAll(".down");
let Breport = document.querySelectorAll(".report");

/* Test ==================================*/
let Tadresse = document.getElementById("batiment-name");
let Tville = document.getElementById("ville-name-notation");

/* Input =================================*/
let Isearch = document.getElementById("search");

/* Sections ==============================*/
let Sfooter = document.getElementById("le-footer");
let Smap = document.getElementById("pages-map");
let Sactu = document.getElementById("pages-actu");
let Snotation = document.getElementById("section-notation");
let ScreerArt = document.getElementById("section-creer-article");
let SpartieMap = document.getElementById("section-map");
let SpartieActu = document.getElementById("section-fil-actu");
let Spages = document.getElementById("pages");
let Savi = document.getElementById("section-avis");
let Scheckbox = document.querySelector("div:has(> .command)");

/*=======================================================================================================*/
/*========================================= detection section filtre ====================================*/

// checkbox command

let CcheckBox = document.querySelectorAll("div form input[type=checkbox]");
let Scommand = document.querySelector(".command");

function add_Marker_lieu(e){
  // On vérifie si le marqueur existe déjà
  if (marqueur != undefined) {
    // Si oui, on le retire
    mymap.removeLayer(marqueur);
  }
  switch (e.id) {
    case 'Bars': filtre[0].addTo(mymap); break;
    case 'Parcs': filtre[1].addTo(mymap); break;
    case 'Culture': filtre[2].addTo(mymap); break;
  }
}

function remove_Marker_lieu(e){
  switch (e.id) {
    case 'Bars': mymap.removeLayer(filtre[0]); break;
    case 'Parcs': mymap.removeLayer(filtre[1]); break;
    case 'Culture': mymap.removeLayer(filtre[2]); break;
  }
}

function add_Marker_Command(e){
  for(var i = 0; i < CcheckBox.length; i++) {
    if(e.target == CcheckBox[i]){
      if(CcheckBox[i].checked == true){
        CcheckBox[i].addEventListener('change', add_Marker_lieu(CcheckBox[i]), false);
      }else{
        CcheckBox[i].addEventListener('change', remove_Marker_lieu(CcheckBox[i]), false);
      }
    }
  }
}

Scommand.addEventListener('click', add_Marker_Command, false);

/*=======================================================================================================*/
/*========================================= Style bouton zoom ===========================================*/

//Boutons zoom

let Dzoom = document.querySelector(".leaflet-control-zoom");
Dzoom.style.border = "0px";

let Dzoomin = document.querySelector(".leaflet-control-zoom-in");
let Dzoomout = document.querySelector(".leaflet-control-zoom-out");
Dzoomin.style.borderRadius = "8px 8px 0px 0px";
Dzoomout.style.borderRadius = "0px 0px 8px 8px";

/*=======================================================================================================*/
/*========================================= ScrollBar ===================================================*/

/* var ScrollBar */
let SremplirArt = document.getElementById("champ-remplit-art");
const progressBar = document.querySelector('.scrollbar');
const progressBarClick = document.querySelector(".clickScrollbar");
const Bscroll = document.getElementById("scroll");
const Cscroll = document.querySelector("#scroll > .carre");

/* Detection du scroll sur la page */
SremplirArt.addEventListener("scroll", () => {
  let totalHeight = SremplirArt.scrollHeight - SremplirArt.clientHeight;
  let progress = (SremplirArt.scrollTop / totalHeight) * 100;
  progressBar.style.height = `${progress}%`;
  progressBar.style.opacity = `${progress}%`;
})

/* detection du scroll sur la page principale */
window.addEventListener("scroll", () => {
  if (document.documentElement.scrollTop != 0) {
    Cscroll.style.transform = "rotate(180deg)";
  } else {
    Cscroll.style.transform = "rotate(0deg)";
  }
})

/* detection click sur la barre */
progressBarClick.addEventListener("click", (e) => {
  let totalHeight = SremplirArt.scrollHeight - SremplirArt.clientHeight;
  let newPageScroll = e.layerY / progressBarClick.offsetHeight * totalHeight;
  SremplirArt.scrollTo({
    top: newPageScroll,
    behavior: 'smooth'
  })
})

/* cacher / montrer la barre de progression */
progressBarClick.addEventListener("mouseenter", () => {
  progressBar.style.width = "15px";
  progressBarClick.style.width = "15px";
})

progressBarClick.addEventListener("mouseleave", () => {
  progressBar.style.width = "8px";
  progressBarClick.style.width = "8px";
})

/* */
Bscroll.onclick = function() {
  if (document.documentElement.scrollTop == 0) {
    window.scrollTo({
      top: 100,
      behavior: 'smooth'
    })
  } else {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    })
  }
}

/*=======================================================================================================*/
/*===================================== Chargement des notes des avis ===================================*/

const NotBarres = document.querySelectorAll(".compte-note .barres-notations .barres-2");
const NotBarresImg = document.querySelector(".img .barres-notations .barres-2");
const Noms = document.querySelectorAll(".compte-note .nom");
var noteTotale = 0;

function chargementNotesAvis(){
  for(barres of NotBarres) {
    //console.log(barres);
    var nom = barres.parentElement.previousSibling.previousSibling.previousSibling.previousSibling.textContent;
    var note = nom.length%5;
    noteTotale += note;
    //  note = le note de l'avis du nom courant
    for(var i = 1; i <= Math.floor(note/1)*2-1; i += 2){
      barres.childNodes[i].style.width = "50px";
    }
    barres.childNodes[i].style.width = note%1*50 + "px";
    barres.childNodes[i].style.borderRadius = "10px " + (note%1)*10 + "px " + (note%1)*10 + "px 10px";
    for(i += 2; i <= 9; i += 2){
      barres.childNodes[i].style.width = "0px";
    }
    //}
  }

  var noteFinale = noteTotale/NotBarres.length;
  //console.log(noteFinale);

  for(var i = 1; i <= Math.floor(noteFinale/1)*2-1; i += 2){
    NotBarresImg.childNodes[i].style.width = "50px";
  }
  NotBarresImg.childNodes[i].style.width = noteFinale%1*50 + "px";
  NotBarresImg.childNodes[i].style.borderRadius = "10px " + (noteFinale%1)*10 + "px " + (noteFinale%1)*10 + "px 10px";
  for(i += 2; i <= 9; i += 2){
    NotBarresImg.childNodes[i].style.width = "0px";
  }
}

chargementNotesAvis();

/*=======================================================================================================*/
/*========================================= Passage de pages en page ===================================*/

/* reserStyle non utilisé */
function resetStyle(S, S2) {
  /*
  var rectBmap = Bmap.getBoundingClientRect();
  var rectBactu = Bactu.getBoundingClientRect();
  var rectSmap = Smap.getBoundingClientRect();
  var rectSactu = Sactu.getBoundingClientRect();

  Smap.style.top = (rectBactu.top - 45 - (rectSmap.bottom - rectSmap.top) / 2) + "px";
  Smap.style.left = (rectBactu.left + 14 - (rectSmap.right - rectSmap.left) / 2) + "px";

  Sactu.style.top = (rectBmap.top - 45 - (rectSactu.bottom - rectSactu.top) / 2) + "px";
  Sactu.style.left = (rectBmap.left + 14 - (rectSactu.right - rectSactu.left) / 2) + "px";

  Sactu.style.transform = "scale(0)";
  Smap.style.transform = "scale(0)";

  Sactu.style.opacity = 0;
  Smap.style.opacity = 0;*/
};

/* Afficher la section S et cacher la section S2 */
function affiche(S, S2) {
  if (S == Smap) {
    SpartieActu.style.opacity = 0;
    SpartieMap.style.opacity = 1;
    S.style.transform = "scaleX(1)";
    S2.style.transform = "scaleX(0)";
    progressBar.style.width = "0px";
    progressBarClick.style.width = "0px";
    BcreerArt.style.display = "none";
    Bcheckbox.style.display = "block";
  }
  if (S == Sactu) {
    SpartieActu.style.opacity = 1;
    SpartieMap.style.opacity = 0;
    ScreerArt.style.display = "block";
    S.style.transform = "scaleX(1)";
    S2.style.transform = "scaleX(0)";
    progressBar.style.width = "8px";
    progressBarClick.style.width = "8px";
    BcreerArt.style.display = "block";
    Bcheckbox.style.display = "none";
  }
}

/* Afficher / cacher la barre de recherche */

function afficheBarre(S) {
  if (S == Sactu) {
    Bsearch.style.transform = "scale(0,0.5)";
    Bloupe.style.borderRadius = "40%";
  }
  else {
    Bsearch.style.transform = "scale(1,1)";
    Isearch.style.borderRadius = ".9rem 0% 0% .9rem";
    Bloupe.style.borderRadius = "0% 40% 40% 0%";
  }
}


affiche(Smap, Sactu);
//ScreerArt.style.transform = "scaleY(0)";

/* Si on clique sur le bouton map */
Bmap.onclick = function() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
  Snotation.style.transform = "translate(-100%,0px)";
  ScreerArt.style.transform = "translate(100%,0px) scaleY(0)";
  afficheBarre(Smap);
  affiche(Smap, Sactu);
};

/* Si on clique sur le bouton actu */
Bactu.onclick = function() {
  Snotation.style.transform = "translate(-100%,0px)";
  afficheBarre(Sactu);
  affiche(Sactu, Smap);
};

/* Si on clique sur le bouton creer article */
BcreerArt.onclick = function() {
  ScreerArt.style.transition = "0.3s";
  ScreerArt.style.transform = "translate(0px,0px) scaleY(1)";
  BcreerArt.style.display = "none";
}

/* Si on clique sur la section checkbox */
Scheckbox.style.display = "none";
var ScheckboxPosition = 0;
Bcheckbox.onclick = function() {
  if(ScheckboxPosition == 0){
    Scheckbox.style.display = "block";
    ScheckboxPosition = 1;
  }else{
    Scheckbox.style.display = "none";
    ScheckboxPosition = 0;
  }
}

/*=======================================================================================================*/
/*===================================================== boutons close ===================================*/

BcloseNotation.onclick = function() {
  Snotation.style.transform = "translate(-100%,0px)";
  Bcheckbox.style.display = "block";
}

BcloseCreerArticle.onclick = function() {
  ScreerArt.style.transform = "translate(100%,0px) scaleY(0)";
  BcreerArt.style.display = "block";
}

/*
Bnote.onclick = function() {
  resetStyle(Snotation, Smap);
  affiche(Snotation, Smap);
};*/

/*=======================================================================================================*/
/*========================================= Recherche d'une adresse =====================================*/

/* ajouter un marqueur et supprimer le précédent */
function addMarker(pos, nom) {
  console.log(pos);
  for(var i = 0; i < filtre.length; i++) {
    mymap.removeLayer(filtre[i]);
  }
// On vérifie si le marqueur existe déjà
  if (marqueur != undefined) {
    // Si oui, on le retire
    mymap.removeLayer(marqueur);
  }
  // On crée le marqueur aux coordonnées "pos"
  marqueur = L.marker(
    pos, {
    // On rend le marqueur déplaçable
    draggable: true
  }
  )
  //var resultat = result.address.Match_addr;
  var index = nom.indexOf(",");
  Tville.textContent = "62100 Calais"; // Si Calais
  if (index !== -1) {
    var texte = nom.split(",");
    console.log(texte);
    if(parseInt(texte[0][0]) >= 0 || parseInt(texte[0][0] <= 9)){
      Tadresse.textContent = texte[0] + texte[1];
      texte = texte[0] + texte[1];
    }else{
      Tadresse.textContent = texte[0];
      texte = texte[0];
    }
  } else {
    var texte = nom;
    Tadresse.textContent = nom;
  }

  //marqueur.addTo(mymap);
  /*L.marker(pos).addTo(mymap).bindPopup('Your point is at <\br>' + result.address.Match_addr).openPopup();*/
  if(nom.search(" 62100,") != -1){
    marqueur.addTo(mymap).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">' + texte + '</div></br>').openPopup();
  }else{
    marqueur.addTo(mymap).bindPopup('<h1>Adresse du lieu : </h1><p>' + texte + '</p>').openPopup();
  }
  Bnotation = document.getElementById("adresse-note");
  mymap.setView([pos.lat, pos.lng]);

};


/* Activation bouton pour acceder au avis de l'adresse */
function boutonavis(e) {
  if (Bnotation != null) {
    if (e.target.id == Bnotation.id) {
      Snotation.style.transition = "0.3s";
      Bcheckbox.style.display = "none";
      Snotation.style.transform = "translate(0px,0px)";
    }
  }
}
Smap.addEventListener('click', boutonavis, false);

/* Si on clique sur la map */
mymap.on('click', function(e) {
  if(e.originalEvent.path.length < 12){
    Snotation.style.transition = "0s";
    Snotation.style.transform = "translate(-100%,0px)";
    // On récupère les coordonnées du clic
    pos = e.latlng;
    let url = new URL("http://nominatim.openstreetmap.org/search?q=" + pos.lat + "%20" + pos.lng + "&format=json&limit=1");
    
    $.getJSON(url, function(data) {
      if(data[0].display_name.search(" 62100,") != -1){
        addMarker(pos, data[0].display_name);
      }else{
        pos = {lat : 50.95129, lng : 1.858686};
        addMarker(pos, "Destination impossible");
      }
    });
  }
});

/* Si on clique sur la loupe */
Bloupe.onclick = function() {
  let adresse = Isearch.value;
  let regex = "[Cc][Aa][Ll][Aa][Ii][Ss]"
  if(adresse.search(regex) == -1){
    adresse = adresse + " Calais";
  }
  adresse.replace(" ", "%20");
  let url = new URL("http://nominatim.openstreetmap.org/search?q=" + adresse + "&format=json&limit=1");
  $.getJSON(url, function(data) {
    let pos = {lat : data[0].lat, lng : data[0].lon};
    if(data[0].display_name.search(" Calais") != -1){
        addMarker(pos, data[0].display_name);
    }else{
      pos = {lat : 50.95129, lng : 1.858686};
      addMarker(pos, "Destination impossible");
    }
  });
}

/*=======================================================================================================*/
/*================================== Changement couleur like / dislike / report =========================*/

function action_avis(e) {
  for(var i = 0; i < Bup.length; i++) {
    if(e.target == Bup[i]) {
      if(Bup[i].style.color == "green"){
        Bup[i].style.color = "black";
      }else{
        Bup[i].style.color = "green";
      }
      Bdown[i].style.color = "black";
    }
    if(e.target == Bdown[i]) {
      if(Bdown[i].style.color == "red"){
        Bdown[i].style.color = "black";
      }else{
        Bdown[i].style.color = "red";
      }
      Bup[i].style.color = "black";
    }
    if(e.target == Breport[i]) {
      if(Breport[i].style.color == "orange"){
        Breport[i].style.color = "black";
      }else{
        Breport[i].style.color = "orange";
      }
    }
  }
}

Savi.addEventListener('click', action_avis, false);



/*=======================================================================================================*/
/*========================================= Test ========================================================*/


let url = new URL("http://nominatim.openstreetmap.org/search?q=Pas-de-Calais%20Calais,&format=json&limit=1000");
    
//console.log(url);
$.getJSON(url, function(data) {
  //console.log(data.length);
});