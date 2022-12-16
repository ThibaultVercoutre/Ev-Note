/*=======================================================================================================*/
/*==================================== Creation map chargement de la page ===============================*/

/* Map ===================================*/
var mymap = L.map('section-map', {
  zoomSnap: 1}).setView([50.95129, 1.858686], 11);

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

// Temps et Search

let Isearch = document.getElementById("search");

/*

Isearch.addEventListener("mouseenter", function(event) {
  document.getElementById("time").style.fontSize = "0px";
});

Isearch.addEventListener("mouseleave", function(event) {
  document.getElementById("time").style.fontSize = "26px";
});

*/

/*=======================================================================================================*/
/*============================= Ajout section filtre map (bars, lycées ...) =============================*/

var cat1 = ["Bars", "FastFood", "Lycees"];
var cat2 = ["Parcs","Culture"];
var cat3 = ["Lycees", "Ecoles"];
var rubriques = [
["Restauration","Bars", "FastFood"],
["Detente","Parcs","Culture"],
["Etudes","Lycees", "Universites"]];

var stamen = new L.StamenTileLayer("toner-lite");

var command = L.control({position: 'topright'});
command.onAdd = function creerFiltres(mymap) {
  var div = L.DomUtil.create('div', 'command command-filtre');
  div.innerHTML += '<div style="text-align:center;"><span style="font-size:18px;">Points d\'intérêt</span><br /><span id="ville-des-filtres" style="color:grey;font-size:14px;">(ville de Calais)</span></div>';
  for (var i = 0; i < rubriques.length; i++) {
    var txt = '';
    txt += '<div class="category"><form class="category_title"><span data-value="' + 1 + '" class="material-symbols-outlined">chevron_right</span><div id="' + rubriques[i][0] + '" class="type_rubrique">' + rubriques[i][0] + '</div></form>';
    for(var j = 1; j < rubriques[i].length; j++) {
      txt += '<form data-value="' + 1 + '" class="checkfiltre ' + rubriques[i][0] + '"><label class="switch"><input id="' + rubriques[i][j] + '" type="checkbox"><span class="slider"></label>' + rubriques[i][j] + '</form>';
    }
    txt += '</div>';
    div.innerHTML += txt;
  }
  return div;
};
command.addTo(mymap);

let texte = "";

/*=======================================================================================================*/
/*===================================== Ajout section choix villes ======================================*/

var villes = ["Calais", "Dunkerque", "Saint-Omer", "Blendecques"];

var stamen = new L.StamenTileLayer("toner-lite");

var command = L.control({position: 'bottomleft',});
command.onAdd = function (mymap) {
  var div = L.DomUtil.create('div', 'command command-villes');
  var txt ='';
  var txt1 = '<div style="text-align:center;"><span data-value="' + 0 + '" id="ville_selector_menu" style="font-size:18px;"><div>Villes</div><span class="material-symbols-outlined">chevron_right</span></span></div><div id="liste-villes">';
  var txt = '';
  for (var i = 0; i < villes.length; i++) {
    txt += '<div class="button-villes .drop anim-button" id="ville_' + villes[i] + '"><p>' + villes[i] + '</p></div>';
  }
  var txt2 = '</div><input type="search" id="input-villes"/>';
  div.innerHTML += txt1 + txt + txt2;
  return div;
};
command.addTo(mymap);

/*=======================================================================================================*/
/*============================== Icon Leaflet pour bar / parcs ... ======================================*/

var couleur_rubrique = {
"Restauration" : "#CA283B",
"Detente" : "#25AC22",
"Etudes" : "#CAC427"
};
/*
var barIcon = new L.Icon({
iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});*/

var detenteIcon = new L.Icon({
iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});


var schoolIcon = new L.Icon({
iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});

var restaurationIcon = new L.Icon({
iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});
/*
var schoolIcon = new L.Icon({
iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});*/

/*=======================================================================================================*/
/*============================= Liste bar / restaurant / parcs ... ======================================*/

var bars, parcs, culture, fastfood, lycees, universites;
var tableBars, tableParcs, tableCulture, tableFastFood, tableLycees, tableUniversites;
/* Ville active =========================*/

