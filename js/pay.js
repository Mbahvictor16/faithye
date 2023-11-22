const input = document.querySelectorAll("input[type=text]");
const form = document.querySelector("form");

form?.addEventListener("submit", (e) => {
  input.forEach((input) => !input.value && e.preventDefault());
  input.forEach((input) => !input.value && input.classList.add("input-error"));
  input.forEach(
    (input) => input.value.length < 4 && input.classList.add("input-error")
  );
});

document.addEventListener("keydown", (e) => {
  if (
    !/^[0-9]$/.test(e.key) &&
    e.key != "Backspace" &&
    e.key != "Delete" &&
    e.key != "ArrowRight" &&
    e.key != "ArrowLeft"
  ) {
    e.preventDefault();
  }
});
