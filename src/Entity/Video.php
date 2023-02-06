<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Media\CreateVideoAction;
use App\Repository\VideoRepository;
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
    normalizationContext: ['groups' => ['video:read']], 
    denormalizationContext: ['groups' => ['video', 'video:write']],
    types: ['https://schema.org/MediaObject'],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: CreatevideoAction::class, 
            deserialize: false, 
            validationContext: ['groups' => ['Default', 'video_create']], 
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


#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['video:read', 'banner:read'])]
    private ?int $id = null;

    #[ApiProperty(types: 'http://schema.org/contentUrl')]
    #[Groups(['video', 'banner', 'quotationRequest' , 'bannerVerification'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'media', fileNameProperty: 'contentPath')]
    #[Assert\NotNull(groups: ['video_create' , 'banner', 'quotationRequest' , 'bannerVerification'])]
    public ?File $file = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['video' , 'banner', 'quotationRequest' , 'bannerVerification'])]
    #[ApiProperty(types: 'http://schema.org/name')]
    private ?string $contentPath = null;

    #[ORM\OneToOne(inversedBy: 'video', cascade: ['persist', 'remove'])]
    #[Groups(['video'])]
    private ?Banner $banner = null;
    
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

    public function setFile(?File $file): Video
    {
        $this->file = $file;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getBanner(): ?Banner
    {
        return $this->banner;
    }

    public function setBanner(?Banner $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

}