var ville_active = "Calais";
let VillesPositions = {
"Calais": {lat : 50.95129, lng : 1.858686},
"Dunkerque" : {lat : 51.034368, lng : 2.376776},
"Saint-Omer" : {lat : 50.750115, lng : 2.252208}
};

var filtre = {
"Bars" : [bars, tableBars],
"Parcs" : [parcs, tableParcs], 
"Culture" : [culture, tableCulture],
"FastFood" : [fastfood, tableFastFood],
"Lycees" : [lycees, tableLycees],
"Universites" : [universites, tableUniversites]};

var debutBouton = '<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">';
var finBouton = '</div></br>';

/* Fonction qui simplifie les adresse */

function limit_adresse(nom){
  texte = nom.split(",");
  if(parseInt(texte[0][0]) >= 0 || parseInt(texte[0][0] <= 9)){
    Tadresse.textContent = texte[0] + texte[1];
    texte = texte[0] + texte[1];
  }else{
    Tadresse.textContent = texte[0];
    texte = texte[0];
  }
  return texte;
}

function trouverAdresseBar(){
/* Bars ===========================================================================================*/

tableBars = [
  L.marker([50.9600393, 1.8506475], {icon : restaurationIcon}).bindPopup(debutBouton + 'Pop Rock' + finBouton), 
  L.marker([50.9603772,1.8484158], {icon : restaurationIcon}).bindPopup(debutBouton + 'Purple Cafe' + finBouton),
  L.marker([50.957105, 1.8482429], {icon : restaurationIcon}).bindPopup(debutBouton + 'La Betterave' + finBouton)];
var bars = L.layerGroup(tableBars);
filtre.Bars[0] = bars;
filtre.Bars[1] = tableBars;
}

function trouverAdresseParcs(){
/* Parcs ==========================================================================================*/

var urls = [
  new URL("https://nominatim.openstreetmap.org/search?q=Parc%20" + ville_active +"%2062100&format=json&limit=100"),
  new URL("https://nominatim.openstreetmap.org/search?q=Bois%20" + ville_active +"%2062100&format=json&limit=100")];
tableParcs = [];

for(var i_url = 0; i_url < urls.length; i_url++) {
  $.getJSON(urls[i_url], function(data) {
    for(var i = 0; i < data.length; i++){
      let regex1 = "Calais"
      if((data[i].type == "park" || data[i].type == "wood") && data[i].display_name.search(regex1) != -1){
        var nom = limit_adresse(data[i].display_name);
        var marqueur = L.marker([data[i].lat,data[i].lon], {icon : detenteIcon}).bindPopup(debutBouton + nom + finBouton);
        tableParcs.push(marqueur);
    }
    }
    parcs = L.layerGroup(tableParcs);
    filtre.Parcs[0] = parcs;
    filtre.Parcs[1] = tableParcs;
  });
};
}

function trouverAdresseCulture(){
/* Culture ========================================================================================*/

var urls = [
  new URL("https://nominatim.openstreetmap.org/search?q=Musee%20" + ville_active +"%2062100&format=json&limit=100"),
  new URL("https://nominatim.openstreetmap.org/search?q=Grand%20" + ville_active +"%2062100&format=json&limit=100"),
  new URL("https://nominatim.openstreetmap.org/search?q=Th%C3%A9atre%20plein%20" + ville_active +"%2062100&format=json&limit=100")];
tableCulture = [];

for(var i_url = 0; i_url < urls.length; i_url++) {
  $.getJSON(urls[i_url], function(data) {
    for(var i = 0; i < data.length; i++){
      let regex1 = "Calais"
      if((data[i].type == "museum" || data[i].type == "theatre") && data[i].display_name.search(regex1) != -1){
        var nom = limit_adresse(data[i].display_name);
        var marqueur = L.marker([data[i].lat,data[i].lon], {icon : detenteIcon}).bindPopup(debutBouton + nom + finBouton);
        tableCulture.push(marqueur);
    }
    }
    culture = L.layerGroup(tableCulture);
    filtre.Culture[0] = culture;
    filtre.Culture[1] = tableCulture;
  });
};
}

