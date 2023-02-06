<?php
// api/src/Controller/CreateImageAction.php
namespace App\Controller\Media;
use Doctrine\DBAL\Connection;
use App\Entity\Image;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Banner;

#[AsController]
final class CreateImageAction extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {}
    public function __invoke(Request $request)
    {
        $uploadedFile = $request->files->get('file');

        // $BannerImage = $request->get('Banner');

        // $Banner = $this->doctrine->getRepository(Banner::class)->findById($BannerImage);

        // if (!$BannerImage) {
        //     throw new BadRequestHttpException('"Banner" is required');
        // }

        // if (!$Banner) {
        //     throw new BadRequestHttpException('"Banner" is not found');
        // }

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $image = new Image();
        $image->file = $uploadedFile;
        // $image->setBanner($Banner[0]);
        return $image;
    }
}
