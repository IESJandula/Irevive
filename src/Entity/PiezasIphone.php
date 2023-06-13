<?php

namespace App\Entity;

use App\Repository\PiezasIphoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PiezasIphoneRepository::class)]
class PiezasIphone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pieza = null;

    #[ORM\Column]
    private ?int $precio = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne(inversedBy: 'piezasIphones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ModelosIphone $modelo_id = null;

    #[ORM\ManyToMany(targetEntity: Reparaciones::class, mappedBy: 'pieza_id')]
    private Collection $reparaciones;

    public function __construct()
    {
        $this->reparaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPieza(): ?string
    {
        return $this->pieza;
    }

    public function setPieza(string $pieza): self
    {
        $this->pieza = $pieza;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getModeloId(): ?ModelosIphone
    {
        return $this->modelo_id;
    }

    public function setModeloId(?ModelosIphone $modelo_id): self
    {
        $this->modelo_id = $modelo_id;

        return $this;
    }

    /**
     * @return Collection<int, Reparaciones>
     */
    public function getReparaciones(): Collection
    {
        return $this->reparaciones;
    }

    public function addReparacione(Reparaciones $reparacione): self
    {
        if (!$this->reparaciones->contains($reparacione)) {
            $this->reparaciones->add($reparacione);
            $reparacione->addPiezaId($this);
        }

        return $this;
    }

    public function removeReparacione(Reparaciones $reparacione): self
    {
        if ($this->reparaciones->removeElement($reparacione)) {
            $reparacione->removePiezaId($this);
        }

        return $this;
    }
}
