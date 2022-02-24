<?php

namespace App\Controller;

use app\Entity\User;
use App\Entity\Event;
use App\Form\EventType;
use App\Form\SearchEventType;
use App\Service\MediaService;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('event', name: 'event_')]
class EventController extends AbstractController
{
    private $em;
    private $eventRepository;
    private $mediaService;

    public function __construct(
        EntityManagerInterface $em,
        EventRepository $eventRepository,
        MediaService $mediaService,
    ){
        $this->em = $em;
        $this->eventRepository = $eventRepository;
        $this->mediaService = $mediaService;
    }
    #[Route('', name: 'list')]
    public function list(EventRepository $eventRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $searchForm = $this->createForm(SearchEventType::class);
        $searchForm->handleRequest($request);
        $searchCriteria = $searchForm->getData();

        $events = $this->eventRepository->search($searchCriteria);

        $events = $eventRepository->findAll();

        $events = $paginator->paginate(
            $events,
            $request->query->getInt('page', 1), 
            6
        );

        return $this->render('event/list.html.twig', [
            'events' => $events,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('{id}/show', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $event = $this->eventRepository->find($id);

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
    
    #[Route('/new', name: 'new')]
    #[Route('{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER', subject: 'event')]
    public function form(Request $request, Event $event = null): Response
    {
        if($event){
            $isNew = false;
        }else{
            $event = new Event();
            $event->setOwner($this->getUser());
            $isNew = true;
        }
        
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->mediaService->handleEvent($event);
            $this->em->persist($event);
            $this->em->flush();

            $message = sprintf('Votre événement à bien été %s', $isNew ? 'créé' : 'modifié');
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('event_show', [
                'id' => $event->getId(),
            ]);
        }
        return $this->render('event/form.html.twig', [
            'form' => $form->createView(),
            'isNew' => $isNew        
        ]);
    }
}