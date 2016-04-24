<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Company
 *
 * @ORM\Table(name="companies", indexes={@ORM\Index(name="building_id_idx", columns={"building_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CompanyRepository")
 * 
 */
class Company
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
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var Phone
     *
     * @Groups({"info"})
     *
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="company")
     */
    private $phones;

    /**
     * @var Building
     *
     * @Groups({"info"})
     *
     * @ORM\ManyToOne(targetEntity="Building")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     * })
     */
    private $building;

    /**
     * @Groups({"info"})
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="companies")
     * @ORM\JoinTable(name="companies_x_categories")
     */
    private $categories;

    public function __construct()
    {
        $this->phones     = new ArrayCollection;
        $this->categories = new ArrayCollection;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set building
     *
     * @param Building $building
     *
     * @return Company
     */
    public function setBuilding(Building $building = null)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return Building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Add category
     *
     * @param Category $category
     *
     * @return Company
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add phone
     *
     * @param Phone $phone
     *
     * @return Company
     */
    public function addPhone(Phone $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * Remove phone
     *
     * @param Phone $phone
     */
    public function removePhone(Phone $phone)
    {
        $this->phones->removeElement($phone);
    }

    /**
     * Get phones
     *
     * @return Collection
     */
    public function getPhones()
    {
        return $this->phones;
    }
}
