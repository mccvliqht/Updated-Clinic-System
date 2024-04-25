document.getElementById("proceed-btn").addEventListener("click", function() {
    var selectedValue = document.getElementById("appointment-type").value;
    if (selectedValue) {
        window.location.href = selectedValue;
    }
});


