<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{

    /* * 
 * @var string|null
 * @Assert\NotBlank()
 */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

       /* * 
 * @var string|null
 * @Assert\NotBlank()
 * @Assert\Length(min=4, max=40)
 */
    #[ORM\Column(type: 'string', length: 40)]
    private $Name;

       /* * 
 * @var string|null
 * @Assert\NotBlank()
 * @Assert\Email()
 */

    #[ORM\Column(type: 'string', length: 255)]
    private $Email;

       /* * 
 * @var string|null
 * @Assert\NotBlank()
 * @Assert\Question()
 */

    #[ORM\Column(type: 'text')]
    private $Question;

           /* * 
 * @var string|null
 * @Assert\NotBlank()
 * @Assert\Lenght(min=10)
 */
    #[ORM\Column(type: 'text')]
    private $Message;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date;

    // #[ORM\Column(type: 'string', length: 50, nullable: true)]
    // private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->Question;
    }

    public function setQuestion(string $Question): self
    {
        $this->Question = $Question;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