function trouverAdresseFastFood(){
/* FastFood =======================================================================================*/

var urls = [
  new URL("http://nominatim.openstreetmap.org/search?q=Burger%20King%20" + ville_active +"%2062100&format=json&limit=100"), 
  new URL("http://nominatim.openstreetmap.org/search?q=KFC%20" + ville_active +"%2062100&format=json&limit=100")];
tableFastFood = [];

for(var i_url = 0; i_url < urls.length; i_url++) {
  $.getJSON(urls[i_url], function(data) {
    for(var i = 0; i < data.length; i++){
      var nom = limit_adresse(data[i].display_name);
      var marqueur = L.marker([data[i].lat,data[i].lon], {icon : restaurationIcon}).bindPopup(debutBouton + nom + finBouton);
      tableFastFood.push(marqueur);
    }
    fastfood = L.layerGroup(tableFastFood);
    filtre.FastFood[0] = fastfood;
    filtre.FastFood[1] = tableFastFood;
  });
};
}

function trouverAdresseLycee(){
/* Lycées =========================================================================================*/

var url = new URL("https://nominatim.openstreetmap.org/search?q=Lyc%C3%A9e%20" + ville_active +"%2062100&format=json&limit=100");
tableLycees = [];

$.getJSON(url, function(data) {
  for(var i = 0; i < data.length; i++){
    let regex1 = "Calais"
    if(data[i].type == "school" && data[i].display_name.search(regex1) != -1){
      var nom = limit_adresse(data[i].display_name);
      var marqueur = L.marker([data[i].lat,data[i].lon], {icon : schoolIcon}).bindPopup(debutBouton + nom + finBouton);
      tableLycees.push(marqueur);
    }
  }
  lycees = L.layerGroup(tableLycees);
  filtre.Lycees[0] = lycees;
  filtre.Lycees[1] = tableLycees;
});
}

function trouverAdresseUniversite(){
/* Université =====================================================================================*/

var url = new URL("https://nominatim.openstreetmap.org/search?q=Universit%C3%A9%20" + ville_active +"%2062100&format=json&limit=100");
tableUniversites = [];

$.getJSON(url, function(data) {
  for(var i = 0; i < data.length; i++){
    let regex1 = "Calais";
    if(data[i].type == "college" && data[i].display_name.search(regex1) != -1 && data[i].display_name.search("62100") != -1){
      var nom = limit_adresse(data[i].display_name);
      var marqueur = L.marker([data[i].lat,data[i].lon], {icon : schoolIcon}).bindPopup(debutBouton + nom + finBouton);
      tableUniversites.push(marqueur);
    }
  }
  universites = L.layerGroup(tableUniversites);
  filtre.Universites[0] = universites;
  filtre.Universites[1] = tableUniversites;
});
}

function trouverAdresseFiltre(){
  trouverAdresseBar();
  trouverAdresseCulture();
  trouverAdresseFastFood();
  trouverAdresseLycee();
  trouverAdresseParcs();
  trouverAdresseUniversite();
}

trouverAdresseFiltre();

/*=======================================================================================================*/
/*========================================= Var section / boutons ... ===================================*/

/* boutons ===============================*/
let Bmap = document.getElementById("map");
let Bactu = document.getElementById("actu");
let BcloseNotation = document.getElementById("closeNotation");
let BcloseCreerArticle = document.getElementById("closeCreerArticle");
let BcreerArt = document.getElementById("note");
let Bcheckbox = document.getElementById("checkbox");
let Badressenote = null;
let Bsearch = document.getElementById("div-search");
let Bloupe = document.getElementById("la-loupe");
let Bcalais = document.getElementById("ville_Calais");
let Bdunkerque = document.getElementById("ville_Dunkerque");
let Bsaintomer = document.getElementById("ville_Saint-Omer");
// like dislike report
let Bup = document.querySelectorAll(".up");
let Bdown = document.querySelectorAll(".down");
let Breport = document.querySelectorAll(".report");

