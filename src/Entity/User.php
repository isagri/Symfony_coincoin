<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("phone")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $password;

    /**
     * @ORM\Column(type="json_array")
     * @Assert\NotBlank()
     */
    private $roles;

    /**
     * @var plainPassword
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advertisment", mappedBy="author", orphanRemoval=true)
     */
    private $advertisments;


    public function __construct()
    {
        $this->setRoles(["ROLE_USER"]);
        $this->advertisments = new ArrayCollection();
    }


    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->getFirstname();
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Advertisment[]
     */
    public function getAdvertisments(): Collection
    {
        return $this->advertisments;
    }

    public function addAdvertisment(Advertisment $advertisment): self
    {
        if (!$this->advertisments->contains($advertisment)) {
            $this->advertisments[] = $advertisment;
            $advertisment->setAuthor($this);
        }

        return $this;
    }

    public function removeAdvertisment(Advertisment $advertisment): self
    {
        if ($this->advertisments->contains($advertisment)) {
            $this->advertisments->removeElement($advertisment);
            // set the owning side to null (unless already changed)
            if ($advertisment->getAuthor() === $this) {
                $advertisment->setAuthor(null);
            }
        }

        return $this;
    }
}
