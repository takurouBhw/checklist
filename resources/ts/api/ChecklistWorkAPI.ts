import axios from "axios";
import ChecklistWork from "../types/ChecklistWork";

const getChecklistWorks = async () => {
    const { data } = await axios.get<ChecklistWork[]>(
        "api/get_checklist_works"
    );
    console.log(data);
    return data;
};

export { getChecklistWorks };
