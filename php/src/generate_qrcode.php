// charge.php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('YOUR_SECRET_KEY');

// Token is created using Checkout or Elements!
// Get the payment token submitted by the form:
$token = $_POST['stripeToken'];

// Charge the user's card:
$charge = \Stripe\Charge::create([
'amount' => 999,
'currency' => 'usd',
'description' => 'Example charge',
'source' => $token,
]);

echo 'Payment successful!';