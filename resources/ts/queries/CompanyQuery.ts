import { useQuery, useMutation, useQueryClient } from "react-query";
import * as api from "../api/CompanyAPI";

const useCompany = () => {
    return useQuery("companies", api.getCompanies);
};

const useUpdateCompany = () => {
    const queryClient = useQueryClient();

    return useMutation(api.updateCompany, {
        onSuccess: () => {
            queryClient.invalidateQueries("companies");
        },
    });
};

export { useCompany, useUpdateCompany };
