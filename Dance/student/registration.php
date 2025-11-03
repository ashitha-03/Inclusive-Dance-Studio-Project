<?php
include "connection.php";
include "navbar.php";

// Replace with your actual Stripe Secret Key
$stripe_secret_key = 'sk_test_51ODjYYSGlGSUc0RzjOKjj8dUjLAre2o9PkgcFSm6uoEgFim9Oq4QcUwjUU34oIL9BBVe8tFiKnnrjV7yBcBFKKiU00xcksNqSK';

require_once 'vendor/autoload.php'; // This assumes you have installed the Stripe PHP library using Composer
 // This assumes you have installed the Stripe PHP library using Composer

\Stripe\Stripe::setApiKey($stripe_secret_key);

$dance_styles_query = "SELECT * FROM `dance_styles`";
$dance_styles_result = mysqli_query($db, $dance_styles_query);

if (isset($_POST['submit'])) {
    $first = isset($_POST['first']) ? $_POST['first'] : "";
    $last = isset($_POST['last']) ? $_POST['last'] : "";
    $Username = isset($_POST['Username']) ? $_POST['Username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
    $address = isset($_POST['address']) ? $_POST['address'] : "";
    $class_preference = isset($_POST['class_preference']) ? $_POST['class_preference'] : "";
    $medical_info = isset($_POST['medical_info']) ? $_POST['medical_info'] : "";
    $dance_styles = isset($_POST['dance_style']) ? $_POST['dance_style'] : [];
    $payment_option = isset($_POST['payment_option']) ? $_POST['payment_option'] : "";

    $count = 0;
    $sql = "SELECT Username FROM `USERS` WHERE Username='$Username'";
    $res = mysqli_query($db, $sql);

    if (mysqli_num_rows($res) > 0) {
        echo "The username already exists";
    } else {
        
        $sql = "INSERT INTO `USERS` (first, last, Username, password, email, gender, address, class_preference, medical_info, user_type)
            VALUES ('$first', '$last', '$Username', '$password', '$email', '$gender', '$address', '$class_preference', '$medical_info', 0)";

        if (mysqli_query($db, $sql)) {
            $user_id = mysqli_insert_id($db);

            foreach ($dance_styles as $style_id) {
                $sql = "INSERT INTO `student_dance_forms` (student_id, dance_form_id) VALUES ('$user_id', '$style_id')";
                mysqli_query($db, $sql);
            }

            $total_amount = count($dance_styles) * 500;

            // Create a Stripe checkout session
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd', // Change to your currency
                        'product_data' => [
                            'name' => 'Dance Class Registration', // Change to your product name
                        ],
                        'unit_amount' => $total_amount * 100, // Stripe requires amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'YOUR_SUCCESS_URL', // Replace with your success URL
                'cancel_url' => 'YOUR_CANCEL_URL',   // Replace with your cancel URL
            ]);

            header("Location: " . $session->url);
            exit();
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function calculateTotalAmount() {
            var danceStyles = document.getElementsByName('dance_style[]');
            var totalAmount = 0;

            for (var i = 0; i < danceStyles.length; i++) {
                if (danceStyles[i].checked) {
                    totalAmount += 500; 
                }
            }

            document.getElementById('total_amount').innerText = "Total Amount: " + totalAmount + " Rs";
            document.getElementById('hidden_total_amount').value = totalAmount;
        }
    </script>
</head>
<body>

<section>
    <div class="box3">
        <h1 class="reg-text"> InclusiDance </h1>
        <br>
        <h1 class="reg-text">User Registration Form </h1>

        <form name="Registration" method="post" action="" oninput="calculateTotalAmount()">
            <br><br>

            <div class="login">
                <!-- Existing form fields -->
                <input type="text" name="first" placeholder="First Name" required="">
                <br><br>
                <input type="text" name="last" placeholder="Last Name" required="">
                <br><br>
                <input type="text" name="Username" placeholder="Username" required="">
                <br><br>
                <input type="password" name="password" placeholder="Password" required="">
                <br><br>
                <input type="text" name="email" placeholder="Email" required="">
                <br><br>
                Gender:
                <br>
                <input type="radio" name="gender" value="male" id="male" required>
                <label for="male">Male</label>
                <input type="radio" name="gender" value="female" id="female" required>
                <label for="female">Female</label>
                <br><br>
                Address:
                <br>
                <input type="text" name="address" placeholder="Address" required>
                <br><br>
                Class Preference:
                <br>
                <input type="radio" name="class_preference" value="online" id="online" required>
                <label for="online">Online</label>
                <input type="radio" name="class_preference" value="offline" id="offline" required>
                <label for="offline">Offline</label>
                <br><br>
                Do you have any medical conditions or other information to share?
                <br><br>
                <input type="text" name="medical_info" placeholder="Enter any medical conditions or other information">
                <br><br>
                <br><br>
                Dance Style:
                <br><br>
                <?php
                // Display dance styles from the database
                while ($row = mysqli_fetch_assoc($dance_styles_result)) {
                    echo "<input type='checkbox' name='dance_style[]' value='" . $row['id'] . "'>" . $row['dance_form'] . "<br>";
                }
                ?>
                <br><br>

                <!-- Total Amount display -->
                <div id="total_amount">Total Amount: 0 Rs</div>

                <!-- Payment Option dropdown -->
                Payment Option:
                <br>
                <select name="payment_option" required>
                    <option value="stripe">Credit Card</option>
                    <!-- Add other payment options if needed
