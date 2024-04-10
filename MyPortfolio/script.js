
var tablinks = document.getElementsByClassName("tab-links");
var tabcontents = document.getElementsByClassName("tab-contents");
function opentab(tabname){
    for(tablink of tablinks){
        tablink.classList.remove("active-link");
    }
    for(tabcontent of tabcontents){
        tabcontent.classList.remove("active-tab");
    }
    event.currentTarget.classList.add("active-link");
    document.getElementById(tabname).classList.add("active-tab");
}

var menu = document.getElementById("sidebar");
function openmenu(){
    menu.style.right ="0";
}
function closemenu(){
    menu.style.right="-150px";
}


document.addEventListener("DOMContentLoaded", function() {
    var swiper = new Swiper(".slide-content", {
      slidesPerView: 3,
      spaceBetween: 30,
      slidesPerGroup: 3, 
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
});


