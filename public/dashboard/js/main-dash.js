// Show And Hide SlideBar
const menu = document.getElementById("menu");
const sideBar = document.getElementById("sidebar");
const navbar = document.getElementById("navbar");
const main = document.getElementById("main");
const closeSidebar = document.getElementById("closeSidebar");

if (menu) {
  menu.addEventListener("click", () => {
    sideBar.classList.toggle("active-side");
    navbar.classList.toggle("active-nav");
    main.classList.toggle("active-main");
  });
}

// Close SideBar
if (closeSidebar) {
  closeSidebar.addEventListener("click", () => {
    sideBar.classList.remove("active-side");
  });
}

// Show And Hide SlideBar
const collapse = document.querySelectorAll(".sidebar .collapse-co");

collapse.forEach((col) => {
  col.addEventListener("click", (e) => {
    e.preventDefault();
    // if (col.classList.contains("d-ac")) {
    //   col.classList.add("active");
    // } else {
    //   col.classList.toggle("active");
    // }
    // col.classList.toggle('active');
    col.querySelector(".icon-right").classList.toggle("icon-r-rotate");
    col.parentElement
      .querySelector(".collapse-me")
      .classList.toggle("collapse-active");
  });
});

// loader

$(window).on("load", function () {
  $(".loader").fadeOut("slow", function () {
    $(".loader").remove();
  });
});

//........................................................
let setLink = document.querySelectorAll(".spe-link-spe");
setLink.forEach((link) => {
  link.addEventListener("click", function (e) {
    setLink.forEach((link) => {
      link.classList.remove("active");
    });
    e.currentTarget.classList.add("active");
  });
});

// let links = document.querySelectorAll(".col-spe");
// links.forEach((link1) => {
//   link1.addEventListener("click", function (e) {
//     links.forEach((link1) => {
//       link1.classList.remove("activate-yes");
//     });
//     e.currentTarget.classList.add("activate-yes");
//   });
// });

//..........................
$(document).ready(function () {
  let setLink = document.querySelectorAll(".spe-col-act a");
    console.log(setLink);
  for (var i = 0; i < setLink.length; i++) {
    console.log("window", window.location.href);
    setLink[i].classList.remove('active')
    
    if (window.location.href == setLink[i].href) {
      console.log(setLink[i]);
      setLink[i].classList.add("active");
      setLink[i].closest('.spe-col-act').firstElementChild.classList.add('active')
      setLink[i].parentElement.classList.add('active')
      // break;
    }
  }
});
