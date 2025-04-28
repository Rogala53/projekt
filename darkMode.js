const darkModeButton = $("#darkModeButton");
const isDarkMode = sessionStorage.getItem("darkMode") === "true";
let pkoLogo = $("#pkoLogo");

if (isDarkMode) {
    $("body, #sidebar,input, label, footer").addClass("dark-mode");
    darkModeButton.attr("src", "./images/dark-mode.png");
    pkoLogo.attr("src", "./images/PKO-darkmode.jpg");
    pkoLogo.attr("width", "122px");
} else {
    $("body, #sidebar, input, label, footer").removeClass("dark-mode");
    darkModeButton.attr("src", "./images/light-mode.png");
    pkoLogo.attr("src", "./images/PKO.png");
    pkoLogo.attr("width", "100px");
}

darkModeButton.click(function () {
    $("body, #sidebar, input, label, footer").toggleClass("dark-mode");

    const currentlyDark = $("body").hasClass("dark-mode");
    sessionStorage.setItem("darkMode", currentlyDark);

    const newIcon = currentlyDark ? "./images/dark-mode.png" : "./images/light-mode.png";
    const newPkoLogo = currentlyDark ? "./images/PKO-darkmode.jpg" : "./images/PKO.png";
    darkModeButton.attr("src", newIcon);
    pkoLogo.attr("src", newPkoLogo);
    if (pkoLogo.attr("src") == "./images/PKO-darkmode.jpg") {
        pkoLogo.attr("width", "122px");
    }
    else {
        pkoLogo.attr("width", "100px");
    }
});