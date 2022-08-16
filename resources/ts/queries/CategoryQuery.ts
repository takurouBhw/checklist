import { useQuery } from "react-query";
import * as api from "../api/CategoryAPI";

const useCategory = () => {
    return useQuery("categories", api.getCategories);
};

export { useCategory };
