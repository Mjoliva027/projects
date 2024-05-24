let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
   menu.classList.toggle('fa-times');
   navbar.classList.toggle('active');
};

window.onscroll = () =>{
   menu.classList.remove('fa-times');
   navbar.classList.remove('active');
};

document.querySelector('#close-edit').onclick = (event) => {
   event.preventDefault(); // Prevents the default behavior (redirecting to 'add_products.php')
   document.querySelector('.edit-form-container').style.display = 'none';
};


function openNav() {
   document.getElementById("mySidebar").style.width = "250px";
   document.getElementById("main").style.marginLeft = "250px";  
   document.getElementById("main-content").style.marginLeft = "250px";
   document.getElementById("main").style.display="none";
 }
 
 function closeNav() {
   document.getElementById("mySidebar").style.width = "0";
   document.getElementById("main").style.marginLeft= "0";  
   document.getElementById("main").style.display="block";  
 }