/* Test ==================================*/
let Tadresse = document.getElementById("batiment-name");
let Tville = document.getElementById("ville-name-notation");

/* Input =================================*/

/* GPS ===================================*/
let Bgps = document.getElementById("itineraire");
let Bouigps = document.getElementById("oui-gps");
let Bnongps = document.getElementById("non-gps");
let Stitlegps = document.getElementById("title-gps");
let Sitineraire = document.getElementById("itineraire-gps");

/* Sections ==============================*/
let Sfooter = document.getElementById("le-footer");
let Smap = document.getElementById("pages-map");
let Sactu = document.getElementById("pages-actu");
let Snotation = document.getElementById("section-notation");
let Sgps = document.getElementById("section-gps");
let ScreerArt = document.getElementById("section-creer-article");
let SpartieMap = document.getElementById("section-map");
let SpartieActu = document.getElementById("section-fil-actu");
let Spages = document.getElementById("pages");
let Savi = document.getElementById("section-avis");
let Scheckbox = document.querySelector("div:has(> .command)");

/* Checkbox ==============================*/
let Lcheckbox = document.querySelectorAll(".command form input");

/* Texte ==============================*/
var Villedesfiltres = document.getElementById("ville-des-filtres");

/* Enregistrement des villes */

let Bvilles = document.querySelectorAll(".button-villes");

/* Liste des codes pour chaque villes (à faire plus tard) */
let CodesVilles = new Object();

for(var i = 0; i < Bvilles.length; i++){
switch(Bvilles[i].firstChild.textContent){
  case "Calais" : CodesVilles[Bvilles[i].firstChild.textContent] = [62100]; break;
  case "Dunkerque" : CodesVilles[Bvilles[i].firstChild.textContent] = [59140, 59240, 59760, 59430, 59640, 59210, 59495]; break;
  case "Calais" : CodesVilles[Bvilles[i].firstChild.textContent] = [14220, 60860, 62162, 62500]; break;
  case "Blendecques" : CodesVilles[Bvilles[i].firstChild.textContent] = [62575]; break
}
}

/*=======================================================================================================*/
/*============================= Meteo ===================================================================*/

function weather(){
  let url = new URL("https://api.openweathermap.org/data/2.5/weather?q=" + ville_active + "&appid=c21a75b667d6f7abb81f118dcf8d4611&units=metric");
  $.getJSON(url, function(data) {
    switch (data.weather[0].main){
      case "Rain": document.getElementById("meteo").innerHTML = "rainy"; break;
      case "Clouds": document.getElementById("meteo").innerHTML = "partly_cloudy_day"; break;
      case "Clear": document.getElementById("meteo").innerHTML = "clear_day"; break;
    }
  });
}

/*=======================================================================================================*/
/*============================= Heure ===================================================================*/

function sleep(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}

function setTimeAnimation(h){
  if(h > 7 && h < 21){
    document.getElementById("time-animation").innerHTML = "sunny";
  }else{
    document.getElementById("time-animation").innerHTML = "nightlight";
  }
}

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
  jour = convertJ(jour);
  mois = convertM(mois+1);
  h = checkTime(h);
  m = checkTime(m);
  document.getElementById('time').innerHTML =
  jour + " " + njour + " " + mois + "  -  " + h + ":" + m;
  document.getElementById("gradient").style.background = couleur;
  weather();
  setTimeAnimation(h);
  var t = setTimeout(startTime, 1000);
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
function checkTime(i) {
  if (i < 10) {i = "0" + i};
  return i;
}
function convertJ(jour) {
  var lejour;
  switch (jour) {
    case 1: lejour = "Lundi"; break;
    case 2: lejour = "Mardi"; break;
    case 3: lejour = "Mercredi"; break;
    case 4: lejour = "Jeudi"; break;
    case 5: lejour = "Vendredi"; break;
    case 6: lejour = "Samedi"; break;
    default: lejour = "Dimanche"; break;
  }
  return lejour;
}
function convertM(mois) {
  var lemois;
  switch (mois) {
    case 1: lemois = "Janvier"; break;
    case 2: lemois = "Février"; break;
    case 3: lemois = "Mars"; break;
    case 4: lemois = "Avril"; break;
    case 5: lemois = "Mai"; break;
    case 6: lemois = "Juin"; break;
    case 7: lemois = "Juillet"; break;
    case 8: lemois = "Août"; break;
    case 9: lemois = "Septembre"; break;
    case 10: lemois = "Octobre"; break;
    case 11: lemois = "Novembre"; break;
    case 12: lemois = "Décembre"; break;
  }
  return lemois;
}
 
