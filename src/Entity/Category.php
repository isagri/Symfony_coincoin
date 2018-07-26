<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advertisment", mappedBy="category")
     */
    private $advertisments;

    public function __construct()
    {
        $this->advertisments = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $advertisment->setCategory($this);
        }

        return $this;
    }

    public function removeAdvertisment(Advertisment $advertisment): self
    {
        if ($this->advertisments->contains($advertisment)) {
            $this->advertisments->removeElement($advertisment);
            // set the owning side to null (unless already changed)
            if ($advertisment->getCategory() === $this) {
                $advertisment->setCategory(null);
            }
        }

        return $this;
    }
}
