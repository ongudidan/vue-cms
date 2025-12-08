function toggleMenu() {
   document.getElementById('isToggle').classList.toggle('open');
   var isOpen = document.getElementById('navigation')
   if (isOpen.style.display === "block") {
      isOpen.style.display = "none";
   } else {
      isOpen.style.display = "block";
   }
}

//Menu Active
function getClosest(elem, selector) {

   // Element.matches() polyfill
   if (!Element.prototype.matches) {
      Element.prototype.matches =
         Element.prototype.matchesSelector ||
         Element.prototype.mozMatchesSelector ||
         Element.prototype.msMatchesSelector ||
         Element.prototype.oMatchesSelector ||
         Element.prototype.webkitMatchesSelector ||
         function (s) {
            var matches = (this.document || this.ownerDocument).querySelectorAll(s),
               i = matches.length;
            while (--i >= 0 && matches.item(i) !== this) { }
            return i > -1;
         };
   }

   // Get the closest matching element
   for (; elem && elem !== document; elem = elem.parentNode) {
      if (elem.matches(selector)) return elem;
   }
   return null;

}

// Clickable Menu
if(document.getElementById("navigation")){
   var elements = document.getElementById("navigation").getElementsByTagName("a");
   for(var i = 0, len = elements.length; i < len; i++) {
      elements[i].onclick = function (elem) {
         if(elem.target.getAttribute("href") === "javascript:void(0)") {
            var submenu = elem.target.nextElementSibling.nextElementSibling;
            submenu.classList.toggle('open');
         }
      }
   }
}

//  Window scroll sticky class add
function windowScroll() {
   const navbar = document.getElementById("topnav") || document.getElementById('navbar');
   if (
      document.body.scrollTop >= 50 ||
      document.documentElement.scrollTop >= 50
   ) {
      navbar.classList.add("nav-sticky");
   } else {
      navbar.classList.remove("nav-sticky");
   }
}
window.addEventListener("scroll", (ev) => {
   ev.preventDefault();
   windowScroll();
});

const backToTopButton = document.getElementById("back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
   scrollFunction();
};

function scrollFunction() {
   if (
      document.body.scrollTop > 100 ||
      document.documentElement.scrollTop > 100
   ) {
      backToTopButton.style.display = "block";
   } else {
      backToTopButton.style.display = "none";
   }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
   document.body.scrollTop = 0;
   document.documentElement.scrollTop = 0;
}

AOS.init();


try {
   const menu = [];
   const interleaveOffset = 0.5;
   const swiperOptions = {
      loop: true,
      speed: 1000,
      parallax: true,
      autoplay: {
         delay: 6500,
         disableOnInteraction: false,
      },
      watchSlidesProgress: true,
      pagination: {
         el: '.swiper-pagination',
         clickable: true,
         renderBullet: function (index, className) {
            return '<span class="' + className + '">' + 0 + (index + 1) + '</span>';
         },
      },

      navigation: {
         nextEl: '.swiper-button-next',
         prevEl: '.swiper-button-prev',
      },

      on: {
         progress: function () {
            var swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
               const slideProgress = swiper.slides[i].progress;
               const innerOffset = swiper.width * interleaveOffset;
               const innerTranslate = slideProgress * innerOffset;
               swiper.slides[i].querySelector(".slide-inner").style.transform =
                  "translate3d(" + innerTranslate + "px, 0, 0)";
            }
         },

         touchStart: function () {
            const swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
               swiper.slides[i].style.transition = "";
            }
         },

         setTransition: function (speed) {
            const swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
               swiper.slides[i].style.transition = speed + "ms";
               swiper.slides[i].querySelector(".slide-inner").style.transition =
                  speed + "ms";
            }
         }
      }
   };

   // DATA BACKGROUND IMAGE
   const swiper = new Swiper(".swiper-container", swiperOptions);

   let data = document.querySelectorAll(".slide-bg-image")
   data.forEach((e) => {
      e.style.backgroundImage =
         `url(${e.getAttribute('data-background')})`;
   })
} catch (err) {

}

// const notyf = new Notyf({
//    duration: 5000,
//    position: {
//       x: 'right',
//       y: 'top',
//    },
//    types: [
//       {
//          type: 'success',
//          background: 'green',
//          dismissible: true,
//          icon: false,
//       },
//       {
//          type: 'info',
//          background: 'blue',
//          dismissible: true,
//          icon: false,
//       },
//       {
//          type: 'warning',
//          background: 'orange',
//          dismissible: true,
//          icon: false,
//       },
//       {
//          type: 'error',
//          background: 'indianred',
//          duration: 2000,
//          dismissible: true,
//          icon: false,
//       }
//    ]
// });
