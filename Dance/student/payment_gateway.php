<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>

<div  id="payment-details">
    <h2>Payment Details</h2>
    <p><strong>User ID:</strong> <span id="userId"></span></p>
    <p><strong>Payment Option:</strong> <span id="paymentOption"></span></p>
    <p><strong>Total Amount:</strong> $<span id="totalAmount"></span></p>
    <button class="pay_button" onclick="confirmPayment()">Pay Now</button>
</div>

<script>
    
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    
    function displayPaymentDetails() {
        var userId = getParameterByName('user_id');
        var paymentOption = getParameterByName('payment_option');
        var totalAmount = getParameterByName('total_amount');

        document.getElementById('userId').textContent = userId;
        document.getElementById('paymentOption').textContent = paymentOption;
        document.getElementById('totalAmount').textContent = totalAmount;
    }

    
    function confirmPayment() {
        var confirmed = confirm("Are you sure you want to proceed with the payment?");
        if (confirmed) {
            displayProcessingStatus();
        }
    }

    
    function displayProcessingStatus() {
        alert("Payment processing...Don't click the back button or refresh the site.");
        setTimeout(function () {
            alert("Payment successful!");
            window.location.href = 'login.php'; 
        }, 2000);
    }

    
    window.onload = function () {
        displayPaymentDetails();
    };
</script>

</body>
</html>
