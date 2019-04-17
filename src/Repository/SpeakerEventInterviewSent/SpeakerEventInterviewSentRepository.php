<?php

declare(strict_types=1);

namespace App\Repository\SpeakerEventInterviewSent;

use App\Entity\Event;
use App\Entity\Speaker;
use App\Entity\SpeakerEventInterviewSent;
use Doctrine\ORM\EntityManagerInterface;

final class SpeakerEventInterviewSentRepository implements SpeakerEventInterviewSentRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SpeakerEventInterviewSent::class);
    }

    public function save(SpeakerEventInterviewSent $event): void
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SpeakerEventInterviewSent
    {
        return $this->repository->find($id);
    }

    public function findBySpeakerAndEvent(Speaker $speaker, Event $event): ?SpeakerEventInterviewSent
    {
        return $this->repository->findOneBy(['speaker' => $speaker, 'event' => $event]);
    }

    public function remove(Event $event): void
    {
        $this->entityManager->remove($event);
        $this->entityManager->flush();
    }
}
