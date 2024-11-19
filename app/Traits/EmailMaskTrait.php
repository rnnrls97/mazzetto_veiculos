<?php

namespace App\Traits;

trait EmailMaskTrait
{
    private function maskEmail($email)
    {
        list($username, $domain) = explode('@', $email);

        $maskedUsername = substr_replace($username, '******', 2, -2);
        $maskedDomain = substr_replace($domain, '****', 1, -3);

        return "{$maskedUsername}@{$maskedDomain}";
    }
}
