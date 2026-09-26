<?php

session_start();

require_once "config/database.php";


// If already logged in, go to home page
if (isset($_SESSION['user_id'])) {

    header("Location: index.php");
    exit;

}


$error = "";
$success = "";


// Handle registration
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    // Validate fields

    if (
        $name === "" ||
        $email === "" ||
        $password === "" ||
        $confirm_password === ""
    ) {

        $error = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } elseif (strlen($password) < 6) {

        $error = "Password must be at least 6 characters.";

    } elseif ($password !== $confirm_password) {

        $error = "Passwords do not match.";

    } else {

        // Check if email already exists

        $stmt = $pdo->prepare(
            "SELECT id
             FROM users
             WHERE email = ?"
        );

        $stmt->execute([$email]);

        $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($existing_user) {

            $error = "An account with this email already exists.";

        } else {

            // Securely hash password

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );


            // Insert user

            $stmt = $pdo->prepare(
                "INSERT INTO users
                (name, email, password)
                VALUES (?, ?, ?)"
            );

            $stmt->execute([
                $name,
                $email,
                $hashed_password
            ]);


            $success = "Registration successful! You can now login.";

        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register - WanderNest</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <style>

        body {

            min-height: 100vh;

            margin: 0;

            font-family: Arial, Helvetica, sans-serif;

            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.55)
                ),
                url("assets/images/home.jpg");

            background-size: cover;

            background-position: center;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 15px;

        }


        .register-card {

            width: 100%;

            max-width: 500px;

            background: white;

            padding: 40px;

            border-radius: 15px;

            box-shadow:
                0 10px 35px rgba(0, 0, 0, 0.25);

        }


        .brand {

            text-align: center;

            margin-bottom: 25px;

        }


        .brand h1 {

            font-weight: 700;

            color: #0d6efd;

            margin-bottom: 5px;

        }


        .brand p {

            color: #777;

            margin: 0;

        }


        .form-label {

            font-weight: 600;

        }


        .form-control {

            padding: 12px;

            border-radius: 8px;

        }


        .register-btn {

            width: 100%;

            padding: 12px;

            font-weight: 600;

            border-radius: 8px;

        }


        .login-link {

            text-align: center;

            margin-top: 20px;

        }


        .login-link a {

            text-decoration: none;

            font-weight: 600;

        }

    </style>

</head>


<body>


<div class="register-card">


    <div class="brand">

        <h1>🌍 WanderNest</h1>

        <p>Create your account to start exploring.</p>

    </div>


    <?php if ($error !== ""): ?>

        <div class="alert alert-danger">

            <?= htmlspecialchars($error) ?>

        </div>

    <?php endif; ?>


    <?php if ($success !== ""): ?>

        <div class="alert alert-success">

            <?= htmlspecialchars($success) ?>

        </div>

    <?php endif; ?>


    <form method="POST">


        <!-- Name -->

        <div class="mb-3">

            <label class="form-label">
                Full Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                placeholder="Enter your full name"
                required
            >

        </div>


        <!-- Email -->

        <div class="mb-3">

            <label class="form-label">
                Email Address
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Enter your email"
                required
            >

        </div>


        <!-- Password -->

        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Create a password"
                required
            >

        </div>


        <!-- Confirm Password -->

        <div class="mb-3">

            <label class="form-label">
                Confirm Password
            </label>

            <input
                type="password"
                name="confirm_password"
                class="form-control"
                placeholder="Confirm your password"
                required
            >

        </div>


        <!-- Register -->

        <button
            type="submit"
            class="btn btn-primary register-btn"
        >

            Create Account

        </button>


    </form>


    <div class="login-link">

        <p class="mb-0">

            Already have an account?

            <a href="login.php">
                Login
            </a>

        </p>

    </div>


</div>


</body>

</html>