<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Container\ConfigInterface;
use Common\Middleware\JwtMiddleware;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\LocalFileReference;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Psr\Container\ContainerInterface;

class JwtMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): JwtMiddleware
    {
        $config = $container->get(ConfigInterface::class);
        $callable = function ($jwt) use ($config): Token {
            $key = LocalFileReference::file($config->get('security.jwt.public-key'));
            $signer = new Sha256();
            $configuration = Configuration::forSymmetricSigner(
                $signer,
                $key,
            );
            $configuration->setValidationConstraints(new SignedWith($signer, $key));
            $token = $configuration->parser()->parse($jwt);
            $constraints = $configuration->validationConstraints();

            $configuration->validator()->assert($token, ...$constraints);
            return $token;
        };

        return new JwtMiddleware($callable);
    }
}
