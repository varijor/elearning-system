$(document).ready(function () {
    if($(window).width() < 650){
        $('.navbar').addClass("sticky");
    } 
    $(window).scroll(function () {
        if($(window).width() < 650){
            $('.navbar').addClass("sticky");
        } else {
            if (this.scrollY > 1) {
                $('.navbar').addClass("sticky");
            } else {
                $('.navbar').removeClass("sticky");
            }
        }
    });
    
    const links = document.querySelectorAll('ul li a');
    const button = document.getElementById("btn");
    
    for (let i = 0; i < links.length; i++) {
        links[i].addEventListener("click", function(){button.checked = false;});
    }

});