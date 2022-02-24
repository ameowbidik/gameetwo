<?php

namespace App\Service;

use App\Entity\Ad;
use App\Entity\Event;
use App\Service\MediaService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MediaService{
    private $config;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->config = $parameterBag->get('media');
    }
    
    public function handleEvent(Event $event)
    {
        if($event->getPicture())
        {
            $event->setPicture($event->getPicture());
        }else if($event->getPictureFile())
        {
            $file = $event->getPictureFile();
            $name = sprintf('image_%s.%s', uniqid(), $file->guessExtension());
            $file->move($this->config['path'], $name);
            $event->setPicture($name);
        }
    }
    public function handleAd(Ad $ad)
    {
        if($ad->getPicture())
        {
            $ad->setPicture($ad->getPicture());
        }else if($ad->getPictureFile())
        {
            $file = $ad->getPictureFile();
            $name = sprintf('image_%s.%s', uniqid(), $file->guessExtension());
            $file->move($this->config['path'], $name);
            $ad->setPicture($name);
        }
    }
}