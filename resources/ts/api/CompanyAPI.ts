import axios from "axios";
import Company from "../types/Company";

const getCompanies = async () => {
    const { data } = await axios.get<Company[]>("api/comapnies");
    console.log(data);
    return data;
};

const updateCompanyDone = async ({id, is_done }: Company) => {
    const { data } = await axios.patch<Company>(`api/comapnies/${id}`, {
        is_done: !is_done,
    });
    // console.log(data);
    return data;
};

const createCompany = async (name: string) => {
    const { data } = await axios.post<Company>(`api/comapnies`, {
        name: name,
        // is_done: !is_done,
    });
    // console.log(data);
    return data;
};

const updateCompany = async ({id, company}: {id: number, company: Company}) => {
    const { data } = await axios.put<Company>(`api/comapnies/${id}`, company);
    // console.log(data);
    return data;
};

const deleteCompany = async (id: number) => {
    const { data } = await axios.delete<Company>(`api/comapnies/${id}`);
    // console.log(data);
    return data;
};

export { getCompanies, updateCompanyDone, createCompany, updateCompany, deleteCompany };
