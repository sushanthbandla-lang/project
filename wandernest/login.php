<?php

session_start();

require_once "config/database.php";

$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);

    $password = $_POST["password"];


    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } else {

        $stmt = $pdo->prepare(
            "SELECT id, name, email, password
             FROM users
             WHERE email = ?"
        );

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if (
            $user &&
            password_verify(
                $password,
                $user["password"]
            )
        ) {

            session_regenerate_id(true);


            $_SESSION["user_id"] =
                $user["id"];

            $_SESSION["user_name"] =
                $user["name"];

            $_SESSION["user_email"] =
                $user["email"];


            header("Location: index.php?home=1");

            exit;

        } else {

            $error =
                "Invalid email or password.";

        }

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - WanderNest</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {

            min-height: 100vh;

            margin: 0;

            background:

                linear-gradient(
                    rgba(0,0,0,.55),
                    rgba(0,0,0,.55)
                ),

                url("assets/images/home.jpg");

            background-size: cover;

            background-position: center;

            display: flex;

            align-items: center;

            justify-content: center;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

        }


        .login-card {

            width: 100%;

            max-width: 450px;

            background: white;

            padding: 40px;

            border-radius: 15px;

            box-shadow:
                0 10px 40px
                rgba(0,0,0,0.25);

        }


        .brand {

            text-align: center;

            margin-bottom: 30px;

        }


        .brand h1 {

            font-weight: 700;

            margin-bottom: 10px;

        }


        .brand p {

            color: #777;

        }


        .form-label {

            font-weight: 600;

        }


        .btn-login {

            width: 100%;

            padding: 12px;

            font-size: 18px;

        }


        .register-link {

            text-align: center;

            margin-top: 25px;

        }

    </style>

</head>


<body>


<div class="login-card">


    <div class="brand">

        <h1>

            🌍 WanderNest

        </h1>


        <p>

            Welcome back!
            Please login to continue.

        </p>

    </div>


    <?php if ($error !== ""): ?>

        <div class="alert alert-danger">

            <?= htmlspecialchars($error) ?>

        </div>

    <?php endif; ?>


    <form method="POST">


        <div class="mb-3">

            <label class="form-label">

                Email

            </label>


            <input
                type="email"
                name="email"
                class="form-control"
                required
            >

        </div>


        <div class="mb-3">

            <label class="form-label">

                Password

            </label>


            <input
                type="password"
                name="password"
                class="form-control"
                required
            >

        </div>


        <button
            type="submit"
            class="btn btn-primary btn-login"
        >

            Login

        </button>


    </form>


    <div class="register-link">

        <p>

            Don't have an account?

            <a href="register.php">

                Register

            </a>

        </p>

    </div>


</div>


</body>

</html>