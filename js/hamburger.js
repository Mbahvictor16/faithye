const navHamburger = document.querySelector(".hamburger-menu");
const closeHamburger = document.querySelector(
  'div[style="font-size: 3rem; font-weight: bold"]'
);

navHamburger.addEventListener("click", () => {
  navHamburger?.classList.add("open");
  document.querySelector(".nav")?.classList.add("show");
  document.body.classList.add("stop-scroll");
});

closeHamburger.addEventListener("click", () => {
  navHamburger?.classList.remove("open");
  document.querySelector(".nav")?.classList.remove("show");
  document.body.classList.remove("stop-scroll");
});
