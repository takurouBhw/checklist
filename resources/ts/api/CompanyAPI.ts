import axios from "axios";
import Company from "../types/Company";

const getCompanies = async () => {
    const { data } = await axios.get<Company[]>("api/comapnies");
    console.log(data);
    return data;
};

const updateCompany = async ({ id, is_done }: Company) => {
    const { data } = await axios.patch<Company[]>(
        `api/comapnies/${id}`,
        {
            is_done: !is_done,
        }
        // {
        //     headers: {
        //         // "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')"
        //         "content-type": "multipart/form-data",
        //         "X-HTTP-Method-Override": "PUT",
        //     },
        // }
    );
    // console.log(data);
    return data;
};

export { getCompanies, updateCompany };
