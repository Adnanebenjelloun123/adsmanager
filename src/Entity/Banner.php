<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\DataProvider\ProductLatestDataProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Uid\UuidV6;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\BannerRepository;

#[ApiResource(
    normalizationContext: ['groups' => ['banner','banner:read']], 
    denormalizationContext: ['groups' => ['banner', 'banner:write']],
)]

#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['banner', 'banner:read','banner:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['banner', 'banner:read','banner:write'])]
    private ?string $emplacement = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['banner', 'banner:read','banner:write'])]
    private ?int $volume = null;

    #[ORM\ManyToOne(inversedBy: 'banners')]
    #[Groups(['banner', 'banner:read','banner:write'])]
    private ?Campain $campain = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['banner'])]
    private ?string $videoUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['banner'])]
    private ?string $buttonUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['banner'])]
    private ?string $buttonText = null;

    #[ORM\OneToOne(mappedBy: 'banner', cascade: ['persist', 'remove'])]
    #[Groups(['banner'])]
    private ?Image $image = null;

    #[ORM\OneToOne(mappedBy: 'banner', cascade: ['persist', 'remove'])]
    #[Groups(['banner'])]
    private ?Video $video = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['banner'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(?string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getCampain(): ?Campain
    {
        return $this->campain;
    }

    public function setCampain(?Campain $campain): self
    {
        $this->campain = $campain;

        return $this;
    }

    public function getButtonUrl(): ?string
    {
        return $this->buttonUrl;
    }

    public function setButtonUrl(?string $buttonUrl): self
    {
        $this->buttonUrl = $buttonUrl;

        return $this;
    }

    public function getButtonText(): ?string
    {
        return $this->buttonText;
    }

    public function setButtonText(?string $buttonText): self
    {
        $this->buttonText = $buttonText;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        // set the owning side of the relation if necessary
        if ($image->getBanner() !== $this) {
            $image->setBanner($this);
        }

        $this->image = $image;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        // unset the owning side of the relation if necessary
        if ($video === null && $this->video !== null) {
            $this->video->setBanner(null);
        }

        // set the owning side of the relation if necessary
        if ($video !== null && $video->getBanner() !== $this) {
            $video->setBanner($this);
        }

        $this->video = $video;

        return $this;
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
}
