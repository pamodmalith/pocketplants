<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('YOUR_SECRET_KEY');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['stripeToken'];
    $amount = 2000; // amount in cents

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $amount,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
        ]);

        // Handle successful payment
        echo "Payment successful!";
    } catch (\Stripe\Exception\CardException $e) {
        // Handle error
        echo 'Error: ' . $e->getMessage();
    }
}
