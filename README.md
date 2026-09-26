# project
https://wandernest.infinityfreeapp.com/


# 🌍 WanderNest

**WanderNest** is a dynamic travel and tourism web application designed to make travel planning simple and convenient. Users can explore destinations, discover trips, view hotels, rent vehicles, make bookings, and share their travel experiences through reviews.

🔗 **Live Website:** https://wandernest.infinityfreeapp.com/

---

## ✨ Features

### 🔐 User Authentication

* User registration
* User login
* Secure session-based authentication
* Logout functionality
* Protected user pages

### 📍 Destinations

* Browse travel destinations
* View destination details
* Explore destination images
* View available travel options

### 🏨 Hotel Booking

* Browse available hotels
* View hotel details
* Book hotels
* Booking confirmation page

### 🚗 Vehicle Rentals

* Browse available rental vehicles
* View rental details
* Book rental vehicles
* Rental booking confirmation

### 🧳 Trips

* Explore available trips
* View detailed trip information
* Book trips
* Trip booking functionality

### ⭐ Customer Reviews

* Submit destination reviews
* Give ratings from 1–5 stars
* View approved customer reviews

### 📩 Contact Us

* Contact form
* Name, email and phone details
* Subject and message submission
* Contact messages stored in the database

### 📱 Responsive Design

* Mobile-friendly interface
* Responsive layouts
* Bootstrap-based components
* Modern travel-focused UI

---

## 🖥️ Live Demo

Visit the live application:

**https://wandernest.infinityfreeapp.com/**

---

## 🛠️ Technologies Used

| Technology      | Purpose                   |
| --------------- | ------------------------- |
| PHP             | Backend development       |
| MySQL           | Database management       |
| HTML5           | Web page structure        |
| CSS3            | Styling and layout        |
| JavaScript      | Client-side functionality |
| Bootstrap 5.3.3 | Responsive UI             |
| PDO             | Database connectivity     |
| InfinityFree    | Website hosting           |

---

## 📂 Project Structure

```text
WanderNest/
│
├── assets/
│   ├── css/
│   │   └── style.css
│   │
│   ├── images/
│   │   ├── destinations/
│   │   ├── hotels/
│   │   ├── rentals/
│   │   ├── trips/
│   │   ├── about.jpg
│   │   └── home.jpg
│   │
│   └── js/
│       └── script.js
│
├── config/
│   └── database.php
│
├── includes/
│   ├── navbar.php
│   └── footer.php
│
├── index.php
├── about.php
├── contact.php
├── destination.php
├── destinations.php
│
├── hotels.php
├── hotel-details.php
├── book-hotel.php
├── hotel-booking-success.php
│
├── rentals.php
├── rental-details.php
├── book-rental.php
├── rental-booking-success.php
│
├── trips.php
├── trip-details.php
├── book-trip.php
│
├── reviews.php
│
├── login.php
├── register.php
├── logout.php
│
├── .htaccess
└── README.md
```

---

## 🚀 Main Modules

### 1. Authentication Module

Users can create an account and log in to access the main WanderNest platform.

```text
Register
   ↓
Login
   ↓
Authenticated Session
   ↓
WanderNest Home
```

### 2. Destination Module

Users can browse different destinations and view information about places they may want to visit.

```text
Destinations
      ↓
Destination List
      ↓
Destination Details
```

### 3. Hotel Module

Users can explore hotels and complete hotel bookings.

```text
Hotels
  ↓
Hotel Details
  ↓
Booking Form
  ↓
Booking Confirmation
```

### 4. Rental Module

Users can browse rental vehicles and book them for their journey.

```text
Rentals
   ↓
Rental Details
   ↓
Booking Form
   ↓
Booking Confirmation
```

### 5. Trip Module

Users can discover available trips and make trip bookings.

```text
Trips
  ↓
Trip Details
  ↓
Booking
  ↓
Confirmation
```

### 6. Review Module

