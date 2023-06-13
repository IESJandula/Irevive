<?php

namespace App\Entity;

use App\Repository\ReparacionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReparacionesRepository::class)]
class Reparaciones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'reparaciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario_id = null;

    #[ORM\ManyToMany(targetEntity: PiezasIphone::class, inversedBy: 'reparaciones')]
    private Collection $pieza_id;

    public function __construct()
    {
        $this->pieza_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuarioId(): ?Usuario
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(?Usuario $usuario_id): self
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    /**
     * @return Collection<int, PiezasIphone>
     */
    public function getPiezaId(): Collection
    {
        return $this->pieza_id;
    }

    public function addPiezaId(PiezasIphone $piezaId): self
    {
        if (!$this->pieza_id->contains($piezaId)) {
            $this->pieza_id->add($piezaId);
        }

        return $this;
    }

    public function removePiezaId(PiezasIphone $piezaId): self
    {
        $this->pieza_id->removeElement($piezaId);

        return $this;
    }
}
