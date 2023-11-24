<?php

namespace App\Repository;

use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

/**
 * @extends ServiceEntityRepository<Produits>
 *
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

//    /**
//     * @return Produits[] Returns an array of Produits objects
//     */
public function getAllProductsByIdDesc() {
    $produits = $this->getEntityManager()
    ->createQuery('SELECT p FROM App\Entity\Produits p ORDER BY p.prix DESC')
    ->getResult();
    return $produits;
}
public function getAllProductsByIdAsc() {
    $produits = $this->getEntityManager()
    ->createQuery('SELECT p FROM App\Entity\Produits p ORDER BY p.prix ASC')
    ->getResult();
    return $produits;
}
public function getProductsByPriceScale($min,$max){
    $produits = $this->getEntityManager()
    ->createQuery("
    SELECT p FROM App\Entity\Produits p
    WHERE p.prix >= :min AND p.prix <= :max
    ORDER BY p.prix ASC
    ")
    ->setParameter('min', $min)
    ->setParameter('max', $max)
    ->getResult();

    return $produits;
}
public function getProductByCategory () {
    $produit_cat = $this->getEntityManager()
    //Selectionne le nom produit et l'id de la categ , dans categorie (alias c), join categorie,..."p")
    ->createQuery("SELECT p.name as pname,c.id, c.name as cname FROM APP\Entity\Categories c JOIN c.produits p")
    ->getResult();
    return $produit_cat;
}

public function getLastProduct ($element) {
    $lastProduct = $this->createQueryBuilder('p')
    ->orderBy("p.$element",' DESC')
    ->setMaxResults(1)
    ->getQuery()
    ->getOneOrNullResult();
    return $lastProduct;
}
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

//    public function findOneBySomeField($value): ?Produits
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
