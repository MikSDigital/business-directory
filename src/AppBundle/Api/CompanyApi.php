<?php

namespace AppBundle\Api;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class CompanyApi implements ContainerAwareInterface
{
    use BaseApiTrait;
    use ContainerAwareTrait;

    /**
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return \Doctrine\Common\Collections\Collection
     */
    public function listAction($filters = [], $limit = null, $offset = null)
    {
        $condition  = [];
        $repository = $this->getDoctrine()->getRepository('AppBundle:Company');
        $limits     = $this->getParameter('api_limit');
        $limit      = empty($limit) || $limit > $limits['max']
            ? $limits['default'] : $limit;

        if (!empty($filters['category_id'])) {
            return $repository->findByCategory(
                $this->getCategory($filters['category_id']),
                null,
                $limit,
                $offset
            );
        }
        if (!empty($filters['beside']) && is_array($filters['beside'])) {
            return $repository->findBeside($filters['beside'], null, $limit, $offset);
        }
        if (!empty($filters['building_id'])) {
            $condition['building'] = $this->getBuilding($filters['building_id']);
        }

        return $repository->findBy($condition, null, $limit, $offset);
    }

    /**
     * @param int $id
     * @return \AppBundle\Entity\Company
     */
    public function infoAction($id)
    {
        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($id);
        if (!$company) {
            $this->createNotFoundException('Company not found');
        }
        return $company;
    }

    /**
     * @param int $id
     * @return \AppBundle\Entity\Building
     */
    protected function getBuilding($id)
    {
        $building = $this->getDoctrine()->getRepository('AppBundle:Building')->find($id);
        if (!$building) {
            $this->createNotFoundException('Building not found');
        }
        return $building;
    }

    /**
     * @param int $id
     * @return \AppBundle\Entity\Category
     */
    protected function getCategory($id)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if (!$category) {
            $this->createNotFoundException('Category not found');
        }
        return $category;
    }
}
