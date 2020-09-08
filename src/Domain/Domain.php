<?php

namespace ZnCrypt\Base\Domain;

use ZnCore\Base\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'crypt';
    }


}

