<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'results')]
    #[ORM\JoinColumn(nullable: false)]
    private $questioner;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $answerer;

    #[ORM\Column(type: 'integer')]
    private $result;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestioner(): ?User
    {
        return $this->questioner;
    }

    public function setQuestioner(?User $questioner): self
    {
        $this->questioner = $questioner;

        return $this;
    }

    public function getAnswerer(): ?User
    {
        return $this->answerer;
    }

    public function setAnswerer(?User $answerer): self
    {
        $this->answerer = $answerer;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }
}
