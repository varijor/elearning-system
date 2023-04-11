$(document).ready(function () {
    $(window).scroll(function () {
        if (this.scrollY > 20) {
            $('.navbar').addClass("sticky");
        } else {
            $('.navbar').addClass("sticky");
        }
    });
});

document.querySelector('nav').classList.add("sticky");
document.getElementById("import").remove();
var pocitadlo = 0;
var cisloOtazky = 0;
const form = document.querySelector("form");
var button = document.getElementById("submit-btn");
var hiddenButtons = document.querySelector(".hidden-buttons");

function nextQuestion() {
    var removedQuestion = document.querySelector(".active #removedQuestion");
    if(removedQuestion !== null){
        removedQuestion.classList.remove('showRemovedQuesion');
    }
    if(validateForm(2)) {
        var box = document.getElementsByClassName("box");
        hiddenButtons.classList.remove('hidden-buttons');
        box[pocitadlo].classList.remove("active");
        if(box.length-pocitadlo !== 1){
            pocitadlo++;
            box[pocitadlo].classList.add("active");
         } else {
            pocitadlo++;
            cisloOtazky++;
            var x = document.createElement('div');
            x.classList.add("box");
            x.innerHTML = `<div class="inputs">
                <h3>Otázka číslo `+String(cisloOtazky)+` </h3>
                <h5 id="radioh5">Vyberte správnu odpoveď!</h5>
                <h5 id="removedQuestion">Otázka bola vymazaná!</h5>
                <div class="flex">
                <div>
                    <input type="text" class="ins"  placeholder="Otázka" name="q`+String(cisloOtazky)+`">
                    <input type="text" class="ins" placeholder="Možnosť 1" name="q`+String(cisloOtazky)+`opt1">
                    <input type="text" class="ins" placeholder="Možnosť 2" name="q`+String(cisloOtazky)+`opt2">
                    <input type="text" class="ins" placeholder="Možnosť 3" name="q`+String(cisloOtazky)+`opt3">
                    <input type="text" class="ins" placeholder="Možnosť 4" name="q`+String(cisloOtazky)+`opt4">
                </div>
                    <div id="radios">
                        <input type="radio" class="odpoved" name="spravnaOdpoved`+String(cisloOtazky)+`" value="1">
                        <input type="radio" class="odpoved" name="spravnaOdpoved`+String(cisloOtazky)+`" value="2">
                        <input type="radio" class="odpoved" name="spravnaOdpoved`+String(cisloOtazky)+`" value="3">
                        <input type="radio" class="odpoved" name="spravnaOdpoved`+String(cisloOtazky)+`" value="4">
                    </div>
                </div>
                </div>`;
            document.getElementById("wrapper").appendChild(x);
        }
        box = document.getElementsByClassName("box");
        box[pocitadlo].classList.add("active");
    }
}

function prevQuestion() {
    box = document.getElementsByClassName("box");
    var removedQuestion = document.querySelector(".active #removedQuestion");
    if(removedQuestion !== null){
        removedQuestion.classList.remove('showRemovedQuesion');
    }
    if(pocitadlo!==0){
        box[pocitadlo].classList.remove("active");
        pocitadlo--;
        box[pocitadlo].classList.add("active");
        if(pocitadlo===0){
            hiddenButtons.classList.add('hidden-buttons');
        }
    }
}

function removeQuestion(){
    box = document.getElementsByClassName("box");
    active = document.getElementsByClassName("active");
    if(box.length!==1){
        box[box.length-1].parentNode.removeChild(box[box.length-1]);
        box[box.length-1].classList.add("active");
        cisloOtazky--;
        pocitadlo--;
        var removedQuestion = document.querySelector(".active #removedQuestion");
        removedQuestion.classList.add('showRemovedQuesion');
    }
}

function validateForm(a) {
    var h5 = document.querySelector(".active #radioh5");
    var inputs;
    var check = document.querySelectorAll(".active .odpoved:checked");
    var x = true;
    if(a==1){
        inputs = document.querySelectorAll(".inputs .ins");
    }
    if(a==2){
        inputs = document.querySelectorAll(".active .inputs .ins");
    }
    for (i = 0; i < inputs.length; i++) {
        if(inputs[i].value ===''){
            inputs[i].focus();
            inputs[i].classList.add('invalid');
            x = false;
            return x;
        } else {
            inputs[i].classList.remove('invalid');
        }
    }
    if(pocitadlo !== 0){
        if(check.length !== 1){
            x = false;
            h5.classList.add("showh5");
            return x;
        } else {
            h5.classList.remove("showh5");
        }
    }
    return x;
}

form.addEventListener("submit", (e) => {
    e.preventDefault();
    if (validateForm(1)){
        form.submit();
    }
});