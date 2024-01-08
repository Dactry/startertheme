export function overlayMenu() {
  let overlayMenuOpen = false;
  function overlayMenuHandler() {
    if (overlayMenuOpen) {
      overlayMenuOpen = false;
    } else {
      overlayMenuOpen = true;
    }

    const overlayMenuVisibleClass = "overlay-menu--visible";
    const overlayMenuChangingClass = "overlay-menu--changing";

    const overlayMenu = document.querySelector(".overlay-menu");
    const overlayMenuCurtain = document.querySelector(".curtain--menu");

    document.documentElement.classList.toggle("is-locked");
    overlayMenu.classList.toggle(overlayMenuVisibleClass);
    overlayMenu.classList.add(overlayMenuChangingClass);

    overlayMenu.addEventListener("transitionend", function () {
      overlayMenu.classList.remove(overlayMenuChangingClass);
    });

    overlayMenuCurtain.classList.toggle("curtain--visible");
  }

  //Elements clicks
  for (const element of document.querySelectorAll("[data-overlay-menu-toggle]")) {
    element.addEventListener("click", function () {
      overlayMenuHandler();
    });
  }

  //Escape click
  document.addEventListener("keydown", function (e) {
    if (overlayMenuOpen && e.key == "Escape") {
      overlayMenuHandler();
    }
  });

  //Mobile submenu toggle
  const dropdownToggles = document.querySelectorAll("[data-dropdown-toggle]");
  dropdownToggles.forEach((dropdownToggle) => {
    dropdownToggle.addEventListener("click", function () {
      dropdownToggle.classList.toggle("active");
      dropdownToggle.nextElementSibling.classList.toggle("dropdown-responsive--visible");
    });
  });
}
