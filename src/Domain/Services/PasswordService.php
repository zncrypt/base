<?php

namespace ZnCrypt\Base\Domain\Services;

use ZnCrypt\Base\Domain\Exceptions\InvalidPasswordException;
use ZnCrypt\Base\Domain\Interfaces\Services\PasswordServiceInterface;
use ZnCore\Base\Legacy\Yii\Base\Security;

class PasswordService implements PasswordServiceInterface
{

    private $security;

    public function __construct()
    {
        $this->security = new Security;
    }

    public function validate(string $password, string $hash): bool
    {
        $isValidPassword = $this->security->validatePassword($password, $hash);
        if( ! $isValidPassword) {
            throw new InvalidPasswordException;
        }
        return $isValidPassword;
    }

    public function generateHash(string $password, int $cost = null): string
    {
        return $this->security->generatePasswordHash($password, $cost);
    }

}
