<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensaje
 *
 * @ORM\Table(name="mensaje", indexes={@ORM\Index(name="fk_usuario_has_usuario_usuario1", columns={"usuario_emisor"}), @ORM\Index(name="fk_usuario_has_usuario_usuario2", columns={"usuario_receptor"})})
 * @ORM\Entity
 */
class Mensaje
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", length=11, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=45, nullable=true)
     */
    private $mensaje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="date", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_emisor", referencedColumnName="id")
     * })
     */
    private $usuarioEmisor;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_receptor", referencedColumnName="id")
     * })
     */
    private $usuarioReceptor;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param string $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @param \DateTime $fechaCreacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    /**
     * @return \Usuario
     */
    public function getUsuarioEmisor()
    {
        return $this->usuarioEmisor;
    }

    /**
     * @param \Usuario $usuarioEmisor
     */
    public function setUsuarioEmisor($usuarioEmisor)
    {
        $this->usuarioEmisor = $usuarioEmisor;
    }

    /**
     * @return \Usuario
     */
    public function getUsuarioReceptor()
    {
        return $this->usuarioReceptor;
    }

    /**
     * @param \Usuario $usuarioReceptor
     */
    public function setUsuarioReceptor($usuarioReceptor)
    {
        $this->usuarioReceptor = $usuarioReceptor;
    }


}

