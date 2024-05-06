document.getElementById("proceed-btn").addEventListener("click", function() {
    var selectedValue = document.getElementById("appointment-type").value;
    if (selectedValue) {
        window.location.href = selectedValue;
    }
});

document.getElementById("proceed-btn").addEventListener("click", function() {
    var selectedValue = document.getElementById("appointment-type").value;
    if (selectedValue) {
        window.location.href = selectedValue;
    }
});

function populateDoctors() {
    var service = document.getElementById("service").value;
    var doctorSelect = document.getElementById("doctor");
    // Clear existing options
    doctorSelect.innerHTML = "";

    // Add options based on selected service
    if (service === "Blood Test") {
        doctorSelect.add(new Option(""));
        doctorSelect.add(new Option("Dr. Mendoza", "Mendoza"));
        doctorSelect.add(new Option("Dr. Mendez", "Mendez"));
    } else if (service === "Vaccination") {
        doctorSelect.add(new Option(""));
        doctorSelect.add(new Option("Dr. Callao", "Callao"));
        doctorSelect.add(new Option("Dr. Tanzo", "Tanzo"));
    } else if (service === "Minor Illness") {
        doctorSelect.add(new Option(""));
        doctorSelect.add(new Option("Dr. Aquino", "Aquino"));
        doctorSelect.add(new Option("Dr. Tanzo", "Tanzo"));
    } else if (service === "Chronic Disease") {
        doctorSelect.add(new Option(""));
        doctorSelect.add(new Option("Dr. Bondoc", "Bondoc"));
        doctorSelect.add(new Option("Dr. Mendoza", "Mendoza"));
    } else if (service === "Ultrasound") {
        doctorSelect.add(new Option(""));
        doctorSelect.add(new Option("Dr. Mendez", "Mendez"));
        doctorSelect.add(new Option("Dr. Bondoc", "Bondoc"));
    } else if (service === "Dental") {
        doctorSelect.add(new Option(""));
        doctorSelect.add(new Option("Dr. Tanzo", "Tanzo"));
    }

    doctorSelect.style.width = "200px";
}

// Function to populate the appointment dates based on the selected doctor
function populateDates() {
    var doctor = document.getElementById("doctor").value;
    var dateSelect = document.getElementById("avail-date");

    // Clear existing options
    dateSelect.innerHTML = "";

    // Add options based on selected doctor
    if (doctor === "Mendoza") {
        dateSelect.add(new Option(""));
        dateSelect.add(new Option("2024-05-10", "2024-05-10"));
        dateSelect.add(new Option("2024-05-12", "2024-05-12"));
    } else if (doctor === "Mendez") {
        dateSelect.add(new Option(""));
        dateSelect.add(new Option("2024-05-11", "2024-05-11"));
        dateSelect.add(new Option("2024-05-13", "2024-05-13"));
    } else if (doctor === "Callao") {
        dateSelect.add(new Option(""));
        dateSelect.add(new Option("2024-05-12", "2024-05-12"));
        dateSelect.add(new Option("2024-05-14", "2024-05-14"));
    } else if (doctor === "Aquino") {
        dateSelect.add(new Option(""));
        dateSelect.add(new Option("2024-05-13", "2024-05-13"));
        dateSelect.add(new Option("2024-05-15", "2024-05-15"));
    } else if (doctor === "Bondoc") {
        dateSelect.add(new Option(""));
        dateSelect.add(new Option("2024-05-14", "2024-05-14"));
        dateSelect.add(new Option("2024-05-16", "2024-05-16"));
    } else if (doctor === "Tanzo") {
        dateSelect.add(new Option(""));
        dateSelect.add(new Option("2024-05-15", "2024-05-15"));
        dateSelect.add(new Option("2024-05-17", "2024-05-17"));
    }

    dateSelect.style.width = "203px";
}
    // Function to populate the appointment time based on the selected date
    function populateTimes() {
    var date = document.getElementById("avail-date").value;
    var timeSelect = document.getElementById("avail-time");

    // Clear existing options
    timeSelect.innerHTML = "";

    // Add options based on selected date
    if (date === "2024-05-10") {
        timeSelect.add(new Option(""));
        timeSelect.add(new Option("9:00 AM", "9:00 am"));
        timeSelect.add(new Option("10:00 AM", "10:00 am"));
        timeSelect.add(new Option("11:00 AM", "11:00 am"));
        timeSelect.add(new Option("1:00 PM", "1:00 pm"));
        timeSelect.add(new Option("3:00 PM", "3:00 pm"));
        timeSelect.add(new Option("4:00 PM", "4:00 pm"));
    } else if (date === "2024-05-11") {
        timeSelect.add(new Option(""));
        timeSelect.add(new Option("10:00 AM", "10:00 am"));
        timeSelect.add(new Option("12:00 PM", "12:00 pm"));
        timeSelect.add(new Option("2:00 PM", "2:00 pm"));
    } else if (date === "2024-05-12") {
        timeSelect.add(new Option(""));
        timeSelect.add(new Option("8:00 AM", "8:00 am"));
        timeSelect.add(new Option("10:30 AM", "10:30 am"));
        timeSelect.add(new Option("2:30 PM", "2:30 pm"));
    } else if (date === "2024-05-13") {
        timeSelect.add(new Option(""));
        timeSelect.add(new Option("9:30 AM", "9:30 am"));
        timeSelect.add(new Option("11:00 AM", "11:00 am"));
        timeSelect.add(new Option("3:30 PM", "3:30 pm"));
    } else if (date === "2024-05-14") {
        timeSelect.add(new Option(""));
        timeSelect.add(new Option("10:00 AM", "10:00 am"));
        timeSelect.add(new Option("12:00 PM", "12:00 pm"));
        timeSelect.add(new Option("4:00 PM", "4:00 pm"));
    } else if (date === "2024-05-15") {
        timeSelect.add(new Option(""));
        timeSelect.add(new Option("8:30 AM", "8:30 am"));
        timeSelect.add(new Option("1:00 PM", "1:00 pm"));
        timeSelect.add(new Option("2:30 PM", "2:30 pm"));
    } 

    timeSelect.style.width = "200px";
}

// Event listeners to call the functions when dropdown values change
document.getElementById("service").addEventListener("change", populateDoctors);
document.getElementById("doctor").addEventListener("change", populateDates);
document.getElementById("avail-date").addEventListener("change", populateTimes);





