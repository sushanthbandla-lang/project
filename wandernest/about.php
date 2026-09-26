<?php
require_once "config/database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>About Us - WanderNest</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f9fa;
        }

        /* About image */

        .about-main-image {
            width: 100%;
            height: 430px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .about-text {
            line-height: 1.8;
            font-size: 17px;
        }

        .service-card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .service-icon {
            font-size: 45px;
        }

        .why-icon {
            font-size: 45px;
        }

    </style>

</head>


<body>


<?php include "includes/navbar.php"; ?>


<!-- =====================================
     PAGE HEADER
     ===================================== -->

<section class="bg-primary text-white py-5">

    <div class="container text-center">

        <h1 class="display-4 fw-bold">
            About WanderNest
        </h1>

        <p class="lead mb-0">
            Discover places. Create memories. Travel with WanderNest.
        </p>

    </div>

</section>


<!-- =====================================
     ABOUT WANDERNEST
     ===================================== -->

<section class="py-5">

    <div class="container">

        <div class="row align-items-center g-5">


            <!-- TEXT -->

            <div class="col-lg-6">

                <h2 class="fw-bold mb-4">
                    Welcome to WanderNest
                </h2>

                <p class="text-muted about-text">

                    WanderNest is a travel platform designed to make
                    travel planning simple, convenient, and enjoyable.

                    We help travelers discover beautiful destinations,
                    explore exciting trips, find comfortable hotels,
                    and rent vehicles for their journeys.

                </p>

                <p class="text-muted about-text">

                    Our goal is to bring different travel services
                    together in one convenient platform so travelers
                    can plan their journeys with ease.

                </p>

                <p class="text-muted about-text">

                    Whether you are planning a family vacation,
                    a weekend getaway, or an adventure trip,
                    WanderNest helps you explore your options and
                    organize your travel experience.

                </p>

            </div>


            <!-- ABOUT IMAGE -->

            <div class="col-lg-6">

                <img
                    src="assets/images/about.jpg"
                    alt="WanderNest Travel"
                    class="about-main-image"
                >

            </div>


        </div>

    </div>

</section>


<!-- =====================================
     OUR SERVICES
     ===================================== -->

<section class="bg-light py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">
                What We Offer
            </h2>

            <p class="text-muted">
                Everything you need for a comfortable travel experience.
            </p>

        </div>


        <div class="row g-4">


            <!-- DESTINATIONS -->

            <div class="col-md-6 col-lg-3">

                <div class="card service-card h-100 shadow-sm text-center">

                    <div class="card-body p-4">

                        <div class="service-icon mb-3">
                            📍
                        </div>

                        <h5 class="fw-bold">
                            Destinations
                        </h5>

                        <p class="text-muted">
                            Discover interesting places and explore
                            new travel destinations.
                        </p>

                    </div>

                </div>

            </div>


            <!-- TRIPS -->

            <div class="col-md-6 col-lg-3">

                <div class="card service-card h-100 shadow-sm text-center">

                    <div class="card-body p-4">

                        <div class="service-icon mb-3">
                            ✈️
                        </div>

                        <h5 class="fw-bold">
                            Trips
                        </h5>

                        <p class="text-muted">
                            Explore planned trips and choose experiences
                            that match your travel interests.
                        </p>

                    </div>

                </div>

            </div>


            <!-- HOTELS -->

            <div class="col-md-6 col-lg-3">

                <div class="card service-card h-100 shadow-sm text-center">

                    <div class="card-body p-4">

                        <div class="service-icon mb-3">
                            🏨
                        </div>

                        <h5 class="fw-bold">
                            Hotels
                        </h5>

                        <p class="text-muted">
                            Find comfortable accommodation for your
                            travel plans.
                        </p>

                    </div>

                </div>

            </div>


            <!-- RENTALS -->

            <div class="col-md-6 col-lg-3">

                <div class="card service-card h-100 shadow-sm text-center">

                    <div class="card-body p-4">

                        <div class="service-icon mb-3">
                            🚗
                        </div>

                        <h5 class="fw-bold">
                            Vehicle Rentals
                        </h5>

                        <p class="text-muted">
                            Rent cars, SUVs, and bikes for convenient
                            local travel.
                        </p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>


<!-- =====================================
     WHY WANDERNEST
     ===================================== -->

<section class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">
                Why WanderNest?
            </h2>

        </div>


        <div class="row g-4">


            <!-- EASY PLANNING -->

            <div class="col-md-4">

                <div class="text-center">

                    <div class="why-icon mb-3">
                        🧭
                    </div>

                    <h5 class="fw-bold">
                        Easy Travel Planning
                    </h5>

                    <p class="text-muted">
                        Explore destinations, trips, hotels,
                        and rentals from one platform.
                    </p>

                </div>

            </div>


            <!-- PRICING -->

            <div class="col-md-4">

                <div class="text-center">

                    <div class="why-icon mb-3">
                        💰
                    </div>

                    <h5 class="fw-bold">
                        Transparent Pricing
                    </h5>

                    <p class="text-muted">
                        View prices clearly while planning your
                        travel and making bookings.
                    </p>

                </div>

            </div>


            <!-- EXPERIENCES -->

            <div class="col-md-4">

                <div class="text-center">

                    <div class="why-icon mb-3">
                        🌟
                    </div>

                    <h5 class="fw-bold">
                        Memorable Experiences
                    </h5>

                    <p class="text-muted">
                        Discover new places and create memorable
                        travel experiences.
                    </p>

                </div>

            </div>


        </div>

    </div>

</section>


<!-- =====================================
     CALL TO ACTION
     ===================================== -->

<section class="bg-primary text-white py-5">

    <div class="container text-center">

        <h2 class="fw-bold">
            Ready to Start Your Journey?
        </h2>

        <p class="lead">
            Explore destinations and plan your next adventure with WanderNest.
        </p>

        <a
            href="destinations.php"
            class="btn btn-light btn-lg mt-2"
        >
            Explore Destinations
        </a>

    </div>

</section>


<?php include "includes/footer.php"; ?>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>