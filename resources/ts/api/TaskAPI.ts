import axios from "axios";
import Task from "../types/Task";

const getTasks = async () => {
    const { data } = await axios.get<Task[]>("api/task");
    console.log(data);
    return data;
};

const updateTaskDone = async ({ id, is_done }: Task) => {
    const { data } = await axios.patch<Task>(`api/task/${id}`, {
        id,
        is_done: !is_done,
    });
    // console.log(data);
    return data;
};

const createTask = async (title: string) => {
    const { data } = await axios.post<Task>(`api/task`, {
        title,
    });
    // console.log(data);
    return data;
};

const updateTask = async ({ id, task }: { id: number, task: Task }) => {
    const { data } = await axios.put<Task>(`api/task/${id}`, task);
    // console.log(data);
    return data;
};

const deleteTask = async (id: number) => {
    const { data } = await axios.delete<Task>(`api/task/${id}`);
    // console.log(data);
    return data;
};

export { getTasks, updateTaskDone, createTask, updateTask, deleteTask };
