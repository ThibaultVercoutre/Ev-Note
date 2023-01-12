let ElementsNav = document.querySelectorAll("#menu nav p");
//let ElementsNavUnderline = document.querySelectorAll("#menu nav div");
let TitresCGU = document.querySelectorAll(".categories");
var PositionTitreCGU = [];

//console.log(ElementsNavUnderline[0].nextElementSibling);

window.onload = () => {

    for(var i = 0; i < TitresCGU.length; i++){
        PositionTitreCGU[i] = TitresCGU[i].offsetTop;
    }
    
    console.log(PositionTitreCGU);
}

//console.log(TitresCGU[0].offsetTop);

function resetMenu(elts){
    elts = elts.childNodes;
    for(var i = 1; i < elts.length; i += 2){
        elts[i].style.backgroundColor = "";
        elts[i].setAttribute("value", "0");
    }
}

for(var i = 0; i < ElementsNav.length; i++){
    ElementsNav[i].onclick = function(e){
        console.log(e.target.className, PositionTitreCGU[parseInt(e.target.className-1)]);
        window.scrollTo({
            top: PositionTitreCGU[parseInt(e.target.className-1)] - 52,
            behavior: 'smooth'
          })
        resetMenu(e.target.parentElement);
        e.target.setAttribute("value", "1");
        e.target.style.backgroundColor = "#4D98BF";
        e.target.nextElementSibling.style.transform = "scaleX(0)";
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

/*
window.addEventListener("scroll", () => {
    for(var i = 0; i < TitresCGU.length; i++) {
        if(TitresCGU[parseInt(i)].offsetTop <= document.body.scrollTop){
            resetMenu(ElementsNav[i].parentElement);
            ElementsNav[i].style.backgroundColor = "#4D98BF";
            console.log(TitresCGU[parseInt(i)].textContent);
        }
    };
});*/


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