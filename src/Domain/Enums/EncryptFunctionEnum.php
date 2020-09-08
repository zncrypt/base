<?php

namespace ZnCrypt\Base\Domain\Enums;

use ZnCore\Base\Domain\Base\BaseEnum;

class EncryptFunctionEnum extends BaseEnum
{

    const HASH_HMAC = 'hash_hmac';
    const OPENSSL = 'openssl';

}
