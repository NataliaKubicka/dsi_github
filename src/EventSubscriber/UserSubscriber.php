<?php

namespace App\EventSubscriber;

use App\Entity\Users;
use App\Mailer\Mailer;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

class UserSubscriber implements EventSubscriber
{

    /**
     * @var \Doctrine\ORM\UnitOfWork
     */
    private $uow;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $this->entityManager = $args->getEntityManager();
        $this->uow = $this->entityManager->getUnitOfWork();

        // On Insert
        /* @var Users $entity */
        foreach ($this->uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof Users) {
                $this->mailer->sendWelcomeEmail($entity);
            }
        }
    }
}
