<?php

namespace ZnCrypt\Base\Domain\Libs\Encoders;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\Code\InstanceResolver;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;
use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Base\Helpers\InstanceHelper;

class CollectionEncoder implements EncoderInterface
{

    use ContainerAwareTrait;

    private $encoderCollection;

    public function __construct(Collection $encoderCollection, ContainerInterface $container = null)
    {
        $this->encoderCollection = $encoderCollection;
        $this->setContainer($container);
    }

    public function encode($data) {
        $data = EntityHelper::toArray($data);
        $encoders = $this->encoderCollection->all();
        foreach ($encoders as $encoderClass) {
            /** @var EncoderInterface $encoderInstance */
//            (new InstanceResolver($this->ensureContainer()))->ensure();
            $encoderInstance = InstanceHelper::ensure($encoderClass);
            $data = $encoderInstance->encode($data);
        }
        return $data;
    }

    public function decode($data) {
        $encoders = $this->encoderCollection->all();
        $encoders = array_reverse($encoders);
        foreach ($encoders as $encoderClass) {
            /** @var EncoderInterface $encoderInstance */
            $encoderInstance = InstanceHelper::ensure($encoderClass);
            $data = $encoderInstance->decode($data);
        }
        return $data;
    }

}
