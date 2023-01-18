let ElementsNav = document.querySelectorAll("#menu nav p");
let TitresCGU = document.querySelectorAll(".categories_pos");
var PositionTitreCGU = [];

window.onload = () => {

    for(var i = 0; i < TitresCGU.length; i++){
        PositionTitreCGU[i] = TitresCGU[i].offsetTop;
    }
}

function resetMenu(elts){
    elts = elts.childNodes;
    for(var i = 1; i < elts.length; i += 2){
        elts[i].style.backgroundColor = "";
        elts[i].setAttribute("value", "0");
    }
}

function DoColors(e){
  resetMenu(e.parentElement);
  e.setAttribute("value", "1");
  e.style.backgroundColor = "#4D98BF";
  e.nextElementSibling.style.transform = "scaleX(0)";
}

for(var i = 0; i < ElementsNav.length; i++){
    ElementsNav[i].onclick = function(e){
        window.scrollTo({
            top: PositionTitreCGU[parseInt(e.target.className-1)] - 52,
            behavior: 'smooth'
          })
        DoColors(e.target);
        
    };
    ElementsNav[i].addEventListener("mouseenter", (e) => {
        if(e.target.getAttribute("value") != "1"){
            e.target.nextElementSibling.style.transform = "scaleX(1)";
        }
    });
    ElementsNav[i].addEventListener("mouseout", (e) => {
        e.target.nextElementSibling.style.transform = "scaleX(0)";
    });
}

window.onscroll = function() {
  for(var i = 1; i < PositionTitreCGU.length; i++) {
    const scrollPosition = window.pageYOffset;
    if(scrollPosition >= PositionTitreCGU[i-1] - 60 && scrollPosition < PositionTitreCGU[i] - 60){
      DoColors(ElementsNav[i-1]);
    }

  }
};

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