startTime();

/*=======================================================================================================*/
/*========================================= detection input change villes ===============================*/

let inputVilles = document.getElementById("input-villes");

inputVilles.onkeyup = function(){
for(var i = 0; i < Bvilles.length; i++){
  if(inputVilles.value.length != 0){
    var ville = inputVilles.value;
    ville = ville.replace(ville[0], ville[0].toUpperCase());
    for(var k = 1; k < ville.length; k++){
      ville = ville.replace(ville[k], ville[k].toLowerCase());
    }
    if(Bvilles[i].firstChild.textContent.search(ville) == -1){
      Bvilles[i].style.display = "none";
    }else{
      Bvilles[i].style.display = "block";
    }
  }else{
    Bvilles[i].style.display = "block";
  }
}
}

/*=======================================================================================================*/
/*========================================= detection section filtre ====================================*/

// checkbox command

let CcheckBox = document.querySelectorAll("div form input[type=checkbox]");
let Scommand = document.querySelector(".command");

function resetFiltresBox(){
for(var i = 0; i < CcheckBox.length; i++){
  CcheckBox[i].checked == false;
}
}

function center_adresse(elts){
  var dist_max_V = 0;
  var dist_max_H = 0;
  var Point = [elts[0]._latlng.lat,elts[0]._latlng.lng];

  for(var i = 0; i < elts.length; i++){
    for(var j = i; j < elts.length; j++){
      if(i != j){
        var distV = Math.abs(Number(elts[i]._latlng.lat) - Number(elts[j]._latlng.lat));
        var distH = Math.abs(Number(elts[i]._latlng.lng) - Number(elts[j]._latlng.lng));
        if(distH > dist_max_H){
          dist_max_H = distH;
          Point[0] = (elts[i]._latlng.lat + elts[j]._latlng.lat) / 2;
        }
        if(distV > dist_max_V){
          dist_max_V = distV;
          Point[1] = (elts[i]._latlng.lng + elts[j]._latlng.lng) / 2;
        }
      }
    }
  }
  return [Point, dist_max_H, dist_max_V];
}

function taille_max_map(p){
  return 180 / Math.pow(2, p);
}

function add_Marker_lieu(e){
  // On vérifie si le marqueur existe déjà
  if (marqueur != undefined) {
    // Si oui, on le retire
    mymap.removeLayer(marqueur);
  }
  switch (e.id) {
    case 'Bars': //trouverAdresseBar();
                var type_filtre = 'Bars';
                break;
    case 'Parcs': //trouverAdresseParcs();
                var type_filtre = 'Parcs';
                break;
    case 'Culture': //trouverAdresseCulture();
                var type_filtre = 'Culture';
                break;
    case 'FastFood': //trouverAdresseFastFood();
                var type_filtre = 'FastFood';
                break;
    case 'Lycees': //trouverAdresseLycee();
                var type_filtre = 'Lycees';
                break;
    case 'Universites': //trouverAdresseUniversite();
                var type_filtre = 'Universites';
                break;
  }

  setTimeout(() => {
    filtre[type_filtre][0].addTo(mymap);
    var center = center_adresse(filtre[type_filtre][1])[0];
    var dist_max_H = center_adresse(filtre[type_filtre][1])[1];
    var dist_max_V = center_adresse(filtre[type_filtre][1])[2];
    if(dist_max_H > dist_max_V){
      var view = 18 - (dist_max_H) / taille_max_map(12) * (18 - 13);
    }else{
      var view = 18 - (dist_max_V) / taille_max_map(14) * (18 - 13);
    }
    mymap.setView(center, 14); //
  }, "50")
}

