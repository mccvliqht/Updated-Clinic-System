document.getElementById("proceed-btn").addEventListener("click", function() {
    var selectedValue = document.getElementById("appointment-type").value;
    if (selectedValue) {
        window.location.href = selectedValue;
    }
});

document.getElementById('service').addEventListener('change', function() {
    var selectedService = this.value;
    var doctorDropdown = document.getElementById('doctor');
    var doctors = doctorDropdown.getElementsByTagName('option');
    
    // Hide all doctors
    for (var i = 0; i < doctors.length; i++) {
        doctors[i].style.display = 'none';
    }
    
    // Show doctors based on the selected service
    switch(selectedService) {
        case '4321':
            // Show Dr. Mendoza and Dr. Callao for Service 4321
            showDoctorOption(doctors, 'Dr. Mendoza');
            showDoctorOption(doctors, 'Dr. Callao');
            break;
        case '4322':
            // Show Dr. Mendez and Dr. Tanzo for Service 4322
            showDoctorOption(doctors, 'Dr. Mendez');
            showDoctorOption(doctors, 'Dr. Tanzo');
            break;
        case '4323':
            // Show Dr. Callao and Dr. Aquino for Service 4323
            showDoctorOption(doctors, 'Dr. Callao');
            showDoctorOption(doctors, 'Dr. Aquino');
            break;
        case '4324':
            // Show Dr. Aquino and Dr. Mendoza for Service 4324
            showDoctorOption(doctors, 'Dr. Aquino');
            showDoctorOption(doctors, 'Dr. Mendoza');
            break;
        case '4325':
            // Show Dr. Bondoc and Dr. Mendez for Service 4325
            showDoctorOption(doctors, 'Dr. Bondoc');
            showDoctorOption(doctors, 'Dr. Mendez');
            break;
        case '4326':
            // Show Dr. Tanzo and Dr. Bondoc for Service 4326
            showDoctorOption(doctors, 'Dr. Tanzo');
            showDoctorOption(doctors, 'Dr. Bondoc');
            break;
        default:
            // Show all doctors if no service is selected
            for (var i = 0; i < doctors.length; i++) {
                doctors[i].style.display = 'block';
            }
            break;
    }
});

function showDoctorOption(doctors, doctorName) {
    for (var i = 0; i < doctors.length; i++) {
        if (doctors[i].textContent.trim() === doctorName) {
            doctors[i].style.display = 'block';
            break;
        }
    }
}

document.getElementById('doctor').addEventListener('change', function() {
    var selectedDoctor = this.value;
    var dateDropdown = document.getElementById('avail-date');
    dateDropdown.innerHTML = '<option value="" disabled selected>Select Date</option>';
    if (selectedDoctor) {
        // Get the dates for the selected doctor from the loaded data
        var dates = doctorDates[selectedDoctor];
        if (dates && dates.length > 0) {
            // Populate the dates dropdown
            dates.forEach(function(date) {
                dateDropdown.innerHTML += '<option value="' + date + '">' + date + '</option>';
            });
        }
    }
});

