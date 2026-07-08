<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management Signup</title>
    <style>
        :root {
            --primary-blue: #102A71; /* Dark Blue */
            --hover-yellow: #F5C400; /* Hover Yellow */
            --text-color: #333;
            --white: #FFF;
            --dark-color: #281e32;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
            background: var(--white);
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Signup Form - Larger size */
        .signup-form {
            background: var(--white);
            padding: 50px; /* Increased padding */
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 600px; /* Increased max width */
            width: 100%;
        }

        h2 {
            color: var(--primary-blue);
            margin-bottom: 30px;
            font-size: 32px; /* Larger font */
        }

        input, select {
            width: 100%;
            padding: 18px; /* Increased padding */
            margin-bottom: 20px; /* Increased spacing */
            border: 2px solid var(--primary-blue);
            border-radius: 8px;
            font-size: 20px; /* Larger font size */
        }

        .terms {
            width: auto;
            margin-top: 10px;
            font-size: 16px;
        }

        .btn {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 18px; /* Bigger button */
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 22px; /* Larger font */
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: var(--hover-yellow);
            color: var(--primary-blue);
        }

        .login-link {
            margin-top: 20px;
            font-size: 18px;
        }

        .login-link a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: var(--dark-color);
            color: var(--white);
            text-align: center;
            padding: 20px;
            width: 100%;
            position: sticky;
            bottom: 0;
            font-size: 18px;
        }
    </style>
</head>
<body>
<?php include 'header.php';     ?>
    <div class="container">
        <form action="signup.php" method="post" class="signup-form">
            <h2>Sign Up</h2>
            <input type="text" placeholder="Company Name" name="company" required>
            <input type="email" placeholder="Email Address" name="email" required>
            <input type="password" placeholder="Password" name="password" required>
            <select id="country" name="country">
                <option>Select Country</option>
            </select>
            <select id="state" name="state">
                <option>Select country first</option>
            </select>
            <input type="tel" placeholder="Phone Number" name="phone" required>
            <label class="terms">
                <input type="checkbox" required> I agree to the Terms of Service and Privacy Policy
            </label>
            <button class="btn">Create Your Free Account</button>
            <p class="login-link">Already have an account? <a href="login_form.php">Login</a></p>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        async function fetchCountries() {
            const response = await fetch('https://restcountries.com/v3.1/all');
            const countries = await response.json();
            const countrySelect = document.getElementById('country');
            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));
            countries.forEach(country => {
                let option = document.createElement('option');
                option.value = country.name.common;
                option.textContent = country.name.common;
                countrySelect.appendChild(option);
            });
        }

        async function fetchStates() {
            const countrySelect = document.getElementById('country');
            const stateSelect = document.getElementById('state');
            countrySelect.addEventListener('change', async () => {
                stateSelect.innerHTML = '<option>Loading...</option>';
                const response = await fetch(`https://countriesnow.space/api/v0.1/countries/states`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ country: countrySelect.value })
                });
                const data = await response.json();
                stateSelect.innerHTML = '<option>Select State</option>';
                data.data.states.forEach(state => {
                    let option = document.createElement('option');
                    option.value = state.name;
                    option.textContent = state.name;
                    stateSelect.appendChild(option);
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchCountries();
            fetchStates();
        });
    </script>
</body>
</html>
