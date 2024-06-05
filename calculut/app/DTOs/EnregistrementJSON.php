<?php

namespace App\DTOs;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class EnregistrementJSON implements Castable
{

    public ?String $auteur;
    public ?String $date;

    /* @var FormulaireJSON[] */
    public array $formulaires;

    public function __construct(?array $enregistrement)
    {
        $enregistrement = $enregistrement ?? [];

        $this->auteur = $enregistrement["auteur"] ?? null;
        $this->date = $enregistrement["date"] ?? null;
        $this->formulaires = [];

        foreach($enregistrement["formulaires"] ?? [] as $formulaire){
            $this->formulaires[] = new FormulaireJSON($formulaire);
        }
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): void
    {
        $this->auteur = $auteur;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function setDate(Date $date): void
    {
        $this->date = $date;
    }

    public function getFormulaires(): array
    {
        return $this->formulaires;
    }

    public function setFormulaires(array $formulaires): void
    {
        $this->formulaires = $formulaires;
    }

    public static function castUsing(array $arguments): ?CastsAttributes
    {

        return new class implements CastsAttributes
        {
            public function get(Model $model, string $key, mixed $value, array $attributes): ?EnregistrementJSON
            {
                if($value == null ) return null;
                return  new EnregistrementJSON(json_decode($value, true));
            }

            public function set(Model $model, string $key, mixed $value, array $attributes): string
            {
                return json_encode($value);
            }
        };
    }
}
