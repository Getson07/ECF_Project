<?php

namespace App\Repository;

use App\Entity\CategoryFormula;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryFormula>
 *
 * @method CategoryFormula|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryFormula|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryFormula[]    findAll()
 * @method CategoryFormula[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryFormulaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryFormula::class);
    }

    public function save(CategoryFormula $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryFormula $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function removeAll(array $categoryFormulas, bool $flush = false): void
    {
        foreach($categoryFormulas as $entity)
            $this->remove($entity, $flush);
    }

//    /**
//     * @return CategoryFormula[] Returns an array of CategoryFormula objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategoryFormula
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
