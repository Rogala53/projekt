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
  }
];

let balance1 = document.getElementById("balance1");
let balance2 = document.getElementById("balance2");

balance1.innerHTML = FormatAndRoundBalance(balance1.innerHTML);
balance2.innerHTML = FormatAndRoundBalance(balance2.innerHTML);

//dodanie eventow - sprawdzanie inputu i zmiana borderu

inputs.forEach(({ input, label, button }) => {
  let inputElement = document.getElementById(input);
  let labelElement = document.getElementById(label);
  let buttonElement = document.getElementById(button);

  if (inputElement && labelElement) {
    inputElement.addEventListener("focus", () => AnimateLabelFocusIn(labelElement));
    inputElement.addEventListener("focusout", () => AnimateLabelFocusOut(labelElement, inputElement));
  }

  if (buttonElement && inputElement) {
    buttonElement.addEventListener("click", function (e) {
      if (ValidateInput(inputElement, e));
    });
    inputElement.addEventListener("focusout", function () {
      FocusOutOfInput(this);
    });
  }
});

// funkcje do walidacji inputu i zmiany borderu
function ValidateInput(input, e) {
  if (!input.value) {
    alert("Fill the input in red");
    input.style.border = "2px solid red";
    e.preventDefault();
  }
}

function FocusOutOfInput(input) {
  if (input.value) {
    sessionStorage.getItem("darkMode") ? input.style.border = "1px solid #808080" : input.style.border = "1px solid black";
  }
}

// funkcje do animacji labeli
function AnimateLabelFocusIn(label) {
  if(window.innerWidth > 768) {
    label.style.transform = "translate(-10px, -18px) scale(0.7)";
    label.style.opacity = "1";
  }
  
}

function AnimateLabelFocusOut(label, input) {
  if(window.innerWidth > 1520) {
    if (!input.value) {
      label.style.transform = "translate(0, 0) scale(1)";
      label.style.opacity = "0.8";
    }
  }
}
function FormatAndRoundBalance(balance) {
  balance = Number(balance).toFixed(2);
  return balance.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}
