<?php

namespace App\DTOs;

class FormulaireJSON
{
    public string $id;
    public string $intitule;
    public string $description;
    public bool $publie;
    public FormuleJSON $formule;
    public ?float $evaluation;
    public string $secteur;

    /* @var QuestionJSON[] */
    public array $questions;

    public function __construct(array $formulaire)
    {
        $this->id = $formulaire["id"];
        $this->intitule =  $formulaire["intitule"];
        $this->description = $formulaire["description"];
        $this->publie = $formulaire["publie"];
        $this->evaluation = $formulaire["evaluation"] ?? null;
        $this->secteur = $formulaire["secteur"];

        $this->formule = new FormuleJSON($formulaire["formule"]);

        foreach($formulaire["questions"] as $question) {
            $this->questions[] = new QuestionJSON($question);
        }
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function isPublie(): bool
    {
        return $this->publie;
    }

    public function setPublie(bool $publie): void
    {
        $this->publie = $publie;
    }

    public function getFormule(): FormuleJSON
    {
        return $this->formule;
    }

    public function setFormule(FormuleJSON $formule): void
    {
        $this->formule = $formule;
    }

    public function getEvaluation(): float
    {
        return $this->evaluation;
    }

    public function setEvaluation(float $evaluation): void
    {
        $this->evaluation = $evaluation;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): void
    {
        $this->questions = $questions;
    }

}
