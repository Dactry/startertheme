import "../scss/plugins/_swiper.scss";

import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

const sliderGalleries = document.querySelectorAll("[data-swiper-gallery]");
if (sliderGalleries.length) {
  sliderGalleries.forEach((gallery) => {
    const slidesPerView = Number(gallery.getAttribute("data-slides-per-view"));
    let slidesPerViewTablet = 1;
    if (slidesPerView >= 3) {
      slidesPerViewTablet = Math.round(slidesPerView / 2);
    }
    const slidesPerViewMobile = slidesPerView > 4 ? 2 : 1;
    const sliderGallery = new Swiper(gallery, {
      modules: [Navigation, Pagination],
      slidesPerView: slidesPerViewMobile,
      spaceBetween: 14,
      autoHeight: true,
      loop: true,
      pagination: {
        el: "[data-swiper-pagination]",
        type: "fraction",
      },
      navigation: {
        nextEl: "[data-swiper-button-next]",
        prevEl: "[data-swiper-button-prev]",
      },
      breakpoints: {
        667: {
          slidesPerView: slidesPerViewTablet,
        },
        992: {
          slidesPerView: slidesPerView,
        },
      },
    });
  });
}
