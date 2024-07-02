import axios from "axios";

export class EnregistrementFinalise {
    auteur: string
    comementaire: string
    enregistrement: Object
}

export class EnregistrementFinaliseService {
    private endpoint = "/api/bilans";

    public async getEnregistrementFinalises(bilan: string): Promise<EnregistrementFinalise[]> {
        const bilans = await axios.get(`${this.endpoint}/${bilan}/enregistrements`);
        return Promise.resolve(bilans.data);
    }

    public async createEnregistrementFinalise(bilan: string, enregistrement: EnregistrementFinalise): Promise<EnregistrementFinalise> {
        const enregistrementFinalise = await axios.post(`${this.endpoint}/${bilan}/enregistrements`, enregistrement);
        return Promise.resolve(enregistrementFinalise.data);
    }

}
