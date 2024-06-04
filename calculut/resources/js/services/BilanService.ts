import axios from "axios";

export class Bilan {
    intitule: string
    type: BilanType
    auteur: string
    asso: string
    pole_asso: string
    enregistrement: Object
}

enum BilanType {
    EVENT= 'event'
}
export class BilanService {
    private endpoint = "/api/bilans";

    constructor() {}

    public async getBilans(): Promise<Bilan[]> {
        const bilans = await axios.get(this.endpoint);
        return Promise.resolve(bilans.data);
    }

    public async getBilansByAsso(asso: string): Promise<Bilan[]> {
        const bilans = await axios.get(`${this.endpoint}?asso=${asso}`)
        return Promise.resolve(bilans.data);
    }

    public async getBilan(id: string): Promise<Bilan[]> {
        const bilan = await axios.get(this.endpoint + '/' + id)
        return Promise.resolve(bilan.data)
    }

    public async updateBilan(id: string, titre: string, enregistrement: Object): Promise<boolean> {
        const isUpdated = await axios.put(this.endpoint + '/' + id, {
            intitule: titre,
            enregistrement
        })
        return Promise.resolve(true)
    }

    public async createBilan(intitule: string, asso: string): Promise<Bilan> {
        const bilan = await axios.post(this.endpoint, {
            intitule,
            asso,
            type: 'event'
        });
        return Promise.resolve(bilan.data);
    }

    public async deleteBilan(id: string): Promise<void> {
        await axios.delete(this.endpoint + '/' + id);
        return Promise.resolve();
    }
}