function remove_Marker_lieu(e){
  mymap.removeLayer(filtre[e.id][0]);
  switch (e.id) {
    case 'Bars': mymap.removeLayer(filtre.Bars); break;
    case 'Parcs': mymap.removeLayer(filtre.Parcs); break;
    case 'Culture': mymap.removeLayer(filtre.Culture); break;
    case 'FastFood': mymap.removeLayer(filtre.FastFood); break;
    case 'Lycees': mymap.removeLayer(filtre.Lycees); break;
    case 'Universites': mymap.removeLayer(filtre.Universites); break;
  }
  let url = new URL("http://nominatim.openstreetmap.org/search?q=" + ville_active + "&format=json&limit=1");
  $.getJSON(url, function(data) {
    let pos = {lat : data[0].lat, lng : data[0].lon};
    mymap.setView(pos, 13);
  });
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
/*============================== Menu déroulant VILLE clique ============================================*/

/* Init style menu déroulant */

function init_couleur_menu_deroulant(){
  for(var i = 0; i < rubriques.length; i++) {
    
  }
}

init_couleur_menu_deroulant();

/* clique */

let BderoulantVille = document.querySelector(".command div span#ville_selector_menu");

function deroulant_ville(e) {
  var new_e = e.target.parentElement.parentElement.parentElement.childNodes;
  if(Number(e.target.parentElement.getAttribute("data-value")) == 1){
    for(var i = 1; i < new_e.length; i++) {
      new_e[i].style.height = "0";
      new_e[i].style.transform = "scaleY(0)";
    }
  }else{
    for(var i = 1; i < new_e.length; i++) {
      new_e[i].style.height = "100%";
      new_e[i].style.transform = "scaleY(1)";
    }
  }
  e.target.parentElement.setAttribute("data-value", (Number(e.target.parentElement.getAttribute("data-value"))+1)%2);
}

BderoulantVille.addEventListener('click', deroulant_ville, false);

/*=======================================================================================================*/
/*============================== Menu déroulant FILTRE clique ===========================================*/

/* Init style menu déroulant */

function init_couleur_menu_deroulant(){
  for(var i = 0; i < rubriques.length; i++) {
    document.getElementById(rubriques[i][0]).style.backgroundColor = couleur_rubrique[rubriques[i][0]];
  }
}

init_couleur_menu_deroulant();

/* clique */

let Bderoulant = document.querySelectorAll(".command div form.category_title");

function deroulant_filtre(e) {
  var new_e = e.target.parentElement;
  for(var i = 0; i < Bderoulant.length; i++) {
    if(new_e.firstChild == Bderoulant[i].firstChild){
      Bderoulant[i].firstChild.setAttribute("data-value", (Number(Bderoulant[i].firstChild.getAttribute("data-value"))+1)%2);
      Bderoulant[i].firstChild.style.transform = "rotate(" + Number(Bderoulant[i].firstChild.getAttribute("data-value"))*90 + "deg)";
    }
    var filtreCache = document.querySelectorAll("form + ." + new_e.lastChild.id);
    for(var filtre_i of filtreCache){
      filtre_i.setAttribute("data-value", (Number(filtre_i.getAttribute("data-value"))+1)%2);
      if(Number(filtre_i.getAttribute("data-value") == 0)){
        filtre_i.style.height = "0px";
        filtre_i.style.transform = "scaleY(0)";
      }else{
        filtre_i.style.height = "100%";
        filtre_i.style.transform = "scaleY(1)";
      }
    }
  }
}

for(var i = 0; i < Bderoulant.length; i++){
  Bderoulant[i].addEventListener('click', deroulant_filtre, false);
}

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
/*============================================ GPS ======================================================*/

Bouigps.onclick = function() {
  Stitlegps.style.transition = "0.3s";
  Stitlegps.style.transform = "translate(-100%,0px)";
  Sitineraire.style.transition = "0.3s";
  Sitineraire.style.transform = "translate(0px,0px)";
  var localisation = "Pas d'accès encore";
  document.getElementById("input-depart-gps").value = localisation;
  document.getElementById("input-arrivee-gps").value = texte;
}

Bnongps.onclick = function() {
  Stitlegps.style.transition = "0.3s";
  Stitlegps.style.transform = "translate(-100%,0px)";
  Sitineraire.style.transition = "0.3s";
  Sitineraire.style.transform = "translate(0px,0px)";
  document.getElementById("input-arrivee-gps").value = texte;
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
    Bsearch.style.transform = "scale(0,0)";
    Bloupe.style.borderRadius = "40%";
  }
  else {
    Bsearch.style.transform = "scale(1,1)";
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
Scheckbox.style.display = "block";
  var ScheckboxPosition = 0;
  Bcheckbox.onclick = function() {
  if(ScheckboxPosition == 0){
    Scheckbox.style.transform = "scaleY(0)";
    ScheckboxPosition = 1;
  }else{
    Scheckbox.style.transform = "scaleY(1)";
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

var Bnotation = document.getElementById("adresse-note");

/* ajouter un marqueur et supprimer le précédent */
function addMarker(pos, nom, code) {
  for(var i = 0; i < Lcheckbox.length; i++) {
    Lcheckbox[i].checked = false;
  }

  mymap.removeLayer(filtre.Bars);
  mymap.removeLayer(filtre.Culture);
  mymap.removeLayer(filtre.Parcs);
  mymap.removeLayer(filtre.FastFood);
  mymap.removeLayer(filtre.Lycees);
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
  Tville.textContent = ville_active; // Si Calais
  if (index !== -1) {
    texte = nom.split(",");
    if(parseInt(texte[0][0]) >= 0 || parseInt(texte[0][0] <= 9)){
      Tadresse.textContent = texte[0] + texte[1];
      texte = texte[0] + texte[1];
    }else{
      Tadresse.textContent = texte[0];
      texte = texte[0];
    }
  } else {
    texte = nom;
    Tadresse.textContent = nom;
  }

  //marqueur.addTo(mymap);
  /*L.marker(pos).addTo(mymap).bindPopup('Your point is at <\br>' + result.address.Match_addr).openPopup();*/

  if(nom.search(" " + code + ",") != -1){ 
    marqueur.addTo(mymap).bindPopup('<h1>Adresse du lieu : </h1><div class="button anim-button" id="adresse-note">' + texte + '</div></br>').openPopup();
  }else{
      marqueur.addTo(mymap).bindPopup('<h1>Adresse du lieu : </h1><p>' + texte + '</p>').openPopup();
  }
  
  if(nom.search(" " + code + ",") != -1){  
    marqueur.addTo(mymap).bindPopup('<div id="element-popup"><h1>Adresse du lieu : </h1><div id="boutons-popup"><div class="button anim-button" id="adresse-note">' + texte + '</div><div class="button anim-button" id="itineraire"><span class="material-symbols-outlined">google_plus_reshare</span></div></div></br></div>').openPopup();
  }else{
      marqueur.addTo(mymap).bindPopup('<h1>Adresse du lieu : </h1><p>' + texte + '</p>').openPopup();
  }
    
  Bnotation = document.getElementById("adresse-note");
  Bgps = document.getElementById("itineraire");
  mymap.setView([pos.lat, pos.lng]);
};


/* Activation bouton pour acceder au avis de l'adresse */
function boutonavis(e) {
  if (Bnotation != null) {
    if (e.target.id == Bnotation.id) {
      Sgps.style.transition = "0.3s";
      Sgps.style.transform = "translate(-100%,0px)";
      Snotation.style.transition = "0.3s";
      Bcheckbox.style.display = "none";
      Snotation.style.transform = "translate(0px,0px)";
    }
  }
}

Smap.addEventListener('click', boutonavis, false);

function boutongps(e) {
  if (Bgps != null) {
    if (e.target.parentElement.id == Bgps.id || e.target.id == Bgps.id) {
      /*let ContentPopup = document.getElementById("element-popup");
      ContentPopup.innerHTML = '<h3>Voulez-vous autoriser Ev\'Note à accéder à votre localisation ?</h3><div id="boutons-popup"><div class="button anim-button" id="oui-gps">Oui</div><div class="button anim-button" id="non-gps">Non</div></div></br>';*/
      Sgps.style.transition = "0.3s";
      Sgps.style.transform = "translate(0px,0px)";
      Stitlegps.style.transition = "0.3s";
      Stitlegps.style.transform = "translate(0,0px)";
      Sitineraire.style.transition = "0.3s";
      Sitineraire.style.transform = "translate(-100%,0px)";
    }
  }
}
Smap.addEventListener('click', boutongps, false);

/* Si on clique sur la map */
mymap.on('click', function(e) {
  if(e.originalEvent.path.length < 12){
    Snotation.style.transition = "0s";
    Snotation.style.transform = "translate(-100%,0px)";
    Sgps.style.transition = "0.3s";
    Sgps.style.transform = "translate(-100%,0px)";
    Stitlegps.style.transition = "0.3s";
    Stitlegps.style.transform = "translate(-100%,0px)";
    Sitineraire.style.transition = "0.3s";
    Sitineraire.style.transform = "translate(-100%,0px)";
    // On récupère les coordonnées du clic
    pos = e.latlng;
    let url = new URL("http://nominatim.openstreetmap.org/search?q=" + pos.lat + "%20" + pos.lng + "&format=json&limit=1");
    
    $.getJSON(url, function(data) {
      var i = 0;
      for(i; i < CodesVilles[ville_active].length; i++) {
        if(data[0].display_name.search(" " + CodesVilles[ville_active][i] + ",") != -1/* || data[0].display_name.search(" " + ville_active + ",") != -1*/){
          addMarker(pos, data[0].display_name, CodesVilles[ville_active][i]);
          i =CodesVilles[ville_active].length*CodesVilles[ville_active].length;
        }else{
        }
      }
      if(i == CodesVilles[ville_active].length){
        pos = VillesPositions[ville_active];
        addMarker(pos, "Destination impossible");
      }
    });
    if(i == CodesVilles[ville_active].length){
      pos = VillesPositions[ville_active];
      addMarker(pos, "Destination impossible");
    }
  }
});

/* Si on clique sur la loupe */
function searchAdresse() {
  Sgps.style.transition = "0.3s";
  Sgps.style.transform = "translate(-100%,0px)";
  let adresse = Isearch.value;
  let regex = "[Cc][Aa][Ll][Aa][Ii][Ss]"
  if(adresse.search(regex) == -1){
    adresse = adresse + " Calais";
  }
  adresse.replace(" ", "%20");
  let url = new URL("http://nominatim.openstreetmap.org/search?q=" + adresse + "&format=json&limit=1");
  $.getJSON(url, function(data) {
    if(data.length != 0){
      if(data[0].display_name.search(" " + ville_active) != -1){
        let pos = {lat : data[0].lat, lng : data[0].lon};
        addMarker(pos, data[0].display_name);
      }else{
        pos = VillesPositions[ville_active];
        addMarker(pos, "Destination impossible");
      }
    }
  });
}


Bloupe.addEventListener('click', searchAdresse, false);

Bsearch.addEventListener('change', searchAdresse, false);

/*=======================================================================================================*/
/*===================================================== boutons villes ===================================*/



for(var i = 0; i < Bvilles.length; i++){
  Bvilles[i].onclick = function(e) {  
    resetFiltresBox();
    let Chargement = document.getElementById("page-chargement");
    Chargement.style.transform = "translateY(0px)";
    
      trouverAdresseFiltre();

      ville_active = e.target.firstChild.textContent;
      let url = new URL("http://nominatim.openstreetmap.org/search?q=" + ville_active + "&format=json&limit=1");
      $.getJSON(url, function(data) {
        let pos = {lat : data[0].lat, lng : data[0].lon};
        mymap.setView(pos, 11, {animate: true, duration: 2000});
        addMarker(pos, ville_active);
        Villedesfiltres.textContent = ville_active;
      });
  }
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
/*========================================= Slider actu =================================================*/

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


/*=======================================================================================================*/
/*========================================= Génération avis =============================================*/

console.log(mes_clients);
console.log("oucoc");

saluer();