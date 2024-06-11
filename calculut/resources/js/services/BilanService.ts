import axios from "axios";

class CreateBilanDTO {
    intitule: string;
    debut: Date;
    fin: Date;
}

export class Bilan {
    intitule: string
    type: BilanType
    auteur: string
    asso: string
    pole_asso: string
    enregistrement: Object
    formulaires: Object[]
}

enum BilanType {
    EVENT= 'event'
}



export class BilanService {
    private endpoint = "/api/bilans";

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

    public async updateBilan(id: string, updateBilanDTO: CreateBilanDTO, enregistrement: Object): Promise<boolean> {
        await axios.put(this.endpoint + '/' + id, {
            intitule: updateBilanDTO.intitule,
            debut: updateBilanDTO.debut,
            fin: updateBilanDTO.fin,
            enregistrement
        })
        return Promise.resolve(true)
    }

    public async createBilan(createBilanDTO: CreateBilanDTO, asso: string): Promise<Bilan> {
        const bilan = await axios.post(this.endpoint, {
            intitule: createBilanDTO.intitule,
            debut: createBilanDTO.debut,
            fin: createBilanDTO.fin,
            asso,
            type: 'event'
        });
        return Promise.resolve(bilan.data);
    }

    public async deleteBilan(id: string): Promise<void> {
        await axios.delete(this.endpoint + '/' + id);
        return Promise.resolve();
    }

    public async duplicateBilan(id: string): Promise<void> {
        await axios.post(`${this.endpoint}/${id}/duplicate`)
        return Promise.resolve();
    }
}
