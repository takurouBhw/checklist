import { useQuery } from "react-query";
import * as api from "../api/ChecklistWorkAPI";

const useChecklistWork = () => {
    return useQuery("checklist_works", api.getChecklistWorks);
};

export { useChecklistWork };
