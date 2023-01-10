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