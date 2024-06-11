import axios from "axios";
export class Identity {
    fullName: string;
    assos: Asso[];
}
export class Asso {
    shortname: string
}
export class HeaderService {
    private endpoint = "/api/assos";

    public async getIdentity(): Promise<Identity> {
        const assos = await axios.get(this.endpoint);
        return Promise.resolve(assos.data);
    }

    public async logoutUser(): Promise<void> {
        await axios.post("/logout");
        return Promise.resolve();
    }

}
