<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="doc_style.css">
    <link rel="icon" href="LogoClinic.png" type="image/png">
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Nav</span>
    
</head>
    <body>
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="Doctor profile.html">Doctor Name</a>
      <a href="Doctor Landing Page.html">Home</a>
      <a href="Schedules.html">Schedules</a>
      <a href="Patient.html">Patients</a>
    </div>
    
    <img src="Logo.png" id="mylogo" alt="Soriano Clinic logo">
    <h2>Welcome Doctor Name</h2>
    <p>Click on the element below to open the side navigation menu.</p>
    
    
    <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }
    
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
    </script>
       
    </body>
</html>