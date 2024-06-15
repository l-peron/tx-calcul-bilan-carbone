<?php

namespace App\DTOs;

use App\Models\Question;

class QuestionJSON
{
    public string $id;
    public string $intitule;
    public ?string $description;
    public string $variable;
    public string $type;
    public array $donnees;

    public int $reponse;
    public function __construct(array $question)
    {
        $this->id = $question["id"];
        $this->intitule = $question["intitule"];
        $this->description = $question["description"];
        $this->variable = $question["variable"];
        $this->type = $question["type"];
        $this->donnees = $question["donnees"];

        $this->reponse = $question['reponse'];
    }

    public function getReponse(): int
    {
        return $this->reponse;
    }

    public function setReponse(int $reponse): void
    {
        $this->reponse = $reponse;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getIntitule(): string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): void
    {
        $this->intitule = $intitule;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getVariable(): string
    {
        return $this->variable;
    }

    public function setVariable(string $variable): void
    {
        $this->variable = $variable;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getDonnees(): array
    {
        return $this->donnees;
    }

    public function setDonnees(array $donnees): void
    {
        $this->donnees = $donnees;
    }


}
