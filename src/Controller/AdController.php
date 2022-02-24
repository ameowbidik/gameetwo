<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use App\Form\AdType;
use App\Form\SearchAdType;
use App\Service\MediaService;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ad', name: 'ad_')]
class AdController extends AbstractController
{
    private $em;
    private $adRepository;
    private $mediaService;

    public function __construct(
        EntityManagerInterface $em,
        AdRepository $adRepository,
        MediaService $mediaService,
    ){
        $this->em = $em;
        $this->adRepository = $adRepository;
        $this->mediaService = $mediaService;
    }

    #[Route('/', name: 'list')]
    public function list(AdRepository $adRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $searchForm = $this->createForm(SearchAdType::class);
        $searchForm->handleRequest($request);
        $searchCriteria = $searchForm->getData();

        $ads = $this->adRepository->search($searchCriteria);
        $ads = $adRepository->findAll();

        $ads = $paginator->paginate(
            $ads,
            $request->query->getInt('page', 1), 
            6
        );

        return $this->render('ad/list.html.twig', [
            'ads' => $ads,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('{id}/show', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $ad = $this->adRepository->find($id);

        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    #[Route('/new', name: 'new')]
    #[Route('{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER')]
    public function form(Request $request, Ad $ad = null): Response
    {
        if($ad){
            $isNew = false;
        }else{
            $ad = new Ad();
            $ad->setOwner($this->getUser());
            $isNew = true;
        }

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            // TODO - Remplacer par l'utilisateur connecté
            // $user = $this->em->getRepository(User::class)->find(1);
            // $ad->setUser($user);
            $this->mediaService->handleAd($ad);
            $this->em->persist($ad);
            $this->em->flush();

            $message = sprintf('Votre événement à bien été %s', $isNew ? 'créé' : 'modifié');
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('ad_show', [
                'id' => $ad->getId(),
            ]);
        }
        return $this->render('ad/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}
