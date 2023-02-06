<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChatbotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatbotRepository::class)]
#[ApiResource]
class Chatbot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Campain::class, inversedBy: 'chatbots')]
    private Collection $campains;

    public function __construct()
    {
        $this->campains = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Campain>
     */
    public function getCampains(): Collection
    {
        return $this->campains;
    }

    public function addCampain(Campain $campain): self
    {
        if (!$this->campains->contains($campain)) {
            $this->campains->add($campain);
        }

        return $this;
    }

    public function removeCampain(Campain $campain): self
    {
        $this->campains->removeElement($campain);

        return $this;
    }
}
