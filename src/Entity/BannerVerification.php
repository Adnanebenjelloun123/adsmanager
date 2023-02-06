<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\BannerVerificationRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    denormalizationContext: ['groups' => ['bannerVerification', 'bannerVerification:write']],
    normalizationContext: ['groups' => ['bannerVerification', 'bannerVerification:read']],
)]

#[ORM\Entity(repositoryClass: bannerVerificationRepository::class)]
// filter by date order by date

class BannerVerification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['bannerVerification', 'bannerVerification:read', 'bannerVerificationImage', 'quotationRequest:read'])]
    private $id;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['bannerVerification', 'banner:read', 'quotationRequest:read'])]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bannerVerifications')]
    #[Groups(['bannerVerification', 'banner:read', 'quotationRequest:read'])]
    private $createdBy;

    #[ORM\ManyToOne(targetEntity: banner::class, inversedBy: 'bannerVerifications')]
    #[Groups(['bannerVerification', 'quotationRequest:read'])]
    private $banner;



    #[ORM\OneToOne(targetEntity: Video::class, cascade: ['persist', 'remove'])]
    #[Groups(['bannerVerification', 'banner:read', 'quotationRequest:read'])]
    private $video;

    #[ORM\OneToMany(mappedBy: 'bannerVerification', targetEntity: BannerVerificationImage::class)]
    #[Groups(['banner:read', 'bannerVerification', 'quotationRequest:read'])]
    private $images;



    public function __construct()
    {
        $this->images = new ArrayCollection();
        // fill created at 
        $this->createdAt = new \DateTimeImmutable();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getbanner(): ?banner
    {
        return $this->banner;
    }

    public function setbanner(?banner $banner): self
    {
        $this->banner = $banner;

        return $this;
    }


    /**
     * @return Collection<int, bannerVerificationImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(bannerVerificationImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setbannerVerification($this);
        }

        return $this;
    }

    public function removeImage(bannerVerificationImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getbannerVerification() === $this) {
                $image->setbannerVerification(null);
            }
        }

        return $this;
    }

  
}
