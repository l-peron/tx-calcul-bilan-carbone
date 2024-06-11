import axios from "axios";
import {Donnee} from "./DonneeService";
export class Formulaire {
    id: string
    updated_at: string
    intitule: string
    description: string
    secteur: TypeFormulaire
    formule: Object
    publie: boolean
    questions: Question[]
}

export class Question {
    id: string
    intitule: string
    description: string
    variable: string
    type: "unique" | "saisie"
    donnees: Donnee
    reponse?: number
}

export enum TypeFormulaire {
    energie = 'Énergie',
    transport = 'Transport',
    fourniture_logistique = 'Achats et Logistique',
    dechet = 'Déchets',
    alimentation = 'Alimentation',
    logement = 'Logement',
    amenagement = 'Aménagement',
    communication = 'Communication'
}

export class FormulaireService {
    private endpoint = "/api/formulaires";

    public async getFormulaires(): Promise<Formulaire[]> {
        const formulaires = await axios.get(this.endpoint);
        return Promise.resolve(formulaires.data);
    }

    public async getFormulaire(id): Promise<Formulaire> {
        const formulaire = await axios.get(this.endpoint + '/' + id);
        return Promise.resolve(formulaire.data);
    }
}
