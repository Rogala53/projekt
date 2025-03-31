window.onload = function () {
  let depositInput1 = document.getElementById("addInput1");
  let depositInput2 = document.getElementById("addInput2");
  let withdrawInput1 = document.getElementById("withdrawInput1");
  let withdrawInput2 = document.getElementById("withdrawInput2");
  let transferInput1 = document.getElementById("transferInput1");
  let transferInput2 = document.getElementById("transferInput2");

  const depositButton1 = document.getElementById("depositButton1");
  const depositButton2 = document.getElementById("depositButton2");
  const withdrawButton1 = document.getElementById("withdrawButton1");
  const withdrawButton2 = document.getElementById("withdrawButton2");
  const transferButton1 = document.getElementById("transferButton1");
  const transferButton2 = document.getElementById("transferButton2");

  document
    .getElementById("darkModeToggle")
    .addEventListener("click", function () {
      document.body.classList.toggle("darkmode");
    });

  depositButton1.addEventListener("click", function (e) {
    validateInput(depositInput1, e);
    depositInput1.addEventListener("focusout", function () {
      focusOutOfInput(this);
    });
  });

  depositButton2.addEventListener("click", function (e) {
    validateInput(depositInput2, e);
    depositInput2.addEventListener("focusout", function () {
      focusOutOfInput(this);
    });
  });

  withdrawButton1.addEventListener("click", function (e) {
    validateInput(withdrawInput1, e);
    withdrawInput1.addEventListener("focusout", function () {
      focusOutOfInput(this);
    });
  });

  withdrawButton2.addEventListener("click", function (e) {
    validateInput(withdrawInput2, e);
    withdrawInput2.addEventListener("focusout", function () {
      focusOutOfInput(this);
    });
  });

  transferButton1.addEventListener("click", function (e) {
    validateInput(transferInput1, e);
    transferInput1.addEventListener("focusout", function () {
      focusOutOfInput(this);
    });
  });

  transferButton2.addEventListener("click", function (e) {
    validateInput(transferInput2, e);
    transferInput2.addEventListener("focusout", function () {
      focusOutOfInput(this);
    });
  });
};

function validateInput(input, e) {
  if (input.value === null || input.value === "") {
    e.preventDefault();
    alert("Fill the input in red");
    input.style.border = "2px solid red";
  }
}

function focusOutOfInput(input) {
  if (input.value !== "") {
    input.style.border = "1px solid black";
  }
}
