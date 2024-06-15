/*	-----------------------------------------------------------------------------
  GLOBAL VARIABLES
--------------------------------------------------------------------------------- */

var easeInOut = "power2.inOut",
  easeOut = "power1.out",
  easeIn = "power1.in",
  easeNone = "none",
  duration = 0.7,
  durationSlow = 1.2,
  durationFast = 0.3,
  start = "top 70%",
  scale = 1.5;
gsap.registerPlugin(ScrollTrigger, DrawSVGPlugin);

/*	-----------------------------------------------------------------------------
  UTILITY FUNCTIONS
--------------------------------------------------------------------------------- */

function utility1() {
  // ...
}

/*	-----------------------------------------------------------------------------
  GLOBAL FUNCTIONS
--------------------------------------------------------------------------------- */

// Announcement bar
(function () {
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
  const sliderElements = document.querySelectorAll(".swiper");
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

  document.addEventListener("DOMContentLoaded", () => {
    sliderElements.forEach(initializeSlider);
  });
})();

// SVG Animations
(function () {
  const dcsArrowDown = gsap.utils.toArray(".icon--dcs-arrow-down"),
    dcsArrowLeft = gsap.utils.toArray(".icon--dcs-arrow-left");

  function drawSvg(svgElement, direction) {
    const clipPathStart =
      direction === "down" ? "inset(0 0 100% 0)" : "inset(0 0 0 100%)";
    gsap.from(svgElement, {
      clipPath: clipPathStart,
      ease: easeInOut,
      duration: duration,
      scrollTrigger: {
        trigger: svgElement,
        start: start,
      },
    });
  }

  window.addEventListener("load", () => {
    dcsArrowDown.forEach((svgElement) => drawSvg(svgElement, "down"));
    dcsArrowLeft.forEach((svgElement) => drawSvg(svgElement, "left"));
  });
})();

// Shape Animations
(function () {
  window.addEventListener("load", () => {
    gsap.utils.toArray(".shape--1, .shape--2").forEach((shape) => {
      gsap.from(shape, {
        clipPath: "inset(0 100% 0 0)",
        duration: durationSlow,
        ease: easeInOut,
        scrollTrigger: {
          trigger: shape,
          start: "30% 50%",
        },
      });
    });
  });
})();

// Search Form

(function () {
  document.addEventListener("DOMContentLoaded", () => {
    const toggleSearch = (action) => {
      document.body.classList[action]("init__search");
    };

    document
      .querySelector(".site-header__search-toggle")
      .addEventListener("click", () => toggleSearch("add"));
    document
      .querySelector(".site-header__search-close")
      .addEventListener("click", () => toggleSearch("remove"));
  });
})();

// GTranslate
(function () {
  function updateGTranslateOptionLabels() {
    const options = document.querySelectorAll(".gt_selector option");
    if (options.length > 0) {
      options.forEach((option) => {
        const parts = option.value.split("|");
        if (parts.length > 1) {
          option.textContent = parts[1];
        }
      });
      clearInterval(checkInterval); // Stop checking once options are updated
    }
  }

  let checkInterval = setInterval(updateGTranslateOptionLabels, 500); // Check every 500ms

  document.addEventListener("DOMContentLoaded", () => {
    // Initial call to handle cases where options might load just after DOMContentLoaded
    updateGTranslateOptionLabels();
  });
})();

/*	-----------------------------------------------------------------------------
  COMPONENTS
--------------------------------------------------------------------------------- */

// Hero
(function () {
  const sections = document.querySelectorAll(".hero");
  document.addEventListener("DOMContentLoaded", () => {
    if (sections) {
      sections.forEach((section) => {
        let firstClick = true;
        const heroVideo = section.querySelector("video");
        function unmuteVideo() {
          if (heroVideo) {
            if (firstClick) {
              heroVideo.currentTime = 0;
              firstClick = false;
            }

            if (heroVideo.muted) {
              heroVideo.muted = false;
              section.classList.add("playing");
            } else {
              heroVideo.muted = true;
              section.classList.remove("playing");
            }
          }
        }
        section.addEventListener("click", unmuteVideo);

        gsap.from(heroVideo, {
          opacity: 0,
          duration: duration,
          ease: easeInOut,
          delay: duration * 1.3,
        });
      });
    }
  });
})();

