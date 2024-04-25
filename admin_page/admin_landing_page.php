<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="icon" href="LogoClinic.png" type="image/png">
</head>
<body>  
        <div id="myLogo">
            <img src="Logo.png" id="logo" alt="clinic logo">
        </div>
        <div id="mynavBar" class="navBar">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="admin landing page.html">Home</a>
            <a href="Doctor and patients.html">Manage Doctor and Patients</a>
            <a href="Appointment.html">Manage Appointment</a>
            <a href="Account details.html">Account Details</a>
        </div>

        <div id="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
            <h2 id="word">Hello this is the admin page</h2>   
        </div>

        <script>
            function openNav() {
              document.getElementById("mynavBar").style.width = "250px";
              document.getElementById("main").style.marginLeft = "250px";
            }
            
            function closeNav() {
              document.getElementById("mynavBar").style.width = "0";
              document.getElementById("main").style.marginLeft= "0";
            }
            </script>
</body>

</html>