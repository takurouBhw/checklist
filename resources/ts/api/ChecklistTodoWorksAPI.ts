import axios from "axios";
import CheklistTodoWorks, { HEADING_FLAG } from "../types/ChecklistTodoWork";

const getCompanies = async () => {
    const { data } = await axios.get<CheklistTodoWorks[]>("api/");
    // console.log(data);
    return data;
};

export { getCompanies };
