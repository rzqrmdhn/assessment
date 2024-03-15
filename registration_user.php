<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Author</title>
    <link rel="stylesheet" href="login_styles.css">
    <link rel="stylesheet" href="footer.css">
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="registration_process.php" method="POST"> <!-- Form action ditujukan ke registration_process.php -->
            <h2>Registration Author</h2>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="input-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="birthdate">Tanggal Lahir</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="password-toggle" onclick="togglePassword('password')">
                    <span class="glyphicon glyphicon-eye-close"></span>
                </span>
            </div>
            <div class="input-group">
                <label for="retype_password">Re-type Password</label>
                <input type="password" id="retype_password" name="retype_password" required>
                <span class="password-toggle" onclick="togglePassword('retype_password')">
                    <span class="glyphicon glyphicon-eye-close"></span>
                </span>
            </div>
            <button type="submit" name="register">Register</button> <!-- Tombol submit dengan name="register" -->
        </form>
    </div>
    <?php include 'footer.php'; ?>

    <!-- Load Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>
        function togglePassword(inputId) {
            var x = document.getElementById(inputId);
            if (x.type === "password") {
                x.type = "text";
                // Ganti ikon mata menjadi terbuka ketika password ditampilkan
                document.querySelector("#" + inputId + " + .password-toggle .glyphicon").className = "glyphicon glyphicon-eye-open";
            } else {
                x.type = "password";
                // Ganti ikon mata menjadi tertutup ketika password disembunyikan
                document.querySelector("#" + inputId + " + .password-toggle .glyphicon").className = "glyphicon glyphicon-eye-close";
            }
        }
    </script>
</body>
</html>
