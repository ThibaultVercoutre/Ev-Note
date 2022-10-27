let Bmap = document.getElementById("map");
let Bactu = document.getElementById("actu");
let Bnotation = document.getElementById("notation");
let BcloseNotation = document.getElementById("closeNotation");
let BcloseCreerArticle = document.getElementById("closeCreerArticle");
let BcreerArt = document.getElementById("note");

let Tadresse = document.getElementById("batiment-name");
let Sfooter = document.getElementById("le-footer");

let Badressenote = null;

let Bsearch = document.getElementById("div-search");
let Isearch = document.getElementById("search");
let Bloupe = document.getElementById("loupe");

let Smap = document.getElementById("pages-map");
let Sactu = document.getElementById("pages-actu");
let Snotation = document.getElementById("section-notation");
let ScreerArt = document.getElementById("section-creer-article");

let SpartieMap = document.getElementById("section-map");

let Spages = document.getElementById("pages");

var mymap = L.map('section-map').setView([50.95129, 1.858686], 11);  // Variable qui permettra de stocker la carte

var marqueur = L.marker([50.95129, 1.858686]).addTo(mymap);//.bindPopup('<h1>Adresse du lieu : </h1><div class="button drop" id="adresse-note">Calais</br>').openPopup();
// On attend que le DOM soit chargé

window.onload = () => {
  // Nous initialisons la carte et nous la centrons sur Paris

  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '',
    minZoom: 13,
    maxZoom: 18
  }).addTo(mymap);


  //var command = L.control({position: 'topright'});
  
};


var cats = ["Bars", "Parcs", "Macdos", "Lycées"];
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

//Boutons zoom

let Dzoom = document.querySelector(".leaflet-control-zoom");
Dzoom.style.border = "0px";

let Dzoomin = document.querySelector(".leaflet-control-zoom-in");
let Dzoomout = document.querySelector(".leaflet-control-zoom-out");
Dzoomin.style.borderRadius = "8px 8px 0px 0px";
Dzoomout.style.borderRadius = "0px 0px 8px 8px";

//========================================================================


// ScrollBar =============================================================

let SremplirArt = document.getElementById("champ-remplit-art");
const progressBar = document.querySelector('.scrollbar');
const progressBarClick = document.querySelector(".clickScrollbar");
const Bscroll = document.getElementById("scroll");
const Cscroll = document.querySelector("#scroll > .carre");

SremplirArt.addEventListener("scroll", () => {
  let totalHeight = SremplirArt.scrollHeight - SremplirArt.clientHeight;
  let progress = (SremplirArt.scrollTop / totalHeight) * 100;
  progressBar.style.height = `${progress}%`;
  progressBar.style.opacity = `${progress}%`;
})

window.addEventListener("scroll", () => {
  if (document.documentElement.scrollTop != 0) {
    Cscroll.style.transform = "rotate(180deg)";
  } else {
    Cscroll.style.transform = "rotate(0deg)";
  }
})



progressBarClick.addEventListener("click", (e) => {
  let totalHeight = SremplirArt.scrollHeight - SremplirArt.clientHeight;
  let newPageScroll = e.layerY / progressBarClick.offsetHeight * totalHeight;
  SremplirArt.scrollTo({
    top: newPageScroll,
    behavior: 'smooth'
  })
})

progressBarClick.addEventListener("mouseenter", () => {
  progressBar.style.width = "15px";
  progressBarClick.style.width = "15px";
})

progressBarClick.addEventListener("mouseleave", () => {
  progressBar.style.width = "8px";
  progressBarClick.style.width = "8px";
})

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

// =======================================================================

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

function affiche(S, S2) {
  if (S == Smap) {
    S.style.transform = "scaleX(1)";
    S2.style.transform = "scaleX(0)";
    progressBar.style.width = "0px";
    progressBarClick.style.width = "0px";
    BcreerArt.style.display = "none";
  }
  if (S == Sactu) {
    ScreerArt.style.display = "block";
    S.style.transform = "scaleX(1)";
    S2.style.transform = "scaleX(0)";
    progressBar.style.width = "8px";
    progressBarClick.style.width = "8px";
    BcreerArt.style.display = "block";
  }
}

function afficheBarre(S) {
  if (S == Sactu) {
    S.style.opacity = 1;
    Bsearch.style.transform = "scale(0,0.5)";
    Bloupe.style.borderRadius = "40%";
  }
  else {
    Bsearch.style.transform = "scale(1,1)";
    Isearch.style.borderRadius = ".9rem 0% 0% .9rem";
    Bloupe.style.borderRadius = "0% 40% 40% 0%";
  }
}

//resetStyle(Smap, Sactu);

affiche(Smap, Sactu);
//ScreerArt.style.transform = "scaleY(0)";

Bmap.onclick = function() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
  Snotation.style.transform = "translate(-100%,0px)";
  afficheBarre(Smap);
  affiche(Smap, Sactu);
};

Bactu.onclick = function() {
  Snotation.style.transform = "translate(-100%,0px)";
  afficheBarre(Sactu);
  affiche(Sactu, Smap);
};

BcreerArt.onclick = function() {
  ScreerArt.style.transition = "0.3s";
  ScreerArt.style.transform = "translate(0px,0px) scaleY(1)";
}

BcloseNotation.onclick = function() {
  Snotation.style.transform = "translate(-100%,0px)";
}

BcloseCreerArticle.onclick = function() {
  ScreerArt.style.transform = "translate(100%,0px) scaleY(0)";
}

/*
Bnote.onclick = function() {
  resetStyle(Snotation, Smap);
  affiche(Snotation, Smap);
};*/

function addMarker(pos, result) {
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

  Tadresse.textContent = result.address.Match_addr;

  //marqueur.addTo(mymap);
  /*L.marker(pos).addTo(mymap).bindPopup('Your point is at <\br>' + result.address.Match_addr).openPopup();*/
  marqueur.addTo(mymap).bindPopup('<h1>Adresse du lieu : </h1><div class="button" id="adresse-note">' + result.address.Match_addr + '</br>').openPopup();

  Bnotation = document.getElementById("adresse-note");

};

function test(e) {
  if (Bnotation != null) {
    if (e.target.id == Bnotation.id) {
      Snotation.style.transition = "0.3s";
      Snotation.style.transform = "translate(0px,0px)";
    }
  }
}

Smap.addEventListener('click', test, false);

var geocodeService = L.esri.Geocoding.geocodeService();
var message;

mymap.on('click', function(e) {
  console.log(e.originalEvent.path);
  if(e.originalEvent.path.length != 13){
    Snotation.style.transition = "0s";
    Snotation.style.transform = "translate(-100%,0px)";
    // On récupère les coordonnées du clic
    pos = e.latlng;

    //console.log(pos.lat, pos.lng);

    geocodeService.reverse().latlng(e.latlng).run(function(error, result) {
      if (error) {
        return;
      }
      // On crée un marqueur
      addMarker(pos, result);
    })
  }
});

Bloupe.onclick = function() {
  let adresse = Isearch.value;
  let regex = "[Cc][Aa][Ll][Aa][Ii][Ss]"
  if(adresse.search(regex) == -1){
    adresse = adresse + " Calais";
  }
  adresse.replace(" ", "%20");
  let url = new URL("http://nominatim.openstreetmap.org/search?q=" + adresse + "&format=json&limit=1");
  $.getJSON(url, function(data) {
    latitude = data[0].lat;
    longitude = data[0].lon;
    retour = latitude + "," + longitude;
    console.log(longitude, latitude);
  });
  
}