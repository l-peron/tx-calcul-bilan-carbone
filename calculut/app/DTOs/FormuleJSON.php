<?php

namespace App\DTOs;

class FormuleJSON
{
    public string $type;

    public ?string $name;

    public ?FormuleJSON $a;
    public ?FormuleJSON $b;
    public ?FormuleJSON $child;

    /**
     * @param string $type
     * @param string $name
     * @param FormuleJSON $a
     * @param FormuleJSON $b
     */
    public function __construct(array $formule)
    {
        $this->type = $formule['type'];

        if($this->type == 'variable') {
            $this->name = $formule['name'];
        } else if($this->type == 'block') {
            $this->child = new self($formule['child']);
        } else {
            $this->a = new self($formule['a']);
            $this->b = new self($formule['b']);
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getA(): FormuleJSON
    {
        return $this->a;
    }

    public function setA(FormuleJSON $a): void
    {
        $this->a = $a;
    }

    public function getB(): FormuleJSON
    {
        return $this->b;
    }

    public function setB(FormuleJSON $b): void
    {
        $this->b = $b;
    }

    public function getChild(): ?FormuleJSON
    {
        return $this->child;
    }

    public function setChild(?FormuleJSON $child): void
    {
        $this->child = $child;
    }




}
