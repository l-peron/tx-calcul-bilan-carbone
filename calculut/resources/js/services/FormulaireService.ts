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
    type: TypeQuestion
    donnees: Donnee[]
    reponse?: number
}

export enum TypeQuestion {
    unique = "Choix unique",
    saisie = "Saisie Utilisateur"
}

export enum TypeFormulaire {
    energie = 'Énergie',
    transport = 'Transport',
    fournisseur_logistique = 'Achats et Logistique',
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

    public async getPublieFormulaires(): Promise<Formulaire[]> {
        const formulaires = await axios.get(`${this.endpoint}?publie=true`);
        return Promise.resolve(formulaires.data);
    }

    public async getFormulaire(id): Promise<Formulaire> {
        const formulaire = await axios.get(this.endpoint + '/' + id);
        return Promise.resolve(formulaire.data);
    }

    public async createFormulaire(formulaire: Formulaire): Promise<Formulaire> {
        const created_formulaire = await axios.post(this.endpoint, formulaire);
        return Promise.resolve(created_formulaire.data);
    }

    public async updateFormulaire(formulaireId, formulaire: Formulaire): Promise<void> {
        await axios.put(`${this.endpoint}/${formulaireId}`, formulaire);
        return Promise.resolve();
    }

    public async deleteFormulaire(formulaireId): Promise<void> {
        await axios.delete(`${this.endpoint}/${formulaireId}`);
        return Promise.resolve();
    }

    public async createFormulaireQuestion(id, question: Question): Promise<Question> {
        const created_question = await axios.post(
            this.endpoint + '/' + id + '/questions', question);
        console.log(created_question.data);
        return Promise.resolve(created_question.data);
    }

    public async updateFormulaireQuestion(formulaireId: string, questionId, question: object) {
        await axios.put(`${this.endpoint}/${formulaireId}/questions/${questionId}`, question);
        return Promise.resolve();
    }

    public async deleteFormulaireQuestion(formulaireId: string, questionId: string): Promise<void> {
        await axios.delete(`${this.endpoint}/${formulaireId}/questions/${questionId}`);
        return Promise.resolve();
    }
}
