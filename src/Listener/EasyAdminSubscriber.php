<?php

namespace App\Listener;

use App\Entity\Blog;
use App\Entity\Books;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface as EventDispatcherEventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class EasyAdminSubscriber implements EventDispatcherEventSubscriberInterface
{

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setDateAndUser',
        ];
    }

    public function setDateAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Blog) {

            $user = $this->security->getUser();

            $entity->setCreatedAt(new \DateTime())
                ->setUser($user);
            return;
        }

        if ($entity instanceof Books) {

            $entity->setAvailibility(true);
            return;
        }

        return;
    }
}