// Features List
(function () {
  const sections = document.querySelectorAll(".features-list");

  window.addEventListener("load", () => {
    if (sections) {
      sections.forEach((section) => {
        gsap.from(".features-list__column", {
          scale: 0.7,
          opacity: 0,
          rotate: 10,
          stagger: 0.1,
          duration: 0.7,
          ease: easeInOut,
          scrollTrigger: {
            trigger: section.querySelector(".features-list__columns"),
            start: start,
          },
        });
      });
    }
  });
})();

// Text Image
(function () {
  const sections = document.querySelectorAll(".text-image");
  document.addEventListener("DOMContentLoaded", () => {
    if (sections) {
      sections.forEach((section) => {
        const isToggleSection = section.classList.contains("--toggles");
        const isSliderSection = section.classList.contains("--slider");
        if (isToggleSection) {
          const togglesContainer = section.querySelector(
            ".text-image__column-toggles"
          );
          const toggles = Array.from(
            section.querySelectorAll(".text-image__column-toggle")
          );
          const togglesContent = Array.from(
            section.querySelectorAll(".text-image__column-inner")
          );
          const togglesImages = Array.from(
            section.querySelectorAll(".text-image__column-image")
          );
          let activeToggle = toggles[0];
          let activeContent = togglesContent[0];
          let activeImage = togglesImages[0];
          togglesContainer.addEventListener("click", function (event) {
            const clickedToggleIndex = toggles.findIndex(
              (toggle) => toggle === event.target
            );
            if (
              clickedToggleIndex !== -1 &&
              toggles[clickedToggleIndex] !== activeToggle
            ) {
              gsap.fromTo(
                activeImage,
                { clipPath: "inset(0% 0% 0% 0%)" },
                {
                  clipPath: "inset(0% 0% 0% 100%)",
                  duration: 0.5,
                  ease: easeInOut,
                  onStart: () =>
                    (togglesContainer.style.pointerEvents = "none"),
                  onComplete: () =>
                    (togglesContainer.style.pointerEvents = "initial"),
                }
              );
              activeToggle.classList.remove("active");
              activeContent.classList.remove("active");
              gsap.fromTo(
                togglesImages[clickedToggleIndex],
                { clipPath: "inset(0% 100% 0% 0%)" },
                {
                  clipPath: "inset(0% 0% 0% 0%)",
                  duration: 0.5,
                  ease: easeInOut,
                }
              );
              toggles[clickedToggleIndex].classList.add("active");
              togglesContent[clickedToggleIndex].classList.add("active");
              activeToggle = toggles[clickedToggleIndex];
              activeContent = togglesContent[clickedToggleIndex];
              activeImage = togglesImages[clickedToggleIndex];
            }
          });
        }
        if (isSliderSection) {
          const pagination = section.querySelector(
            ".text-image__column-pagination"
          );
          if (pagination.children.length === 0) {
            const prevArrow = section.querySelector(".--prev");
            const nextArrow = section.querySelector(".--next");
            const sliderContent = Array.from(
              section.querySelectorAll(".text-image__column-inner")
            );
            const sliderImages = Array.from(
              section.querySelectorAll(".text-image__column-image")
            );
            const bullets = [];
            for (let i = 0; i < sliderContent.length; i++) {
              const bullet = document.createElement("span");
              bullet.classList.add("bullet");
              if (i === 0) {
                bullet.classList.add("active");
              }
              pagination.appendChild(bullet);
              bullets.push(bullet);
            }
            let activeSlide = 0;
            const animateSlideChange = (oldSlide, newSlide, dir) => {
              console.log(dir);
              gsap.fromTo(
                sliderImages[oldSlide],
                { clipPath: "inset(0% 0% 0% 0%)" },
                {
                  clipPath:
                    dir === "next"
                      ? "inset(0% 0% 0% 100%)"
                      : "inset(0% 100% 0% 0%)",
                  duration: 0.5,
                  ease: easeInOut,
                }
              );
              gsap.fromTo(
                sliderImages[newSlide],
                {
                  clipPath:
                    dir === "next"
                      ? "inset(0% 100% 0% 0%)"
                      : "inset(0% 0% 0% 100%)",
                },
                {
                  clipPath: "inset(0% 0% 0% 0%)",
                  duration: 0.5,
                  ease: easeInOut,
                }
              );
            };
            const updateSlide = (newSlide, dir) => {
              animateSlideChange(activeSlide, newSlide, dir);
              sliderContent[activeSlide].classList.remove("active");
              sliderImages[activeSlide].classList.remove("active");
              bullets[activeSlide].classList.remove("active");
              activeSlide = newSlide;
              sliderContent[activeSlide].classList.add("active");
              sliderImages[activeSlide].classList.add("active");
              bullets[activeSlide].classList.add("active");
              nextArrow.classList.toggle(
                "disabled",
                activeSlide === sliderContent.length - 1
              );
              prevArrow.classList.toggle("disabled", activeSlide === 0);
            };
            nextArrow.addEventListener("click", () => {
              if (activeSlide < sliderContent.length - 1) {
                updateSlide(activeSlide + 1, "next");
              }
            });
            prevArrow.addEventListener("click", () => {
              if (activeSlide > 0) {
                updateSlide(activeSlide - 1, "prev");
              }
            });
            bullets.forEach((bullet, i) =>
              bullet.addEventListener("click", () => updateSlide(i))
            );
          }
        }
      });
    }
  });
})();

