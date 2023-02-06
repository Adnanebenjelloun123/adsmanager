<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Media\CreateDocumentAction;
use App\Repository\DocumentRepository;
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
#[ApiResource(operations: [
    new Get(),
    new Post(
        controller: CreateDocumentAction::class, 
        deserialize: false, 
        output: false,
        validationContext:['Default', 'document_create'],
        openapiContext : [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

    ),
    new GetCollection()
])]

#[ApiResource(
    denormalizationContext: ['groups' => ['document', 'document:write']],
    normalizationContext: ['groups' => ['document', 'document:read']],
)]
#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['document:read'])]
    #[ApiProperty(types: 'http://schema.org/name')]
    private ?string $contentPath = null;

    #[ApiProperty(types: 'http://schema.org/contentUrl')]
    #[Groups(['document:read', 'banner:read'])]
    public ?string $contentUrl = null;

    #[ORM\OneToMany(mappedBy: 'brochureDocument', targetEntity: banner::class)]
    private ?Collection $banners;

    #[Vich\UploadableField(mapping: 'media', fileNameProperty: 'contentPath')]
    #[Assert\NotNull(groups: ['document_create'])]
    public ?File $file = null;

    public function __construct()
    {
        $this->banners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentPath(): ?string
    {
        return $this->contentPath;
    }

    public function setContentPath(string $contentPath): self
    {
        $this->contentPath = $contentPath;

        return $this;
    }

    /**
     * @return Collection|banner[]
     */
    public function getBanners(): Collection
    {
        return $this->banners;
    }

    public function addBanner(banner $banner): self
    {
        if (!$this->banners->contains($banner)) {
            $this->banners[] = $banner;
     
        }

        return $this;
    }
}
