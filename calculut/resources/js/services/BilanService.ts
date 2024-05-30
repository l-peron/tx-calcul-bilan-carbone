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
}
