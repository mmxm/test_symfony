<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends EntityRepository
{

	public function getAdvertWithCategories(array $categoryNames)
	{
		$qb = $this
			->createQueryBuilder('a')
			->join('a.categories', 'cat')
			->addSelect('cat') ;
		$qb->where($qb->expr()->in('cat.name', $categoryNames));
		return $qb
			->getQuery()
			->getResult()
	  ;
	}
	public function getAdverts($page, $nbPerPage)
	{
	$query = $this->createQueryBuilder('a')
	  // Jointure sur l'attribut image
	  ->leftJoin('a.image', 'i')
	  ->addSelect('i')
	  // Jointure sur l'attribut categories
	  ->leftJoin('a.categories', 'c')
	  ->addSelect('c')
	  ->orderBy('a.date', 'DESC')
	  ->getQuery()
	;

	$query
      // On définit l'annonce à partir de laquelle commencer la liste
      ->setFirstResult(($page-1) * $nbPerPage)
      // Ainsi que le nombre d'annonce à afficher sur une page
      ->setMaxResults($nbPerPage)
    ;
	
    return new Paginator($query, true);
	}

}