// Stats
(function () {
  const sections = document.querySelectorAll(".stats");
  window.addEventListener("load", () => {
    if (sections) {
      sections.forEach((section) => {
        const stats = section.querySelectorAll(".stats__column-stat--number");
        stats.forEach((stat) => {
          gsap.from(stat, {
            textContent: 0,
            duration: 2,
            ease: Power1.easeIn,
            snap: { textContent: 1 },
            stagger: 1,
            scrollTrigger: {
              trigger: section,
              start: start,
            },
            onUpdate: function () {
              this.targets()[0].textContent =
                this.targets()[0].textContent.replace(
                  /\B(?=(\d{3})+(?!\d))/g,
                  ","
                );
            },
          });
        });
      });
    }
  });
})();

/*	-----------------------------------------------------------------------------
  LOAD
--------------------------------------------------------------------------------- */

(function () {
  window.addEventListener("load", () => {
    document.querySelector("#main").classList.remove("loading");
  });
})();

// Load Sections
(function () {
  const sections = gsap.utils.toArray(".cta, .stats");
  window.addEventListener("load", () => {
    if (sections) {
      sections.forEach((section) => {
        gsap.from(section, {
          y: 50,
          opacity: 0,
          duration: duration,
          ease: easeInOut,
          scrollTrigger: {
            trigger: section,
            start: start,
          },
        });
      });
    }
  });
})();

(function () {
  const sections = document.querySelectorAll(".post-list");
  window.addEventListener("load", () => {
    if (sections) {
      sections.forEach((section) => {
        const el = section.querySelectorAll(".post-list__item");
        gsap.from(el, {
          y: 20,
          opacity: 0,
          duration: duration,
          ease: easeInOut,
          stagger: 0.1,
          scrollTrigger: {
            trigger: section,
            start: start,
          },
        });
      });
    }
  });
})();

// Text Load
(function () {
  const textElements = gsap.utils.toArray(".load--text");

  function animateText(textElement) {
    gsap.from(textElement, {
      y: 50,
      opacity: 0,
      duration: duration,
      ease: easeInOut,
      scrollTrigger: {
        trigger: textElement,
        start: start,
      },
    });
  }

  window.addEventListener("load", () => {
    textElements.forEach(animateText);
  });
})();

// Media Load
(function () {
  const mediaElements = gsap.utils.toArray(".load--media");

  function animateImage(mediaElement) {
    gsap.from(mediaElement, {
      y: 50,
      opacity: 0,
      duration: duration,
      ease: easeInOut,
      scrollTrigger: {
        trigger: mediaElement,
        start: start,
      },
    });
  }

  window.addEventListener("load", () => {
    mediaElements.forEach(animateImage);
  });
})();
