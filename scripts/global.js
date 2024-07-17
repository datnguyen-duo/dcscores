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
  start = "top 80%",
  startScrub = "top bottom",
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
      variation: sliderElement.dataset.variation || null,
      transition: sliderElement.dataset.attributeTransition,
      transitionSpeed: sliderElement.dataset.attributeTransitionSpeed || "1000",
      loop: sliderElement.dataset.attributeLoop || false,
      arrows: sliderElement.dataset.attributeArrows || false,
      pagination: sliderElement.dataset.attributePagination || false,
      autoplay: sliderElement.dataset.attributeAutoplay || false,
      autoplaySpeed: sliderElement.dataset.attributeAutoplaySpeed || "1000",
    };

    if (
      window.innerWidth < 768 &&
      settings.variation !== "team" &&
      settings.variation !== "timeline"
    )
      return;

    new Swiper(sliderElement, {
      slidesPerView: "auto",
      loop: settings.loop,
      speed: parseInt(settings.transitionSpeed),
      effect: settings.transition == "fade" ? "fade" : "",
      fadeEffect: settings.transition == "fade" ? { crossFade: true } : {},
      slideToClickedSlide: settings.variation === "default" ? false : true,
      updateOnWindowResize: true,
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
      // centeredSlides: settings.variation == "team" ? true : false,
      on: {
        snapGridLengthChange: function () {
          if (this.snapGrid.length != this.slidesGrid.length) {
            this.snapGrid = this.slidesGrid.slice(0);
          }
        },
        slideChange: function () {
          const currentIndex = this.activeIndex;

          if (settings.variation !== "default") {
            const altSlides = sliderElement.querySelectorAll(
              ".slider__slides--alt"
            );

            altSlides.forEach((slideContainer, i) => {
              const altSlide = slideContainer.querySelectorAll(
                ".slider__slide--alt"
              );

              altSlide.forEach((slide) => {
                slide.classList.remove("active");
              });

              const targetIndex = currentIndex % altSlide.length;
              altSlide[targetIndex].classList.add("active");
            });
          }
        },
      },
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
    gsap.utils.toArray(".shape").forEach((shape) => {
      gsap.from(shape, {
        clipPath: "inset(0 100% 0 0)",
        duration: durationSlow,
        ease: easeInOut,
        scrollTrigger: {
          trigger: shape,
          start: shape.classList.contains("shape--1")
            ? "30% 50%"
            : "top bottom",
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
      clearInterval(checkInterval);
    }
  }

  let checkInterval = setInterval(updateGTranslateOptionLabels, 500);

  document.addEventListener("DOMContentLoaded", () => {
    updateGTranslateOptionLabels();
  });
})();

// Mobile Menu
(function () {
  const toggle = document.querySelector(".site-header__mobile-toggle");
  document.addEventListener("DOMContentLoaded", () => {
    toggle.addEventListener("click", () => {
      document.body.classList.toggle("init__menu");
    });

    if (window.innerWidth < 768) {
      const topMenu = document.querySelector(".site-header__navigation--top"),
        bottomMenu = document.querySelector(".main-navigation"),
        topMenuHeight = topMenu.clientHeight,
        bottomMenuHeight = bottomMenu.clientHeight;
      document.documentElement.style.setProperty(
        "--menu-height--top",
        `${topMenuHeight}px`
      );
      document.documentElement.style.setProperty(
        "--menu-height--bottom",
        `${bottomMenuHeight}px`
      );
    }
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
        if (section.classList.contains("--modal")) {
          const modal = section.querySelector(".hero__modal");
          section.addEventListener("click", function () {
            document.documentElement.style.scrollBehavior = "auto";

            gsap.to(window, {
              duration: 0,
              scrollTo: {
                y: section,
                offsetY: -3,
              },
            });
            document.body.classList.add("init__modal");
            document.documentElement.style.scrollBehavior = "smooth";
          });
          modal.addEventListener("click", function (e) {
            e.stopPropagation();
            if (e.target === this || e.target.closest(".hero__modal-close")) {
              document.body.classList.remove("init__modal");
            }
          });
        } else {
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
        }
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
        const columns = section.querySelectorAll(".features-list__column");
        gsap.from(".features-list__column", {
          scale: 0.7,
          opacity: 0,
          rotate: 10,
          stagger: 0.1,
          duration: duration,
          ease: easeInOut,
          scrollTrigger: {
            trigger: section.querySelector(".features-list__columns"),
            start: start,
          },
        });

        columns.forEach((column) => {
          const elements = column.querySelectorAll(
            ".features-list__collage-layer-image"
          );

          gsap.utils.toArray(elements).forEach((element, i) => {
            if (i === 0) {
              gsap.from(element, {
                y: -70,
                scrollTrigger: {
                  trigger: section.querySelector(".features-list__columns"),
                  start: startScrub,
                  scrub: true,
                },
              });
            } else if (i === 2) {
              gsap.from(element, {
                y: 70,
                scrollTrigger: {
                  trigger: section.querySelector(".features-list__columns"),
                  start: startScrub,
                  scrub: true,
                },
              });
            }
          });
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
        const isStickySection = section.classList.contains("--sticky");
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
        if (isStickySection) {
          const stickyContent = section.querySelectorAll(
            ".text-image__column-inner"
          );
          const stickyImage = section.querySelectorAll(
            ".text-image__column-image"
          );
          var tl = gsap.timeline({
            scrollTrigger: {
              trigger: section,
              start: "top top",
              end: "+=150%",
              pin: true,
              scrub: true,
            },
          });

          stickyContent.forEach((content, i) => {
            if (i === 0) {
              return;
            }
            let subTl = gsap.timeline();
            subTl.fromTo(content, { opacity: 0 }, { opacity: 1 });
            if (stickyImage[i]) {
              subTl.fromTo(stickyImage[i], { scale: 0 }, { scale: 1 }, "<");
            }
            tl.add(subTl);
          });
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

// Post List
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".post-list");
    if (sections) {
      sections.forEach((section) => {
        const loadMoreBtn = section.querySelector(".load-more-btn");
        const filterItems = section.querySelectorAll(".post-list__filter-item");
        const filterDescriptions = section.querySelectorAll(
          ".post-list__filter-description-item"
        );
        const container = section.querySelector(".posts");
        var filterTerm = "";
        var termId = "";

        if (loadMoreBtn) {
          loadMoreBtn.addEventListener("click", function () {
            const page = parseInt(this.getAttribute("data-page"), 10) + 1;
            const postType = this.getAttribute("data-post-type");
            container.classList.add("loading");
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/wp-admin/admin-ajax.php", true);
            xhr.setRequestHeader(
              "Content-Type",
              "application/x-www-form-urlencoded"
            );
            xhr.onload = function () {
              if (this.status >= 200 && this.status < 400) {
                container.classList.remove("loading");

                const resp = this.response;
                if (resp) {
                  const data = JSON.parse(resp);
                  const totalPosts = data.total_posts;

                  if (data.posts) {
                    const tempContainer = document.createElement("div");
                    tempContainer.innerHTML = data.posts;
                    const newPosts = tempContainer.querySelectorAll(".post");
                    newPosts.forEach((post) => {
                      container.appendChild(post);
                    });

                    gsap.from(newPosts, {
                      y: 20,
                      opacity: 0,
                      duration: duration,
                      ease: easeInOut,
                      stagger: 0.1,
                      onComplete: () => {
                        ScrollTrigger.refresh();
                      },
                    });

                    loadMoreBtn.setAttribute("data-page", page);
                    loadMoreBtn.style.display = "";
                  } else {
                    loadMoreBtn.style.display = "none";
                  }
                } else {
                  loadMoreBtn.style.display = "none";
                }
              }
            };
            xhr.onerror = function () {
              //
            };
            xhr.send(
              "action=fetch_posts&page=" +
                page +
                "&post_type=" +
                postType +
                "&filter_term=" +
                filterTerm +
                "&term_id=" +
                termId +
                "&action_type=load_more"
            );
          });
        }
        if (filterItems) {
          filterItems.forEach((item, i) => {
            item.addEventListener("click", function () {
              filterTerm = this.getAttribute("data-filter-term");
              termId = this.getAttribute("data-term-id");
              const postType = this.getAttribute("data-post-type");

              container.innerHTML = "";

              gsap.to(window, {
                duration: 0,
                scrollTo: {
                  y: section,
                },
              });
              container.classList.add("loading");

              filterItems.forEach((filterItem) => {
                filterItem.classList.remove("active");
              });

              this.classList.add("active");

              if (postType === "person") {
                filterDescriptions.forEach((description) => {
                  description.classList.remove("active");
                });

                filterDescriptions[i].classList.add("active");
              }

              const xhr = new XMLHttpRequest();
              xhr.open("POST", "/wp-admin/admin-ajax.php", true);
              xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
              );
              xhr.onload = function () {
                if (this.status >= 200 && this.status < 400) {
                  container.classList.remove("loading");

                  const resp = this.response;
                  if (resp) {
                    const data = JSON.parse(resp);

                    if (data.posts) {
                      const tempContainer = document.createElement("div");
                      tempContainer.innerHTML = data.posts;
                      const newPosts = tempContainer.querySelectorAll(".post");
                      newPosts.forEach((post) => {
                        container.appendChild(post);
                      });

                      gsap.from(newPosts, {
                        y: 20,
                        opacity: 0,
                        duration: duration,
                        ease: easeInOut,
                        stagger: 0.1,
                        onComplete: () => {
                          ScrollTrigger.refresh();
                        },
                      });

                      if (loadMoreBtn) {
                        loadMoreBtn.setAttribute("data-page", 1);
                        loadMoreBtn.style.display = "";
                      }

                      if (!data.show_load_more && loadMoreBtn) {
                        loadMoreBtn.style.display = "none";
                      }
                    } else {
                      if (loadMoreBtn) {
                        loadMoreBtn.style.display = "none";
                      }
                    }
                  } else {
                    if (loadMoreBtn) {
                      loadMoreBtn.style.display = "none";
                    }
                  }
                }
              };
              xhr.onerror = function () {
                //
              };
              xhr.send(
                "action=fetch_posts&page=" +
                  1 +
                  "&post_type=" +
                  postType +
                  "&filter_term=" +
                  filterTerm +
                  "&term_id=" +
                  termId +
                  "&action_type=filter"
              );
            });
          });
        }
      });
    }
  });
})();

// Accordion
(function () {
  const sections = document.querySelectorAll(".accordions");
  document.addEventListener("DOMContentLoaded", () => {
    if (sections) {
      sections.forEach((section) => {
        const items = section.querySelectorAll(".accordions__item");
        const images = section.querySelectorAll(".accordions__image");
        items.forEach((item) => {
          item.addEventListener("click", function () {
            items.forEach((el, i) => {
              if (el !== item) {
                el.classList.remove("active");
                if (images.length > 0) {
                  images[i].classList.remove("active");
                }
              } else {
                el.classList.toggle("active");
                if (images.length > 0) {
                  images[i].classList.toggle("active");
                }
              }
            });
          });
        });
      });
    }
  });
})();
// Editor
(function () {
  const sections = document.querySelectorAll(".editor");
  document.addEventListener("DOMContentLoaded", () => {
    sections.forEach((section) => {
      const pullquotes = section.querySelectorAll(".wp-block-pullquote");
      pullquotes.forEach((pullquote) => {
        gsap.set(pullquote, {
          scrollTrigger: {
            trigger: pullquote,
            start: start,
            onEnter: () => {
              pullquote.classList.add("load--shape");
            },
          },
        });
      });
    });
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
  const sections = document.querySelectorAll(".posts");
  window.addEventListener("load", () => {
    if (sections) {
      sections.forEach((section) => {
        const el = section.querySelectorAll(".post");
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
      yPercent: 10,
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

// Icon Load
(function () {
  window.addEventListener("load", () => {
    gsap.utils.toArray(".icon--dcs-circle").forEach((icon) => {
      var path = icon.querySelector("path");
      gsap.from(path, {
        drawSVG: "0%",
        duration: duration,
        delay: duration,
        scrollTrigger: {
          trigger: icon,
          start: start,
        },
      });
    });
  });
})();
