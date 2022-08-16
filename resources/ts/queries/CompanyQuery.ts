import { useQuery } from "react-query";
import * as api from "../api/CompanyAPI";

const useCompany = () => {
    return useQuery("companies", api.getCompanies);
};

export { useCompany };
