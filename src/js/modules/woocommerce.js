export function miniCart() {
  //Toggle mini cart
  const miniCart = document.querySelector(".custom-mini-cart");
  const miniCartCurtain = document.querySelector(".curtain--cart");
  let miniCartOpen = false;

  const miniCartVisibleClass = "custom-mini-cart--visible";
  const miniCartCurtainVisibleClass = "curtain--visible";

  function miniCartOpenHandler() {
    miniCartOpen = true;
    miniCart.classList.add(miniCartVisibleClass);
    miniCartCurtain.classList.add(miniCartCurtainVisibleClass);
  }

  function miniCartCloseHandler() {
    miniCartOpen = false;
    miniCart.classList.remove(miniCartVisibleClass);
    miniCartCurtain.classList.remove(miniCartCurtainVisibleClass);
  }

  document.addEventListener("keydown", function (e) {
    if (e.key == "Escape") {
      miniCartCloseHandler();
    }
  });

  for (const element of document.querySelectorAll("[data-custom-mini-cart-toggle]")) {
    element.addEventListener("click", function (event) {
      event.preventDefault();
      if (miniCartOpen) {
        miniCartCloseHandler();
      } else {
        miniCartOpenHandler();
      }
    });
  }

  //Mini cart animation after product add
  jQuery(document.body).on("added_to_cart", function () {
    jQuery("[data-custom-mini-cart-toggle='main-link']")
      .addClass("shadow-pulse")
      .on("animationend", function () {
        jQuery(this).removeClass("shadow-pulse");
      });
  });
}
