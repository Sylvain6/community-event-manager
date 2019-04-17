<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Repository\SpeakerRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $speakerRepository;
    private $eventService;

    public function __construct(Twig $renderer, SpeakerRepositoryInterface $speakerRepository, EventServiceInterface $eventService)
    {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        $speakers = $this->speakerRepository->findAll();
        dump($speakers);


        return new Response($this->renderer->render('speaker/index.html.twig', [
            'speakers' => $speakers,
        ]));
    }
}
