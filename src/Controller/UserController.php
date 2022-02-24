<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchUserType;
use App\Form\EditProfileType;
use App\Form\RemoveProfileType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{   
    #[Route('/profil', name:'profil_')]
    public function index()
    {
        return $this->render('user/user.html.twig');
    }

    #[Route('/user', name: 'user')]
    public function list(Request $request): Response
    {
        $user = new User();
        $searchForm = $this->createForm (SearchUserType::class);

        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) 
        {
            $this->addFlash('notice','Votre recherche à bien été éffectué');

            return $this->redirectToRoute('user', [
                'id' => $user->getId(),
            ]);
        }
            
        return $this->render('user/list.html.twig', [
            'searchForm'  => $searchForm->createView(),
        ]);
    }

    #[Route('/profil/modifier', name: 'user_profil_modifier')]
    public function editProfile(Request $request): Response
    {
        $user =$this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            // TODO - Remplacer par l'utilisateur connecté
            // $user = $this->em->getRepository(User::class)->find(1);
            // $ad->setUser($user);
            $this->em=$this->getDoctrine()->getManager();
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('notice', 'Votre profil a bien été modifié');

            return $this->redirectToRoute('profil_');
        }
        return $this->render('user/editprofile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/pass/modifier', name: 'user_pass_modifier')]
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            //on verifie si les deux mots de passes sont identiques
            
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('profil_');
            }
            else{
                $this->addFlash('error', 'Les mots de passes ne sont pas identiques');
            }
        }
        return $this->render('user/editpass.html.twig');
    }
}
    // #[Route('/profil/supprimer', name: 'user_remove_profile')]
    // public function removeProfile(Request $request, UserRepository $userRepo,)
    // {
    //     $user = $userRepo->findOneBy(['email']);
    //     $user = $this->getUser();
    //     $form = $this->createForm(RemoveProfileType::class, $user);

        
    //     if($form->isSubmitted() && $form->isValid()) 
    //     {
    //         $this->em->remove($user);
    //         $this->em->flush();

    //         $this->get('request')->getSession()->invalidate();
            
    //         $request->getSession()->getFlashBag()->add('notice', "Votre compte a bien été supprimé.");
        
    //         return $this->redirect($this->generateUrl('user_remove_profile'));
    //     }
        
    //     return $this->render('user/removeprofile.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }

