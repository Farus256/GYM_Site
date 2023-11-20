function validating(formSelector, nameSelector, emailSelector) {
  const form = document.querySelector(formSelector);

  const nameInput = form.querySelector(nameSelector);
nameInput.addEventListener("input", (e) => {
  const inputValue = e.target.value;
  e.target.value = inputValue.replace(/[^a-zA-Z]+/g, "");
});


  const emailInput = form.querySelector(emailSelector);
  emailInput.addEventListener("input", (e) => {
    const inputValue = e.target.value;
    e.target.value = inputValue.replace(/[^A-Za-z0-9\s@.]+/g, "");
  });
}

validating(".form__registation", "#name", "#email");
