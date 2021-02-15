<?php

namespace App\Stripe;

use App\Entity\Purchase;

class StripeService
{
    protected $secretKey;
    protected $publicKey;

    /**
     * StripeService constructor.
     * @param $secretKey
     * @param $publicKey
     */
    public function __construct(string $secretKey, string $publicKey)
    {

        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPaymentIntent(Purchase $purchase)
    {
        \Stripe\Stripe::setApiKey('sk_test_51IJir0FLnDbZ9PY2fQsLZlqfYq8nfuJx1pQbiwpGmwqyA1wtvd99t5cOL9CDbg1w62CTHJ07faZlBncaNEaHKkSA00EkhRPwGr');

        return \Stripe\PaymentIntent::create([
            'amount' => $purchase->getTotal(),
            'currency' => 'eur',
        ]);

    }
}
