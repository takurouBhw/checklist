import axios from "axios";
import Category from "../types/Category";

const getCategories = async () => {
    const { data } = await axios.get<Category[]>("api/get_category");
    console.log(data);
    return data;
};

export { getCategories };
