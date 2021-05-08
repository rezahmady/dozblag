// window.onscroll = function() { myFunction() };

// function myFunction() {
//     var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
//     var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
//     var scrolled = (winScroll / height) * 100;
//     if (document.getElementById("blog-content")) {
//         document.getElementById("blog-content").style.width = scrolled + "%";
//     }

// }

// document.querySelectorAll('a[href^="#"]').forEach(anchor => {
//     anchor.addEventListener('click', function(e) {
//         e.preventDefault();

//         document.querySelector(this.getAttribute('href')).scrollIntoView({
//             behavior: 'smooth'
//         });
//     });
// });

// var $root = $('html, body');

// $('a[href^="#"]').click(function() {
//     console.log($.attr(this, 'href'));
//     $root.animate({
//         scrollTop: $($.attr(this, 'href')).offset().top
//     }, 500);

//     return false;
// });