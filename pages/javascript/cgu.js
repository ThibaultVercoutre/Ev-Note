let ElementsNav = document.querySelectorAll("#menu nav p");
let TitresCGU = document.querySelectorAll(".categories");
var PositionTitreCGU = [];

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
    }
}

for(var i = 0; i < ElementsNav.length; i++){
    ElementsNav[i].onclick = function(e){
        console.log(e.target.className, PositionTitreCGU[parseInt(e.target.className-1)]);
        window.scrollTo({
            top: PositionTitreCGU[parseInt(e.target.className-1)] - 75,
            behavior: 'smooth'
          })
        resetMenu(e.target.parentElement);
        e.target.style.backgroundColor = "#4D98BF";
    };
    //ElementsNav[i].addEventListener('click', scrollPage(ElementsNav, i), false);
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


