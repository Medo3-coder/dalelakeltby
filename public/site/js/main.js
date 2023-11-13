// password in login pages
function showPassword(input, icon) {
  if (input.type == "password") {
    input.setAttribute("type", "text");
    icon.innerHTML = `<i class="fa-regular fa-eye-slash"></i>`;
  } else {
    input.setAttribute("type", "password");
    icon.innerHTML = `<i class="fa-regular fa-eye"></i>`;
  }

  input.focus();
}
const user = document.getElementById("check-ic");
const inputPass = document.getElementById("inputpass");

if (user) {
  user.addEventListener("click", () => {
    showPassword(inputPass, user);
  });
}
//..............................................

// toggle our navbar links
let bars = document.querySelector(".bars");
let navLayer = document.querySelector(".nav-layer");
let sideNav = document.querySelector(".flex-logins");
let linksMain = document.querySelectorAll('.user-ul li');
for(let i = 0 ; i < linksMain.length ; i++){
  linksMain[i].addEventListener('click' , function(){
    bars.classList.toggle("bar-tog");
    navLayer.classList.toggle("slideto");
    sideNav.classList.toggle("slideto");
  })
}

bars.addEventListener("click", function () {
  this.classList.toggle("bar-tog");
  navLayer.classList.toggle("slideto");
  sideNav.classList.toggle("slideto");
});
navLayer.addEventListener("click", function () {
  this.classList.toggle("slideto");
  sideNav.classList.toggle("slideto");
  bars.classList.remove("bar-tog");
});



$(window).on("load", function () {
  $(".loader").fadeOut("slow", function () {
    $(".loader").remove();
  });
});