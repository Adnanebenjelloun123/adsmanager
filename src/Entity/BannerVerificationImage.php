<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BannerVerificationImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: BannerVerificationImageRepository::class)]

#[ApiResource(
    denormalizationContext: ['groups' => ['bannerVerificationImage', 'bannerVerificationImage:write']],
    normalizationContext: ['groups' => ['bannerVerificationImage', 'bannerVerificationImage:read']],
)]

class BannerVerificationImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['bannerVerificationImage', 'quotationRequest', 'bannerVerification'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Image::class, inversedBy: 'bannerVerificationImages', cascade: ['persist', 'remove'])]
    #[Groups(['bannerVerificationImage', 'quotationRequest', 'bannerVerification'])]
    private $image;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['bannerVerificationImage', 'quotationRequest', 'bannerVerification'])]
    private $label;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['bannerVerificationImage', 'quotationRequest', 'bannerVerification'])]
    private $note;

    #[ORM\ManyToOne(targetEntity: BannerVerification::class, inversedBy: 'images', cascade: ['persist'])]
    #[Groups(['Image:read', 'bannerVerificationImage'])]
    private $bannerVerification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getbannerVerification(): ?BannerVerification
    {
        return $this->bannerVerification;
    }

    public function setbannerVerification(?BannerVerification $bannerVerification): self
    {
        $this->bannerVerification = $bannerVerification;

        return $this;
    }
}
