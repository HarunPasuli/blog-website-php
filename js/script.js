// window.onload = function() {
//     setTimeout(function() {
//       if ( typeof(window.google_jobrunner) === "undefined" ) {
//         alert('Please disable your ad blocker!');
//       } else {
//         console.log('.');
//       }
//     }, 10000);  
//   };

// const date = new Date().toLocaleDateString;

// Get all elements with the 'post-date' class

// Select all the filter items and products

// function filterSelection(category) {
//     var products = document.getElementsByClassName("post-box");
//     for (var i = 0; i < products.length; i++) {
//         var categories = products[i].querySelector(".category").innerText;
//         if (categories.indexOf(category) > -1 || category === "all") {
//             products[i].classList.remove("hidden");
//         } else {
//             products[i].classList.add("hidden");
//         }
//     }
// }


// var categoryButtons = document.getElementsByClassName("filter-item");

// for (var i = 0; i < categoryButtons.length; i++) {
//     categoryButtons[i].addEventListener("click", function() {
//         var currentCategory = this.getAttribute("data-filter");
//         filterSelection(currentCategory);
//     });
// }





// $(document).ready(function() {
//     $('.filter-item').click(function() {
//         const value = $(this).attr('data-filter');
//         if (value == 'all') {
//             $('.post-box').show('1000');
//         }
//         else {
//             $('.post-box').not("." + value).hide('1000');
//             $('.post-box').filter("." + value).show('1000');
//         }
//     });
//     $('.filter-item').click(function() {
//         $(this.addClass('active-filter')).siblings().removeClass('active-filter');
//     });
// })

let header = document.querySelector('header');

window.addEventListener('scroll', () => {
    header.classList.toggle('shadow',window.scrollY > 0);
})
