<?php

namespace App\Service;

use DateTime;
use App\Entity\Contact;
use App\Service\ContactService;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService
{
    private $em;
    private $flash;
    private $mailer;

    public function __construct(EntityManagerInterface $em, FlashBagInterface $flash, MailerInterface $mailer)
    {
      $this->em =$em;
      $this->flash=$flash;
      $this->mailer=$mailer;
    }
    public function persistContact(Contact $contact): void
    {   
      $contact->setDate(new DateTime('now'));

      $this->em->persist($contact);
      $this->em->flush();

      $message= (new Email())
        ->from('gameetu@outlook.fr')
        ->to('gameetu@outlook.fr')
        ->subject('Nouveau message de' . $contact->getId())
        ->text('Expediteur: '.$contact->getEmail(). \PHP_EOL.\PHP_EOL. 
        'Message: ' .$contact->getMessage(),
        'text/plain');

          $this->mailer->send($message);
          
          $this->flash->add('success', 'Votre message a bien été envoyé.');
    }
}
