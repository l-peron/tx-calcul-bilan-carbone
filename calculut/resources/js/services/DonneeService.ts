import axios from "axios";

export class Donnee {
    id: string
    intitule: string
    description: string
    valeur: string
    unite: string
    metrique: Metrique
}

enum Metrique {
    CO2= "CO2"
}

export class DonneeService {
    private endpoint = "/api/donnees";

    constructor() {}

    public async getDonnees(): Promise<Donnee[]> {
        const donnees = await axios.get(this.endpoint);
        return Promise.resolve(donnees.data);
    }

    public async createDonnee(donnee: Donnee): Promise<Donnee> {
        const created_donnee = await axios.post(this.endpoint, donnee);
        return Promise.resolve(created_donnee.data);
    }

    public async updateDonnee(donnee: Donnee): Promise<boolean> {
        const is_updated = await axios.put(`${this.endpoint}/${donnee.id}`, donnee);
        return Promise.resolve(is_updated.data);
    }

    public async deleteDonnee(donnee: Donnee): Promise<void> {
        await axios.delete(`${this.endpoint}/${donnee.id}`);
        return Promise.resolve();
    }
}
