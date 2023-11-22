const photo = document.querySelector("[data-file]");

photo.addEventListener("change", async (event) => {
  return await new Promise((resolve, reject) => {
    const file = new FileReader();
    file.readAsDataURL(event.target.files[0]);
    file.onload = () => {
      resolve(file.result);
      document.querySelector("[data-img]").src = file.result;
    };

    file.onerror = (error) => reject(error);
  });
});
