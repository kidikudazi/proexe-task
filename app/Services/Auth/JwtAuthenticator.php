<?php

namespace App\Services\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Carbon\CarbonImmutable;

class JwtAuthenticator
{
    public function create($data)
    {
        $key = InMemory::plainText(env('JWT_SECRET'));
        $signer = new Sha256();
        $builder = new Builder();
        $token = $builder->setIssuer(getenv("APP_URL"))->setIssuedAt(CarbonImmutable::now())->setNotBefore(CarbonImmutable::now()->subMinutes(1))->setExpiration(CarbonImmutable::now()->addMinutes(1440))->set("user", $data)->getToken($signer, $key);

        return $token->__toString();
    }
}
