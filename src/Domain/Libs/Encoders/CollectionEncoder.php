<?php

namespace ZnCrypt\Base\Domain\Libs\Encoders;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Helpers\InstanceHelper;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnCore\Contract\Encoder\Interfaces\DecodeInterface;
use ZnCore\Contract\Encoder\Interfaces\EncodeInterface;

class CollectionEncoder implements EncoderInterface
{

    use ContainerAwareTrait;

    private $encoderCollection;

    public function __construct(Collection $encoderCollection, ContainerInterface $container = null)
    {
        $this->encoderCollection = $encoderCollection;
        $this->setContainer($container);
    }

    public function encode($data)
    {
        $data = EntityHelper::toArray($data);
        $encoders = $this->encoderCollection->all();
        foreach ($encoders as $encoderClass) {
            /** @var EncodeInterface $encoderInstance */
//            (new InstanceResolver($this->ensureContainer()))->ensure();
            $encoderInstance = InstanceHelper::ensure($encoderClass, [], $this->ensureContainer());
            $data = $encoderInstance->encode($data);
        }
        return $data;
    }

    public function decode($data)
    {
        $encoders = $this->encoderCollection->all();
        $encoders = array_reverse($encoders);
        foreach ($encoders as $encoderClass) {
            /** @var DecodeInterface $encoderInstance */
            $encoderInstance = InstanceHelper::ensure($encoderClass, [], $this->ensureContainer());
            $data = $encoderInstance->decode($data);
        }
        return $data;
    }
}
