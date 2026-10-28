<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dates de creation et de mise a jour partagees par toutes les entites.
 * L'entite qui utilise ce trait doit porter l'attribut #[ORM\HasLifecycleCallbacks]
 * pour que Doctrine declenche initDate() et majDate() automatiquement.
 */
trait DateTimeTrait
{
    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updateAt = null;

    #[ORM\PrePersist]
    public function initDate(): void
    {
        $this->createAt ??= new \DateTimeImmutable();
        $this->updateAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function majDate(): void
    {
        $this->updateAt = new \DateTime();
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTime $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}