<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\HotnewRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $userRepository;
    private $teamRepository;
    private $adRepository;
    private $eventRepository;
    private $hotnewRepository;

    public function __construct(
        UserRepository $userRepository,
        TeamRepository $teamRepository,
        AdRepository $adRepository,
        EventRepository $eventRepository,
        HotnewRepository $hotnewRepository,
    ){
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->adRepository = $adRepository;
        $this->eventRepository = $eventRepository;
        $this->hotnewRepository = $hotnewRepository;
    }

    #[Route('/', name: 'main_index')]
    public function index(): Response
    {
        $users = $this->userRepository->findBy(array(),array('id' => 'DESC'),5 ,0);
        $teams = $this->teamRepository->findBy(array(),array('id' => 'DESC'),5 ,0);
        $ads = $this->adRepository->findBy(array(),array('id' => 'DESC'),5 ,0);
        $events = $this->eventRepository->findBy(array(),array('id' => 'DESC'),5 ,0);
        $hotnews = $this->hotnewRepository->findBy(array(),array('id' => 'DESC'),5 ,0);


        return $this->render('main/index.html.twig', [
            'users' => $users,
            'teams' => $teams,
            'ads' => $ads,
            'events' => $events,
            'hotnews' => $hotnews,
        ]);
    }
}