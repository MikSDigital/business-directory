<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Exclude;

/**
 * Building
 *
 * @ORM\Table(name="buildings")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BuildingRepository")
 */
class Building
{
    /**
     * @var integer
     *
     * @Groups({"list", "info"})
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Groups({"list", "info"})
     *
     * @ORM\Column(name="address", type="string", length=200, nullable=false)
     */
    private $address;

    /**
     * @var float
     *
     * @Exclude
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=8, nullable=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @Exclude
     *
     * @ORM\Column(name="longitude", type="decimal", precision=11, scale=8, nullable=false)
     */
    private $longitude;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Building
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Building
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Building
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
