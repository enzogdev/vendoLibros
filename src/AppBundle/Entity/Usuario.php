<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_2265B05D92FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_2265B05DA0D96FBF", columns={"email_canonical"}), @ORM\UniqueConstraint(name="UNIQ_2265B05DC05FB297", columns={"confirmation_token"})})
 * @ORM\Entity
 */
class Usuario extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=45, nullable=true)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=45, nullable=true)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=45, nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=45, nullable=true)
     */
    private $imagen;

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
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * @param string $localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @param string $cp
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    /**
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param string $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

}

