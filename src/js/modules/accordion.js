import { toggleVisibility } from "./toggle-visibility";

export function accordion() {
  const accordionHandler = (accordion) => {
    const accordionAriaControls = accordion.getAttribute("aria-controls");
    const accordionItem = accordion.closest("[data-accordion-item]");
    toggleVisibility(document.getElementById(accordionAriaControls));
    accordionItem.classList.toggle("active");

    accordion.setAttribute("aria-expanded", accordion.getAttribute("aria-expanded") === "false" ? "true" : "false");
  };

  const accordionsTriggers = document.querySelectorAll("[data-accordion-toggle]");
  accordionsTriggers.forEach((accordionTrigger) => {
    accordionTrigger.addEventListener("click", () => {
      accordionHandler(accordionTrigger);
    });
  });
}
