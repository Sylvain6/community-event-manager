<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Dto\SpeakerRequest;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use App\Service\FileUploaderInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Edit
{
    private $renderer;
    private $router;
    private $formFactory;
    private $speakerRepository;
    private $fileUploader;
    private $eventService;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploaderInterface $fileUploader,
        EventServiceInterface $eventService
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $speaker = $this->speakerRepository->find($id);
        dump($speaker);
        die;
        if (!$speaker) {
            throw new NotFoundHttpException();
        }

        $speakerRequest = SpeakerRequest::createFromEntity($speaker);
        $form = $this->formFactory->create(SpeakerType::class, $speakerRequest);

        if (!$this->eventService->isEventSelected()) {
            $form->remove('isInterviewSent');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($speakerRequest->photo)) {
                $speakerRequest->photoPath = $this->fileUploader->upload($speakerRequest->photo);
            }

            $speaker = $speakerRequest->updateEntity($speaker);
            $this->speakerRepository->save($speaker);

            return new RedirectResponse($this->router->generate('speaker_show', [
                'id' => $speaker->getId(),
            ]));
        }

        return new Response($this->renderer->render('speaker/edit.html.twig', [
            'speaker' => $speaker,
            'form' => $form->createView(),
        ]));
    }
}
