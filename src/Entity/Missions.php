<?php

namespace App\Entity;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\String\UnicodeString;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MissionsRepository::class)]
/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @UniqueEntity("title")
 * @UniqueEntity("code_name")
 */
class Missions
{
    const TYPE =[
        0 => 'Surveillance',
        1 => 'Assassinat',
        2 => 'Infiltration'
    ];

    const SPEC =[
        0 => 'Discretion',
        1 => 'Assassin',
        2 => 'Reperage'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le nom du bien doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du bien ne peux pas être plus grand que {{ limit }} caractères"
     * )
     */
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = 'A faire';

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $speciality = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(length: 255)]
    private ?string $code_name = null;

    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: Target::class, orphanRemoval: true, cascade:["persist"])]
    private Collection $targets;

    #[ORM\OneToMany(mappedBy: 'missions', targetEntity: Qg::class, cascade:["persist"])]
    private Collection $qg;

    #[ORM\OneToMany(mappedBy: 'missions', targetEntity: Contact::class, cascade:["persist"])]
    private Collection $contact;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @Vich\UploadableField(mapping="missions_image", fileNameProperty="image")
     * @Assert\Image(
     *     mimeTypes="image/jpeg",
     *     mimeTypesMessage = "Merci d'ajouter une image JPEG"
     * )
     * @Assert\File(
     *     maxSize = "1024k",
     * )
     * @var File
     */
    private $imageFile;

    #[ORM\Column(nullable: true, type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $updatedAt = null;

    public function __construct()
    {
        $this->start_date = new DateTimeImmutable();
        $this->end_date = new DateTimeImmutable();
        $this->targets = new ArrayCollection();
        $this->qg = new ArrayCollection();
        $this->contact = new ArrayCollection();
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image instanceof UploadedFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getExcerpt (int $value): ?string
    {
        if ($this->description === null){
            return null;
        }

        return (new UnicodeString($this->description))->truncate($value);
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }

    public function setSpeciality(string $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getCodeName(): ?string
    {
        return $this->code_name;
    }

    public function setCodeName(string $code_name): self
    {
        $this->code_name = $code_name;

        return $this;
    }

    /**
     * @return Collection<int, Target>
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets[] = $target;
            $target->setMission($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getMission() === $this) {
                $target->setMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Qg>
     */
    public function getQg(): Collection
    {
        return $this->qg;
    }

    public function addQg(Qg $qg): self
    {
        if (!$this->qg->contains($qg)) {
            $this->qg[] = $qg;
            $qg->setMissions($this);
        }

        return $this;
    }

    public function removeQg(Qg $qg): self
    {
        if ($this->qg->removeElement($qg)) {
            // set the owning side to null (unless already changed)
            if ($qg->getMissions() === $this) {
                $qg->setMissions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
            $contact->setMissions($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getMissions() === $this) {
                $contact->setMissions(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
