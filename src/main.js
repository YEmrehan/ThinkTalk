window.onload = function() {
    var notification = document.getElementById("notification");
    notification.style.display = "block";

    setTimeout(function() {
        notification.style.display = "none";
    }, 3000);
};
console.log("5 + 6 = " + (5 + 6));