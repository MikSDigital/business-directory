<?php

namespace AppBundle\Api;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait BaseApiTrait
{
    /**
     * Shortcut to return the request service.
     *
     * @return Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    /**
     * Shortcut to return a configuration parameter.
     *
     * @return mixed
     */
    protected function getParameter($name)
    {
        if (!$this->container->hasParameter($name)) {
            throw new \LogicException('Parameter not exist');
        }
        return $this->container->getParameter($name);
    }

    /**
     * Returns a NotFoundHttpException.
     *
     * This will result in a 404 response code. Usage example:
     *
     *     throw $this->createNotFoundException('Page not found!');
     *
     * @param string     $message  A message
     * @param \Exception $previous The previous exception
     *
     * @return NotFoundHttpException
     */
    protected function createNotFoundException($message = 'Not Found', \Exception $previous = null)
    {
        return new NotFoundHttpException($message, $previous);
    }
}
