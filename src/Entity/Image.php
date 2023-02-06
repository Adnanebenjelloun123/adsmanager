<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Media\CreateImageAction;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;

#[Vich\Uploadable]
#[ApiResource(
    normalizationContext: ['groups' => ['image:read']], 
    denormalizationContext: ['groups' => ['image', 'image:write']], 
    types: ['https://schema.org/MediaObject'],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: CreateImageAction::class, 
            deserialize: false, 
            validationContext: ['groups' => ['Default', 'image_create']], 
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'file' => [
                                        'type' => 'string', 
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'contentPath' => 'exact', 'contentUrl' => 'exact','banner'=>'exact'])]

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['image:read', 'banner:read', 'banner:read:latest', 'bannerVerification:read'])]

    private ?int $id = null;

    #[ApiProperty(types: 'http://schema.org/contentUrl')]
    #[Groups(['image:read', 'banner:read', 'banner:read:latest', 'quotationRequest' , 'bannerVerification:read', 'bannerVerificationImage'])]
    public ?string $contentUrl = null;

    #[Assert\NotNull(groups: ['image_create'])]
    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'contentPath')]
    public ?File $file = null;
    
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['image:read'])]
    #[ApiProperty(types: 'http://schema.org/name')]
    public ?string $contentPath = null;

    // #[Assert\NotNull(groups: ['image_create'])]

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: BannerVerificationImage::class)]
    private $bannerVerificationImages;

    #[ORM\OneToOne(inversedBy: 'image', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['image'])]
    private ?Banner $banner = null;

    public function __construct()
    {
        $this->bannerVerificationImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): void
    {
        $this->contentUrl = $contentUrl;
    }

    public function getContentPath(): ?string
    {
        return $this->contentPath;
    }

    public function setContentPath(?string $contentPath): void
    {
        $this->contentPath = $contentPath;
    }

    public function setFile(?File $file): Image
    {
        $this->file = $file;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @return Collection<int, BannerVerificationImage>
     */
    public function getBannerVerificationImages(): Collection
    {
        return $this->bannerVerificationImages;
    }

    public function addBannerVerificationImage(BannerVerificationImage $bannerVerificationImage): self
    {
        if (!$this->bannerVerificationImages->contains($bannerVerificationImage)) {
            $this->bannerVerificationImages[] = $bannerVerificationImage;
            $bannerVerificationImage->setImage($this);
        }

        return $this;
    }

    public function removeBannerVerificationImage(BannerVerificationImage $bannerVerificationImage): self
    {
        if ($this->bannerVerificationImages->removeElement($bannerVerificationImage)) {
            // set the owning side to null (unless already changed)
            if ($bannerVerificationImage->getImage() === $this) {
                $bannerVerificationImage->setImage(null);
            }
        }

        return $this;
    }

    public function getBanner(): ?Banner
    {
        return $this->banner;
    }

    public function setBanner(Banner $banner): self
    {
        $this->banner = $banner;

        return $this;
    }
}
