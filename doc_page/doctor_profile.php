<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="doc_style.css">
    <link rel="icon" href="LogoClinic.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <span id="BarsNav" style="font-size:30px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars"></i></span>
    
</head>
    <body>
    <div id="mySidenav" class="sidenav">
      <img src="Logo.png" id="mylogo" alt="Soriano Clinic logo">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="doctor_profile.php"><i class="fa fa-user-circle"></i>Doctor Name</a>
      <a href="doctor_landing_page.php"><i class="fa fa-home"></i>Home</a>
      <a href="Schedules.php"><i class="fa fa-calendar"></i>Schedules</a>
      <a href="Patient.php"><i class="fa fa-users"></i>Patients</a>
      <span title="Logout"><i id="logout" class="fa fa-sign-out"></i></span>
    </div>
    
    <div id="mainDoc">
      <h1>Doctor name</h1>
      <h3><i>Specialization</i></h3>

      <hr>
        
      <div class="boxDoc">
        <h2>Account Details</h2>
        <label>first Name</label>
        <label>Name</label> 
        <label>Email Address</label>
        <label>Contact Number</label>
        <button class="editDoc" onclick="location.href='edit_information.html';">Edit</button>
      </div>

        <hr>

      <div class="boxDoc">
        <h2>Additional Information</h2>
        <label>Birthday</label>
        <label>Specialization</label>
        <label>Gender</label>
        <button class="editDoc" onclick="location.href='edit_information.html';">Edit</button>
      </div>

        <hr>

      <div class="boxDoc">
          <h2>Change Password</h2>
        <label>Current Password</label>
        <button class="editDoc" onclick="location.href='edit_information.html';">Edit</button>
      </div>
    
    </div>

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