Users can submit ratings and reviews for destinations.

```text
Select Destination
       ↓
Give Rating
       ↓
Write Review
       ↓
Submit Review
       ↓
Approved Reviews
```

---

## 🗄️ Database

WanderNest uses **MySQL** for storing application data.

The application uses PHP **PDO** for database connectivity.

The database supports data related to:

* Users
* Destinations
* Hotels
* Hotel bookings
* Rental vehicles
* Rental bookings
* Trips
* Trip bookings
* Reviews
* Contact messages

---

## 🔄 Application Flow

```text
                    ┌──────────────────┐
                    │     WanderNest   │
                    └────────┬─────────┘
                             │
             ┌───────────────┼───────────────┐
             │               │               │
          Login           Register        Explore
             │                               │
             └───────────────┬───────────────┘
                             │
                       Home Dashboard
                             │
       ┌─────────────┬───────┼───────┬─────────────┐
       │             │       │       │             │
 Destinations      Trips   Hotels  Rentals       Reviews
       │             │       │       │             │
       └─────────────┴───────┼───────┴─────────────┘
                             │
                         Bookings
                             │
                       Confirmation
```

---

## 💻 Installation & Setup

### Prerequisites

Make sure you have:

* PHP 8.x or compatible PHP version
* MySQL
* Apache server
* XAMPP / WAMP / Laragon or similar local server
* Web browser

---

### Step 1 – Clone the Repository

```bash
git clone https://github.com/YOUR-USERNAME/wandernest.git
```

Then move into the project directory:

```bash
cd wandernest
```

---

### Step 2 – Configure Database

Open:

```text
config/database.php
```

Configure your MySQL database credentials:

```php
$host = "localhost";
$dbname = "wandernest";
$username = "root";
$password = "";
```

> ⚠️ Do not upload real database passwords or production credentials to a public GitHub repository.

---

### Step 3 – Create the Database

Create a MySQL database named:

```text
wandernest
```

Import the required database tables/data into the database.

---

### Step 4 – Start the Server

For XAMPP:

1. Start **Apache**
2. Start **MySQL**
3. Place the project inside:

```text
htdocs/
```

Example:

```text
C:/xampp/htdocs/wandernest/
```

---

### Step 5 – Open the Website

Open:

```text
http://localhost/wandernest/
```

---

## 🔒 Security Notes

For production deployment:

* Do not expose database passwords in GitHub.
* Use environment variables for database credentials.
* Validate and sanitize user input.
* Use prepared statements for database queries.
* Protect authenticated pages using sessions.
* Use HTTPS.
* Add appropriate authorization checks for sensitive operations.

---

## 📸 Website Sections

WanderNest contains several major pages:

* 🏠 Home
* 📖 About
* 📍 Destinations
* 🧳 Trips
* 🏨 Hotels
* 🚗 Rentals
* ⭐ Reviews
* 📩 Contact
* 🔐 Login
* 📝 Register
* 📋 Booking pages

---

## 🎯 Project Objective

The main objective of WanderNest is to provide a single platform where travelers can discover destinations and manage different travel-related services such as:

**Destination discovery → Trip planning → Hotel booking → Vehicle rental → Reviews**

This project demonstrates the development of a database-driven travel website using PHP, MySQL, HTML, CSS, JavaScript and Bootstrap.

---

## 🌐 Live Project

🚀 **WanderNest Live Website:**

https://wandernest.infinityfreeapp.com/

---

## 👨‍💻 Project

**Project Name:** WanderNest

**Category:** Travel & Tourism Web Application

**Type:** Full-Stack Web Application

**Backend:** PHP

**Database:** MySQL

**Frontend:** HTML, CSS, JavaScript, Bootstrap

**Hosting:** InfinityFree

---

## 📄 License

This project is created for educational and project-development purposes.

---

## ⭐ Support

If you find this project useful, consider giving the repository a ⭐ on GitHub.
