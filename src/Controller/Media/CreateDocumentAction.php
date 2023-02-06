<?php

// api/src/Controller/CreateImageAction.php

namespace App\Controller\Media;
use Doctrine\DBAL\Connection;
use App\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateDocumentAction extends AbstractController
{
    public function __invoke(Request $request): Document
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $document = new Document();
        $document->file = $uploadedFile;

        return $document;
    }
}
