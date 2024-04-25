<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="icon" href="LogoClinic.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>  
        <div id="myLogo">
            <img src="Logo.png" id="logo" alt="clinic logo">
        </div>
        <div id="mynavBar" class="navBar">
            <a href="javascript:void(0)" title="Close" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="admin_landing_page.php"><i class="fa fa-home"></i>Home</a>
            <a href="Doctor_and_patients.html"><i class="fa fa-group"></i>Manage Doctor and Patients</a>
            <a href="Appointment.html"><i class="fa fa-th-list"></i>Manage Appointment</a>
            <a href="Account_details.html"><i class="fa fa-user-circle-o"></i>Account Details</a>
        </div>

        <div id="main">
            <span title="Side Navigation" class="option" onclick="openNav()">&#9776; </span>
            <h2 id="word">Hello this is the Account Details page</h2>   
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
