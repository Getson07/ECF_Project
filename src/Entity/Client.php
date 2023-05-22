<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{

    #[ORM\Column]
    private ?int $guests = null;

    #[ORM\Column]
    private array $allergies = [];

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: ReservedTable::class)]
    private Collection $reservedTables;

    public function __construct(User $user=null)
    {
        parent::__construct($user);
        $this->reservedTables = new ArrayCollection();
    }

    public function getGuests(User $user=null): ?int
    {
        parent::__construct($user);
        return $this->guests;
    }

    public function setGuests(int $guests): self
    {
        $this->guests = $guests;

        return $this;
    }

    public function getAllergies(): array
    {
        return $this->allergies;
    }

    public function setAllergies(array $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }

    /**
     * @return Collection<int, ReservedTable>
     */
    public function getReservedTables(): Collection
    {
        return $this->reservedTables;
    }

    public function addReservedTable(ReservedTable $reservedTable): self
    {
        if (!$this->reservedTables->contains($reservedTable)) {
            $this->reservedTables->add($reservedTable);
            $reservedTable->setClient($this);
        }

        return $this;
    }

    public function removeReservedTable(ReservedTable $reservedTable): self
    {
        if ($this->reservedTables->removeElement($reservedTable)) {
            // set the owning side to null (unless already changed)
            if ($reservedTable->getClient() === $this) {
                $reservedTable->setClient(null);
            }
        }

        return $this;
    }
}
