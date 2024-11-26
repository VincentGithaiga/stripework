<?php
require 'vendor/autoload.php';
if (1) {
    $stripe = new \Stripe\StripeClient('sk_test_51QP0RgIVIbzcXMVi2NXBfCEezXPqKe3PrNgsX5wXVniblwNB3ioXdXvS4w4fuPXDggy1i0cTkzRVU1PiuJjySM6l00Hrps7TV8');


    $customer = $stripe->customers->create(
        [
            'name' => "John",
            'address' => [
                'line1' => "Demo Address",
                'postal_code' => "738933",
                'city' => "New york",
                'state' => "NY",
                'country' => "US",
            ]
        ]
    );
    $ephemeralKey = $stripe->ephemeralKeys->create([
        'customer' => $customer->id,
    ], [
        'stripe_version' => '2024-11-20.acacia',
    ]);

    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => 1099,
        'currency' => 'usd',
        'description' => 'Payment for Android Course',
        'customer' => $customer->id,
        // In the latest version of the API, specifying the `automatic_payment_methods` parameter
        // is optional because Stripe enables its functionality by default.
        'automatic_payment_methods' => [
            'enabled' => 'true',
        ],
    ]);

    echo json_encode(
        [
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => 'pk_test_51QP0RgIVIbzcXMViBIbIegNyFDe4bpNjXvlSBpubPgAoRjgaWSBLDdXtCIpQw5kFgyqGbGNXxPCz9at7FST7VIry00gg2Ge0Pv'
        ]
    );
    http_response_code(200);
}else{
    echo "Not authorised";
}