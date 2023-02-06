<?php

// api/src/Controller/CreateVideoAction.php

namespace App\Controller\Media;
use Doctrine\DBAL\Connection;
use App\Entity\Video;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Banner;
use App\Entity\BannerVerification;
use App\Repository\BannerVerificationRepository;

#[AsController]
final class CreateVideoAction extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine, private BannerVerificationRepository $BannerVerificationRepository) {
       
    }
    public function __invoke(Request $request)
    {
        $uploadedFile = $request->files->get('file');

        // $BannerVideo = $request->get('BannerVerification');

        // $BannerVerification = $this->BannerVerificationRepository->findById($BannerVideo);

        // dd($BannerVerification);
        
        // if (!$BannerVideo) {
        //     throw new BadRequestHttpException('"Banner Verification" is required');
        // }

        // if (!$BannerVerification) {
        //     throw new BadRequestHttpException('"Banner Verification" is not found');
        // }

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $video = new Video();
        $video->file = $uploadedFile;    
        return $video;
    }
}
