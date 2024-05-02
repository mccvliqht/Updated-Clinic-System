<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="doc_style.css">
    <link rel="icon" href="LogoClinic.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <span style="font-size:30px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars"></i></span>
    
</head>
    <body>
    <div id="mySidenav" class="sidenav">
      <img src="Logo.png" id="mylogo" alt="Soriano Clinic logo">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="Doctor profile.html"><i class="fa fa-user-circle"></i>Doctor Name</a>
      <a href="doctor_landing_page.php"><i class="fa fa-home"></i>Home</a>
      <a href="Schedules.html"><i class="fa fa-calendar"></i>Schedules</a>
      <a href="Patient.html"><i class="fa fa-users"></i>Patients</a>
      <span title="Logout"><i id="logout" class="fa fa-sign-out"></i></span>
    </div>
    
    <h2>Welcome Doctor Name</h2>
    
    
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