<?php

namespace App\Entity;

use App\Entity\Missions;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TargetRepository;
use App\Repository\MissionsRepository;

#[ORM\Entity(repositoryClass: TargetRepository::class)]
class Target
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\Datetime $birth = null;

    #[ORM\Column(length: 255)]
    private ?string $name_code = null;

    #[ORM\Column(length: 255)]
    private ?string $nationality = null;

    #[ORM\ManyToOne(targetEntity: Missions::class, inversedBy: 'targets')]
    #[ORM\JoinColumn(nullable: false)]
    private Missions $mission;

    public function getMission() : Missions
    {
        return $this->mission;
    }

    public function setMission($mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirth(): ?\Datetime
    {
        return $this->birth;
    }

    public function setBirth(\Datetime $birth): self
    {
        $this->birth = $birth;

        return $this;
    }

    public function getNameCode(): ?string
    {
        return $this->name_code;
    }

    public function setNameCode(string $name_code): self
    {
        $this->name_code = $name_code;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }
}
