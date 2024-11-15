<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Car Rental Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
    <style>
        .welcome-message {
            position: absolute;
            top: 10px;
            right: 20px;
            color: #333;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 5px 15px;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .location-input-wrapper {
            position: relative;
            width: 100%;
        }
        .suggestions {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            width: 100%;
            max-height: 150px;
            overflow-y: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }
        .suggestions div {
            padding: 10px;
            cursor: pointer;
        }

        .suggestions div:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="welcome-message">
        Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!
    </div>
    <header class="header">
        <div class="container">
            <h1>Car Rental Service</h1>
            <div class="navi">
                <nav>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="vehicle.html">Vehicles</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#reviews">Reviews</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </nav>
                <form action="logout.php" method="post" style="display:inline;">
                    <button class="login-btn" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-text">
            <h2>Find the Perfect Car for Your Trip</h2>
            <p>Choose from a wide range of cars available for rent.</p>
            <form class="search-bar">
                <input type="text" placeholder="Car Type" required />
                <div class="location-input-wrapper">
                    <input type="text" id="location-input" placeholder="Pickup Location" required autocomplete="off" />
                    <div id="location-suggestions" class="suggestions">
                        <div>Kottayam</div>
                        <div>Ernakulam</div>
                        <div>Alappuzha</div>
                        <div>Kollam</div>
                        <div>Kochi</div>
                    </div>
                </div>
                <input type="date" required />
                <button type="submit">Search</button>
            </form>
        </div>
    </section>

    <section class="vehicles" id="vehicles">
        <h3>Vehicle Options</h3>
        <div class="vehicle-grid">
            <div class="vehicle-card">
                <img src="https://imgd.aeplcdn.com/600x337/n/cw/ec/48542/ciaz-exterior-right-front-three-quarter-3.jpeg?isig=0&q=80" alt="Sedan car" />
                <h4>Sedan</h4>
                <p>Comfortable and fuel-efficient</p>
            </div>
            <div class="vehicle-card">
                <img src="https://imgd.aeplcdn.com/600x337/n/cw/ec/40432/scorpio-n-exterior-right-front-three-quarter-75.jpeg?isig=0&q=80" alt="SUV car" />
                <h4>SUV</h4>
                <p>Spacious and ideal for families</p>
            </div>
            <div class="vehicle-card">
                <img src="https://www.cartoq.com/wp-content/uploads/2016/08/bmw_lead_2_7series.jpg" alt="Luxury car" />
                <h4>Luxury</h4>
                <p>High-end vehicles for a premium experience</p>
            </div>
        </div>
    </section>

    <section class="pricing" id="pricing">
        <h3>Pricing</h3>
        <p>Check our competitive pricing for various vehicle options.</p>
    </section>

    <section class="reviews" id="reviews">
        <h3>Customer Reviews</h3>
        <p>See what our customers are saying about us.</p>
    </section>

    <section class="contact" id="contact">
        <h3>Contact Us</h3>
        <p>Have questions? Reach out to our customer support.</p>
    </section>

    <footer>
        <p>&copy; 2024 Car Rental Service. All rights reserved.</p>
    </footer>

    <script>
        const locationInput = document.getElementById('location-input');
        const locationSuggestions = document.getElementById('location-suggestions');

        locationInput.addEventListener('focus', () => {
            locationSuggestions.style.display = 'block';
        });

        locationInput.addEventListener('blur', () => {
            setTimeout(() => {
                locationSuggestions.style.display = 'none';
            }, 200);
        });

        locationSuggestions.addEventListener('click', (event) => {
            if (event.target.tagName === 'DIV') {
                locationInput.value = event.target.innerText;
                locationSuggestions.style.display = 'none';
            }
        });
    </script>
</body>
</html>