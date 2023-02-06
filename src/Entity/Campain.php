<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CampainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampainRepository::class)]
#[ApiResource]
class Campain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'campain', targetEntity: Banner::class)]
    private Collection $banners;

    #[ORM\ManyToMany(targetEntity: Chatbot::class, mappedBy: 'campains')]
    private Collection $chatbots;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    public function __construct()
    {
        $this->banners = new ArrayCollection();
        $this->chatbots = new ArrayCollection();
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
     * @return Collection<int, Banner>
     */
    public function getBanners(): Collection
    {
        return $this->banners;
    }

    public function addBanner(Banner $banner): self
    {
        if (!$this->banners->contains($banner)) {
            $this->banners->add($banner);
            $banner->setCampain($this);
        }

        return $this;
    }

    public function removeBanner(Banner $banner): self
    {
        if ($this->banners->removeElement($banner)) {
            // set the owning side to null (unless already changed)
            if ($banner->getCampain() === $this) {
                $banner->setCampain(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Chatbot>
     */
    public function getChatbots(): Collection
    {
        return $this->chatbots;
    }

    public function addChatbot(Chatbot $chatbot): self
    {
        if (!$this->chatbots->contains($chatbot)) {
            $this->chatbots->add($chatbot);
            $chatbot->addCampain($this);
        }

        return $this;
    }

    public function removeChatbot(Chatbot $chatbot): self
    {
        if ($this->chatbots->removeElement($chatbot)) {
            $chatbot->removeCampain($this);
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
