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
        <!--Login Form-->
        <div class="login-container">
            <h1>Welcome back to Soriano</h1>
            <p>Don't have an account? <a href="create-account.php">Sign Up</a></p>
            <div class="form">
                <form action="process_login.php" method="post"> <!-- Updated form action -->
                    <div class="input-box">
                        <label for="username" class="username">Username</label>
                        <input type="text" name="username" required class="your-username">
                    </div>
                    <div class="input-box2">
                        <label for="password" class="password">Password <a href="" class="forgot">Forgot Password?</a></label>
                        <input type="password" name="password" required class="your-password">
                    </div>
                    <div id="input-box">
                    <!--<div class="input-box">
                        <label for="user-type" class="user-type">User Type</label>
                        <select id="user-type" name="user-type" required>
                            <option value="" disabled selected></option>
                            <option value="admin">Admin</option>
                            <option value="doctor">Doctor</option>
                        </select> 
                    </div> -->
                    <div class="input-box2">
                        <label for="confirm-password" class="password">Confirm Password</label>
                        <input type="password" name="confirm_password" required class="your-password">
                    </div>
                    </div>
                    <button type="submit" class="login">Login</button> <!-- Added login button -->
                </form>
            </div>
           <img src="img/doc2.png" alt="" class="doc2">
        </div>
    </section>
</body>
</html>
