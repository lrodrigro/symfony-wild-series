<?php

namespace App\Entity;

use App\Entity\Program;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Ne me laisse pas tout vide")
     * @Assert\Length(max="255", maxMessage="La catégorie saisie {{ value }} est trop longue, elle ne devrait pas dépasser {{ limit }} caractères")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Program::class, mappedBy="category", orphanRemoval=true)
     */
    private $program;

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    /**
     * param Program $programs
     * @return Category
     */
    public function addProgram(?Program $program): self
    {
        if (!$this->programs->contains($program)){
            $this->programs[] = $program;
            $program->setCategory($this);
        }
        return $this;
    }

    /**
     * @param Program $program
     * @return Category
     */
    public function removeProgram(?Program $program): self
    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
            if ($program-getCategory() === $this) {
                $program->setCategory(null);
            }
        }
        return $this;
    }
}
