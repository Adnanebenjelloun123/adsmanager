<?php

namespace App\Repository;

use App\Entity\BannerVerificationImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BannerVerificationImage>
 *
 * @method BannerVerificationImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BannerVerificationImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BannerVerificationImage[]    findAll()
 * @method BannerVerificationImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerVerificationImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BannerVerificationImage::class);
    }

    public function add(BannerVerificationImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BannerVerificationImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BannerVerificationImage[] Returns an array of BannerVerificationImage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BannerVerificationImage
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
