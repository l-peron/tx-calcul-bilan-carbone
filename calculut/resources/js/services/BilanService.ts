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

    public async getBilan(id): Promise<Bilan[]> {
        const bilan = await axios.get(this.endpoint + '/' + id)
        return Promise.resolve(bilan.data)
    }

    public async updateBilan(id, titre, enregistrement): Promise<boolean> {
        const isUpdated = await axios.put(this.endpoint + '/' + id, {
            intitule: titre,
            enregistrement
        })
        return Promise.resolve(true)
    }
}
