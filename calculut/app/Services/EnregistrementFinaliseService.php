<?php

namespace App\Services;

use App\DTOs\FormulaireJSON;
use App\DTOs\FormuleJSON;
use App\DTOs\QuestionJSON;
use App\Models\Bilan;
use App\Models\EnregistrementFinalise;

class EnregistrementFinaliseService
{
    public function saveEnregistrementFinalise(string $bilanId, EnregistrementFinalise $enregistrementFinalise): EnregistrementFinalise
    {
        $enregistrementJSON = $enregistrementFinalise->enregistrement;

        /* @var FormulaireJSON[] $formulairesAnswered */
        $formulairesAnswered = [];

        foreach($enregistrementJSON->getFormulaires() as $formulaire) {
            if($this->isFormulaireAnswered($formulaire)){
                $questions = $formulaire->getQuestions();
                $result = $this->evaluateFormule($questions, $formulaire->getFormule());
                $formulaire->setEvaluation($result);
                $formulairesAnswered[] = $formulaire;
            }
        }

        $enregistrementJSON->setFormulaires($formulairesAnswered);
        $enregistrementFinalise->enregistrement = $enregistrementJSON;

        Bilan::findOrFail($bilanId)->enregistrementFinalises()->save($enregistrementFinalise);

        return $enregistrementFinalise;
    }

    private function isFormulaireAnswered(FormulaireJSON $formulaire): bool
    {
        return true;
    }

    private function operation(int $a, int $b, string $op): int
    {
        return match ($op) {
            'plus' => $a + $b,
            'multiply-dot' => $a * $b,
            default => 0,
        };
    }

    /* @var QuestionJSON[] $qs */
    private function evaluateFormule(array $qs, FormuleJSON $f): int
    {
        if($f->getType() == "block") {
            return $this->evaluateFormule($qs, $f->getChild());
        }

        if($f->getA()->getType() == "variable" && $f->getB()->getType() == "variable") {
            $q1 = array_filter($qs, function($q) use ($f) { return $q->getVariable() == $f->getA()->getName(); });
            $q2 = array_filter($qs, function($q) use ($f) { return $q->getVariable() == $f->getB()->getName(); });
            return $this->operation(reset($q1)->getReponse(), reset($q2)->getReponse(), $f->getType());
        } elseif($f->getA()->getType() != "variable") {
            $raw = $this->evaluateFormule($qs, $f->getA());
            $q2 = array_filter($qs, function($q) use ($f) { return $q->getVariable() == $f->getB()->getName(); });
            return $this->operation($raw, reset($q2)->getReponse(), $f->getType());
        } else {
            $raw = $this->evaluateFormule($qs, $f->getB());
            $q1 = array_filter($qs, function($q) use ($f) { return $q->getVariable() === $f->getA()->getName(); });
            return $this->operation($raw, reset($q1)->getReponse(), $f->getType());
        }
    }
}
