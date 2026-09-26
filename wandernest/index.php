<?php

session_start();

/*
|--------------------------------------------------------------------------
| OPENING THE MAIN WEBSITE
|--------------------------------------------------------------------------
| If index.php is opened normally, show the login page first.
|
| The actual logged-in home page uses:
| index.php?home=1
|
*/

if (!isset($_GET["home"])) {

    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| PROTECT HOME PAGE
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;
}


require_once "config/database.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>WanderNest - Explore the World</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f9fa;
        }

        .home-hero {

            position: relative;

            width: 100%;

            min-height: 90vh;

            background-image:
                url("assets/images/home.jpg");

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

            display: flex;

            align-items: center;
        }

        .home-hero::before {

            content: "";

            position: absolute;

            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            background: rgba(0, 0, 0, 0.50);
        }

        .home-hero-content {

            position: relative;

            z-index: 2;

            width: 100%;

            color: white;

            padding-top: 100px;

            padding-bottom: 100px;
        }

        .home-hero h1 {

            color: white;

            font-size: 64px;

            font-weight: 700;

            line-height: 1.15;

            margin-bottom: 25px;
        }

        .home-hero p {

            color: white;

            font-size: 20px;

            max-width: 750px;

            margin-bottom: 25px;
        }

        .hero-buttons a {

            margin-right: 10px;

            margin-bottom: 10px;
        }

        .welcome-section {

            padding: 70px 0;
        }

        .welcome-section h2 {

            font-weight: 700;

            margin-bottom: 15px;
        }

        .welcome-section > .container > p {

            color: #666;

            font-size: 18px;

            margin-bottom: 40px;
        }

        .feature-card {

            height: 100%;

            background: white;

            border-radius: 15px;

            padding: 30px;

            text-align: center;

            box-shadow:
                0 5px 20px rgba(0,0,0,0.08);

            transition: 0.3s;
        }

        .feature-card:hover {

            transform: translateY(-5px);

            box-shadow:
                0 10px 30px rgba(0,0,0,0.12);
        }

        .feature-icon {

            font-size: 45px;

            margin-bottom: 15px;
        }

        .feature-card h4 {

            font-weight: 700;

            margin-bottom: 15px;
        }

        .feature-card p {

            color: #666;

            line-height: 1.7;
        }

        .feature-card a {

            margin-top: 10px;
        }

        @media (max-width: 768px) {

            .home-hero h1 {

                font-size: 42px;
            }

            .home-hero p {

                font-size: 18px;
            }

        }

    </style>

</head>

<body>


<?php include "includes/navbar.php"; ?>


<!-- HERO SECTION -->

<section class="home-hero">

    <div class="home-hero-content">

        <div class="container">

            <h1>

                Explore The World

                <br>

                With WanderNest

            </h1>


            <p>

                Discover beautiful destinations,
                amazing trips, comfortable hotels
                and convenient rentals.

            </p>


            <div class="hero-buttons">

                <a
                    href="destinations.php"
                    class="btn btn-primary btn-lg"
                >

                    Explore Destinations

                </a>


                <a
                    href="trips.php"
                    class="btn btn-light btn-lg"
                >

                    View Trips

                </a>

            </div>

        </div>

    </div>

</section>


<!-- WELCOME SECTION -->

<section class="welcome-section">

    <div class="container">


        <div class="text-center">

            <h2>

                Welcome to WanderNest,

                <?= htmlspecialchars(
                    $_SESSION["user_name"]
                ) ?>! 🌍

            </h2>


            <p>

                Your journey begins here.
                Explore the world and create
                unforgettable memories.

            </p>

        </div>


        <div class="row g-4">


            <!-- DESTINATIONS -->

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">
                        🌍
                    </div>

                    <h4>
                        Destinations
                    </h4>

                    <p>
                        Discover beautiful destinations
                        around the world.
                    </p>

                    <a
                        href="destinations.php"
                        class="btn btn-primary"
                    >
                        Explore
                    </a>

                </div>

            </div>


            <!-- TRIPS -->

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">
                        ✈️
                    </div>

                    <h4>
                        Travel Trips
                    </h4>

                    <p>
                        Choose from exciting travel
                        packages designed for you.
                    </p>

                    <a
                        href="trips.php"
                        class="btn btn-primary"
                    >
                        View Trips
                    </a>

                </div>

            </div>


            <!-- RENTALS -->

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">
                        🚗
                    </div>

                    <h4>
                        Vehicle Rentals
                    </h4>

                    <p>
                        Rent cars and bikes for a
                        comfortable journey.
                    </p>

                    <a
                        href="rentals.php"
                        class="btn btn-primary"
                    >
                        Rent Now
                    </a>

                </div>

            </div>


        </div>

    </div>

</section>


<?php include "includes/footer.php"; ?>


</body>

</html>