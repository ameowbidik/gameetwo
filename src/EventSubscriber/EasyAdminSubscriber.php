<?php

namespace App\EventSubscriber;

use App\Entity\Hotnew;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\EventSubscriber\EasyAdminSubscriber;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;




class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $security;
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger, Security $security)
    {
        $this->slugger = $slugger;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return[
            BeforeEntityPersistedEvent::class => ['setHotnewSlugAndDateAndUser'],
        ];
    }

    public function setHotnewSlugAndDateAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if (!($entity instanceof Hotnew)) {
            return;
        }

        $slug = $this->slugger->slug($entity->getTitle());
        $entity->setSlug($slug);
        
        $now = new \DateTime('now');
        $entity->setCreateAt($now);

        $user = $this->security->getUser();
        $entity->setUser($user);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

    }

}