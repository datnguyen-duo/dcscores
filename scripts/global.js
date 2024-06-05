// Global variables and constants
var globalVar = "...";

// Utility functions
function utility1() {
  // ...
}

function utility2() {
  // ...
}

// Component-specific code

// Announcement bar
(function () {
  // Get the announcement bar and the 'X' button
  const announcementBar = document.querySelector(
    ".site-header__announcement-bar"
  );
  if (announcementBar) {
    closeButton = announcementBar.querySelector(".icon--close");
    closeButton.addEventListener("click", function () {
      announcementBar.classList.add("hidden");
    });
  }
})();
// Slider
(function () {
  // Variables and constants
  const sliderElements = document.querySelectorAll(".swiper");

  // Functions
  function initializeSlider(sliderElement) {
    const settings = {
      transition: sliderElement.dataset.attributeTransition,
      transitionSpeed: sliderElement.dataset.attributeTransitionSpeed || "1000",
      loop: sliderElement.dataset.attributeLoop || false,
      arrows: sliderElement.dataset.attributeArrows || false,
      pagination: sliderElement.dataset.attributePagination || false,
      autoplay: sliderElement.dataset.attributeAutoplay || false,
      autoplaySpeed: sliderElement.dataset.attributeAutoplaySpeed || "1000",
    };

    new Swiper(sliderElement, {
      slidesPerView: "auto",
      loop: settings.loop,
      speed: parseInt(settings.transitionSpeed),
      effect: settings.transition == "fade" ? "fade" : "",
      fadeEffect: settings.transition == "fade" ? { crossFade: true } : {},
      navigation: {
        nextEl: settings.arrows ? ".swiper-button-next" : "",
        prevEl: settings.arrows ? ".swiper-button-prev" : "",
      },
      pagination: {
        el: settings.pagination ? ".swiper-pagination" : "",
        clickable: true,
      },
      autoplay: settings.autoplay
        ? { delay: parseInt(settings.autoplaySpeed) }
        : false,
    });
  }

  // Initialization
  document.addEventListener("DOMContentLoaded", () => {
    sliderElements.forEach(initializeSlider);
  });
})();

// Modal component
(function () {
  // Variables and constants
  const modalElement = document.querySelector(".modal");
  let modalOpen = false;

  // Functions
  function openModal() {
    // ...
    modalOpen = true;
  }

  function closeModal() {
    // ...
    modalOpen = false;
  }

  // Event listeners
  //   document.querySelector(".open-modal").addEventListener("click", openModal);
  //   document.querySelector(".close-modal").addEventListener("click", closeModal);

  // Initialization
  document.addEventListener("DOMContentLoaded", (event) => {
    // ...
  });
})();

// Form validation component
(function () {
  // Variables and constants
  const formElement = document.querySelector("form");

  // Functions
  function validateForm() {
    // ...
  }

  // Event listeners
  //   formElement.addEventListener("submit", validateForm);

  // Initialization
  document.addEventListener("DOMContentLoaded", (event) => {
    // ...
  });
})();
