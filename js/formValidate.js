const email = document.querySelector("[data-email]");
const password = document.querySelector("[data-password]");
const confirmPassword = document.querySelector("[data-confirm-password]");
const form = document.querySelector("form");
const validateEmail = document.querySelector("[data-validate-email]");
const passwordDataSmallCaps = document.querySelector(
  "[password-data-small-caps]"
);
const passwordDataBigCaps = document.querySelector("[password-data-big-caps]");
const passwordDataNums = document.querySelector("[password-data-nums]");
const dataPasswordDetails = document.querySelector("[data-password-details]");
const passwordMatch = document.querySelector("[data-password-match]");
const passwordDataLength = document.querySelector("[data-password-length]");
const testEmail = /(^[a-zA-Z])([a-zA-Z0-9]{3,})\@[a-zA-Z]{2,8}\.[a-zA-z]{2,6}$/;
const passwordTest = /^[a-zA-Z0-9]{8,16}$/;
const smallCaps = /[a-z]+/;
const bigCaps = /[A-Z]+/;
const nums = /[0-9]+/;

form.addEventListener("submit", (e) => {
  if (!email.value || email.value == "") {
    e.preventDefault();
  } else {
    if (!testEmail.test(email.value)) {
      e.preventDefault();
    }
    if (password.value.length < 8 || password.value.length > 16) {
      e.preventDefault();
    }
    if (password.value !== confirmPassword.value) {
      e.preventDefault();
    }
  }
});

// Elseworld.7@

email.addEventListener("input", (e) => {
  if (!testEmail.test(e.target.value)) {
    if (validateEmail.classList.contains("success")) {
      validateEmail.classList.remove("success");
    }
    validateEmail.classList.add("error");
    validateEmail.textContent = "Invalid email address";
  } else {
    validateEmail.classList.remove("error");
    validateEmail.classList.add("success");
    validateEmail.textContent = "Valid email address";
  }
});

password.addEventListener("input", (e) => {
  if (!passwordTest.test(e.target.value)) {
    dataPasswordDetails.id = "data-password-details";
  }

  if (!smallCaps.test(e.target.value)) {
    if (passwordDataSmallCaps.classList.contains("success")) {
      passwordDataSmallCaps.classList.remove("success");
    }
    passwordDataSmallCaps.classList.add("error");
  } else {
    passwordDataSmallCaps.classList.remove("error");
    passwordDataSmallCaps.classList.add("success");
  }

  if (!bigCaps.test(e.target.value)) {
    if (passwordDataBigCaps.classList.contains("success")) {
      passwordDataBigCaps.classList.remove("success");
    }
    passwordDataBigCaps.classList.add("error");
  } else {
    passwordDataBigCaps.classList.remove("error");
    passwordDataBigCaps.classList.add("success");
  }

  if (!nums.test(e.target.value)) {
    if (passwordDataNums.classList.contains("success")) {
      passwordDataNums.classList.remove("success");
    }
    passwordDataNums.classList.add("error");
  } else {
    passwordDataNums.classList.remove("error");
    passwordDataNums.classList.add("success");
  }

  if (password.value.length < 8 || password.value.length > 16) {
    if (passwordDataLength.classList.contains("success")) {
      passwordDataLength.classList.remove("success");
    }
    passwordDataLength.classList.add("error");
  } else {
    passwordDataLength.classList.remove("error");
    passwordDataLength.classList.add("success");
  }
});

confirmPassword.addEventListener("input", function (e) {
  if (password.value !== e.target.value) {
    passwordMatch.classList.add("error");
    passwordMatch.textContent = "Password don't match";
  } else {
    passwordMatch.classList.remove("error");
    passwordMatch.textContent = "Password match";
    passwordMatch.classList.add("success");
  }
});
