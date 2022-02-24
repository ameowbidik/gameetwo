<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Hotnew;
use App\Form\HotnewType;
use App\Form\SearchHotnewType;
use App\Repository\HotnewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/hotnew', name: 'hotnew_')]
class HotnewController extends AbstractController
{
    private $em;
    private $hotnewRepository;

    public function __construct(
        EntityManagerInterface $em,
        HotnewRepository $hotnewRepository,
    ){
        $this->em = $em;
        $this->hotnewRepository = $hotnewRepository;
    }

    #[Route('', name: 'list')]
    public function list(HotnewRepository $hotnewRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $searchForm = $this->createForm(SearchHotnewType::class);
        $searchForm->handleRequest($request);
        $searchCriteria = $searchForm->getData();

        $hotnews = $this->hotnewRepository->search($searchCriteria);

        $hotnews = $hotnewRepository->findAll();

        $hotnews = $paginator->paginate(
            $hotnews,
            $request->query->getInt('page', 1), 
            6
        );

        return $this->render('hotnew/list.html.twig', [
            'hotnews' => $hotnews,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('{id}/show', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $hotnew = $this->hotnewRepository->find($id);

        return $this->render('hotnew/show.html.twig', [
            'hotnew' => $hotnew,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function form(Request $request, Hotnew $hotnew = null): Response
    {
        if($hotnew){
            $isNew = false;
        }else{
            $hotnew = new Hotnew();
            $hotnew->setUser($this->getUser());
            $isNew = true;
        }

        // $hotnew = new Hotnew();
        $form = $this->createForm(HotnewType::class, $hotnew);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            // TODO - Remplacer par l'utilisateur connecté
            // $user = $this->em->getRepository(User::class)->find(1);
            // $hotnew->setUser($user);

            $this->em->persist($hotnew);
            $this->em->flush();

            $this->addFlash('notice', 'Votre actualité à été créé');

            return $this->redirectToRoute('hotnew_show', [
                'id' => $hotnew->getId(),
            ]);
        }
        return $this->render('hotnew/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
