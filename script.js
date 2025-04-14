// przypisywanie odpowiednich tagów HTML do tablicy obiektów
const inputs = [
  { input: "addInput1", label: "addLabel1", button: "depositButton1" },
  { input: "addInput2", label: "addLabel2", button: "depositButton2" },
  {
    input: "withdrawInput1",
    label: "withdrawLabel1",
    button: "withdrawButton1",
  },
  {
    input: "withdrawInput2",
    label: "withdrawLabel2",
    button: "withdrawButton2",
  },
  {
    input: "transferInput1",
    label: "transferLabel1",
    button: "transferButton1",
  },
  {
    input: "transferInput2",
    label: "transferLabel2",
    button: "transferButton2",
  },
];

let balance1 = document.getElementById("balance1");
let balance2 = document.getElementById("balance2");

balance1.innerHTML = balanceSplit(balance1.innerHTML);
balance2.innerHTML = balanceSplit(balance2.innerHTML);

//dodanie eventow - sprawdzanie inputu i zmiana borderu
inputs.forEach(({ input, label, button }) => {
  let inputEl = document.getElementById(input);
  let labelEl = document.getElementById(label);
  let buttonEl = document.getElementById(button);

  if (inputEl && labelEl) {
    inputEl.addEventListener("focus", () => labelAnimateFocus(labelEl));
    inputEl.addEventListener("blur", () => labelAnimateBlur(labelEl, inputEl));
  }

  if (buttonEl && inputEl) {
    buttonEl.addEventListener("click", function (e) {
      if (validateInput(inputEl, e));
    });
    inputEl.addEventListener("focusout", function () {
      focusOutOfInput(this);
    });
  }
});

// funkcje do walidacji inputu i zmiany borderu
function validateInput(input, e) {
  if (!input.value) {
    alert("Fill the input in red");
    input.style.border = "2px solid red";
    e.preventDefault();
  }
}

function focusOutOfInput(input) {
  if (input.value) {
    input.style.border = "1px solid black";
  }
}

// funkcje do animacji labeli
function labelAnimateFocus(label) {
  label.style.transform = "translate(-10px, -18px) scale(0.7)";
  label.style.color = "black";
}

function labelAnimateBlur(label, input) {
  if (!input.value) {
    label.style.transform = "translate(0, 0) scale(1)";
    label.style.color = "rgb(0, 0, 0, 0.8)";
  }
}
function balanceSplit(balance) {
  balance = Number(balance).toFixed(2);
  return balance.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}