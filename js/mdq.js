const heroTitle = document.querySelector(".hero-title");

if (window.matchMedia("(max-width: 767px)").matches) {
  document.querySelector("header").classList.add("bend-nav");
  heroTitle && heroTitle.classList.add("bend-nav");
  document
    .querySelectorAll(".product-div h1")
    .forEach((product) => product.classList.add("bend-nav"));
} else {
  document.querySelector("header").classList.remove("bend-nav");
  heroTitle && heroTitle.classList.remove("bend-nav");
  document
    .querySelectorAll(".product-div h1")
    .forEach((product) => product.classList.remove("bend-nav"));
}

window.addEventListener("resize", function () {
  if (window.matchMedia("(max-width: 767px)").matches) {
    document.querySelector("header").classList.add("bend-nav");
    heroTitle && heroTitle.classList.add("bend-nav");
    document
      .querySelectorAll(".product-div h1")
      .forEach((product) => product.classList.add("bend-nav"));
  } else {
    document.querySelector("header").classList.remove("bend-nav");
    heroTitle && heroTitle.classList.remove("bend-nav");
    document
      .querySelectorAll(".product-div h1")
      .forEach((product) => product.classList.remove("bend-nav"));
  }
});
