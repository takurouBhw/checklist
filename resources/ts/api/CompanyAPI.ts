import axios from "axios";
import Company from "../types/Company";

const getCompanies = async () => {
    const { data } = await axios.get<Company[]>("api/comapnies");
    // console.log(data);
    return data;
};

export { getCompanies };
