<?php

namespace AppBundle\Api;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class BuildingApi implements ContainerAwareInterface
{
    use BaseApiTrait;
    use ContainerAwareTrait;

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function listAction($limit = null, $offset = null)
    {
        $limits = $this->getParameter('api_limit');
        $limit  = empty($limit) || $limit > $limits['max']
            ? $limits['default'] : $limit;

        return $this->getDoctrine()
            ->getRepository('AppBundle:Building')
            ->findBy([], null, $limit, $offset);
    }
}
