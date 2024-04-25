<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <section>
        <!--Logo-->
        <header>
            <img src="img/logo.png" alt="clinic-logo" class="clinic-logo">
        </header>
        <!--Creating Account-->
        <div class="create-container">
            <h1>Create an Account</h1>
            <p>Already have an account? <a href="login.html">Login</a></p>
            <div class="form">
                <form action="process_registration.php" method="post"> <!-- Changed action to point to process_registration.php -->
                    <div class="input-box">
                        <label for="last-name" class="name">Last Name</label>
                        <input type="text" name="last_name" required class="your-name"> <!-- Added name attribute -->
                    </div>
                    <div class="input-box">
                        <label for="first-name" class="name">First Name</label>
                        <input type="text" name="first_name" required class="your-name"> <!-- Added name attribute -->
                    </div>
                    <div class="input-box">
                        <label for="email" class="email">Email</label>
                        <input type="email" name="email" required class="your-email"> <!-- Added name attribute -->
                    </div>
                    <div id="input-box">
                        <div class="input-box">
                            <label for="username" class="username">Username</label>
                            <input type="text" name="username" required class="your-username"> <!-- Added name attribute -->
                        </div>
                        <div class="input-box">
                            <label for="contact" class="contact">Contact Number</label>
                            <input type="number" name="contact" required class="your-number"> <!-- Added name attribute -->
                        </div>
                    </div>
                    <div id="input-box2">
                        <div class="input-box">
                            <label for="password" class="password">Password</label>
                            <input type="password" name="password" required class="your-password"> <!-- Added name attribute -->
                        </div>
                        <div class="input-box">
                            <label for="confirm-password" class="password">Confirm Password</label>
                            <input type="password" name="confirm_password" required class="your-password"> <!-- Added name attribute -->
                        </div>
                    </div>
                    <div id="input-box3">
                        <div class="input-box">
                            <label for="user-type" class="user-type">User Type</label>
                            <select id="user-type" name="user-type" required>
                                <option value="" disabled selected></option>
                                <option value="admin">Admin</option>
                                <option value="doctor">Doctor</option>
                            </select> 
                        </div>
                    </div>
                    <button type="submit" class="create">Create</button> <!-- Changed to a submit button -->
                </form>
            </div>
            <img src="img/doc2.png" alt="" class="doc2">
        </div>
    </section>
</body>
</html>

