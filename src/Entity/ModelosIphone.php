<?php

namespace App\Entity;

use App\Repository\ModelosIphoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelosIphoneRepository::class)]
class ModelosIphone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $modelo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_lanzamiento = null;

    #[ORM\OneToMany(mappedBy: 'modelo_id', targetEntity: PiezasIphone::class)]
    private Collection $piezasIphones;

    public function __construct()
    {
        $this->piezasIphones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getFechaLanzamiento(): ?\DateTimeInterface
    {
        return $this->fecha_lanzamiento;
    }

    public function setFechaLanzamiento(\DateTimeInterface $fecha_lanzamiento): self
    {
        $this->fecha_lanzamiento = $fecha_lanzamiento;

        return $this;
    }

    /**pp
     * @return Collection<int, PiezasIphone>
     */
    public function getPiezasIphones(): Collection
    {
        return $this->piezasIphones;
    }

    public function addPiezasIphone(PiezasIphone $piezasIphone): self
    {
        if (!$this->piezasIphones->contains($piezasIphone)) {
            $this->piezasIphones->add($piezasIphone);
            $piezasIphone->setModeloId($this);
        }

        return $this;
    }

    public function removePiezasIphone(PiezasIphone $piezasIphone): self
    {
        if ($this->piezasIphones->removeElement($piezasIphone)) {
            // set the owning side to null (unless already changed)
            if ($piezasIphone->getModeloId() === $this) {
                $piezasIphone->setModeloId(null);
            }
        }

        return $this;
    }
}
