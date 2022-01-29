<?php

namespace ZnCrypt\Base\Domain\Services;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use ZnCrypt\Base\Domain\Exceptions\InvalidPasswordException;
use ZnCrypt\Base\Domain\Interfaces\Services\PasswordServiceInterface;

class PasswordService implements PasswordServiceInterface
{

    private $passwordHasher;

    public function __construct(PasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function validate(string $password, string $hash): bool
    {
        $isValidPassword = $this->passwordHasher->verify(trim($hash), trim($password));
        if (!$isValidPassword) {
            throw new InvalidPasswordException;
        }
        return $isValidPassword;
    }

    public function generateHash(string $password, int $cost = null): string
    {
        return $this->passwordHasher->hash($password, $cost);
    }

}
