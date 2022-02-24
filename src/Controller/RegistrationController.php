<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager , MailerInterface  $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
        
            //Generation du token pour la verif de l'email
            $user->setActivationToken(md5(uniqid()));

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            //On crée notre message
            $message =(new Email())
                ->subject("Activation de votre compte")
                //expediteur
                ->from('gameetu@outlook.fr')
                //destinataire
                ->to($user->getEmail())
                //contenu
                ->html(
                    $this->renderView(
                        'email/activation.html.twig', ['token'=> $user->getActivationToken()]
                    ),
                    'text/html'
                );
            
            $this->addFlash('message', 'Un lien de confirmation vous a été envoyé');

            //On envoie le mail
            $mailer->send($message);
            
            return $this->redirectToRoute('main_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
        //creation de la methode pour verifier l'email

    #[Route('/activation/{token}', name:'activation')]
    public function activation($token, UserRepository $userRepo){
        //on verifie si un utilisateur a ce token
        $user = $userRepo->findOneBy(['activation_token'=> $token]);

        //on verifie si aucun utilisateur existe avec ce token

        if(!$user){
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        //On supprime le token s'il existe
        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        //Message flash

        $this->addFlash('message', 'Vous avez bien activé votre compte');

        //retour à l'accueil

        return $this->redirectToRoute('main_index');
    }
}