<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaterialHasCategoria
 *
 * @ORM\Table(name="material_has_categoria", indexes={@ORM\Index(name="fk_apuntes_has_categoria_apuntes1", columns={"material_id"}), @ORM\Index(name="fk_apuntes_has_categoria_categoria1", columns={"categoria_id"})})
 * @ORM\Entity
 */
class MaterialHasCategoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Material
     *
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     * })
     */
    private $material;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param \Material $material
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * @return \Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param \Categoria $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }


}

