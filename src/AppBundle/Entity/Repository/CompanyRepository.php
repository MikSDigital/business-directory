<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CompanyRepository extends EntityRepository
{
    /**
     * @param \AppBundle\Entity\Category $category
     * @param string $orderBy
     * @param int $limit
     * @param int $offset
     */
    public function findByCategory($category, $orderBy = null, $limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('co')
            ->where(':category MEMBER OF co.categories')
            ->setParameters(array('category' => $category))
        ;

        $this->commonParams($qb, $orderBy, $limit, $offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $params
     * @param string $orderBy
     * @param int $limit
     * @param int $offset
     */
    public function findBeside(array $params, $orderBy = null, $limit = null, $offset = null)
    {
        if (empty($params['latitude']) || empty($params['longitude']) || empty($params['distance'])) {
            return [];
        }

        $qb = $this->createQueryBuilder('co');
        $qb->andWhere($qb->expr()->in('co.building', $this->getBuildingIds($params)));

        $this->commonParams($qb, $orderBy, $limit, $offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $orderBy
     * @param int $limit
     * @param int $offset
     */
    protected function commonParams($qb, $orderBy = null, $limit = null, $offset = null)
    {
        if ($orderBy) {
            $qb->orderBy($orderBy);
        }
        if ($limit) {
            $qb->setMaxResults($limit);
        }
        if ($offset) {
            $qb->setFirstResult($offset);
        }
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getBuildingIds($params)
    {
        $result = $this->getEntityManager()->getRepository('AppBundle:Building')
            ->createQueryBuilder('b')
            ->select('b.id')
            ->addSelect(
                '( 3959 * ACOS( COS( RADIANS(' . $params['latitude'] . '))' .
                    '* COS( RADIANS(b.latitude) )' .
                    '* COS( RADIANS(b.longitude)' .
                    '- RADIANS(' . $params['longitude'] . ') )' .
                    '+ SIN( RADIANS(' . $params['latitude'] . ') )' .
                    '* SIN( RADIANS(b.latitude) ) ) ) AS distance'
            )
            ->having('distance < :distance')
            ->setParameter('distance', $params['distance'])
            ->orderBy('distance', 'ASC')
            ->getQuery()
            ->getScalarResult();
        ;
        return $result ? array_column($result, 'id') : [];
    }
}
