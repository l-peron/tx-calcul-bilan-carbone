<?php

namespace App\Enums;

enum FormulaireSecteur: string
{
    case ENERGIE = 'energie';
    case TRANSPORT = 'transport';
    case FOURNISSEUR_LOGISTIQUE = 'fournisseur_logistique';
    case DECHET = 'dechet';
    case ALIMENTATION = 'alimentation';
    case LOGEMENT = 'logement';
    case AMENAGEMENT = 'amenagement';
    case COMMUNICATION = 'communication';
}
