import { useQuery, useMutation, useQueryClient } from "react-query";
import { toast } from "react-toastify";
import { AxiosError } from "axios";
import * as api from "../api/TaskAPI";

const useTask = () => {
    return useQuery("tasks", api.getTasks);
};

const useUpdateTaskDone = () => {
    const queryClient = useQueryClient();

    return useMutation(api.updateTaskDone, {
        onSuccess: () => {
            queryClient.invalidateQueries("tasks");
        },
        onError: () => {
            toast.error("更新に失敗しました。");
        },
    });
};

const useCreateTask = () => {
    const queryClient = useQueryClient();

    return useMutation(api.createTask, {
        onSuccess: () => {
            queryClient.invalidateQueries("tasks");
            toast.success("登録に成功しました。");
        },
        onError: (error: AxiosError) => {
            // エラーメッセージ
            if (error.response?.data.errors) {
                Object.values(error.response.data.errors).map(
                    (messages: any) => {
                        messages.map((messages: string) => {
                            toast.error(messages);
                        });
                    }
                );
            } else {
                toast.error("登録に失敗しました。");
            }
            console.log(`aaa: ${JSON.stringify(error.response?.data)}`);
        },
    });
};

const useDeleteTask = () => {
    const queryClient = useQueryClient();

    return useMutation(api.deleteTask, {
        onSuccess: () => {
            queryClient.invalidateQueries("tasks");
            toast.success("削除に成功しました。");
        },
        onError: (error: AxiosError) => {
            // エラーメッセージ
            if (error.response?.data.errors) {
                Object.values(error.response.data.errors).map(
                    (messages: any) => {
                        messages.map((messages: string) => {
                            toast.error(messages);
                        });
                    }
                );
            } else {
                toast.error("削除に失敗しました。");
            }
        },
    });
};

const useUpdateTask = () => {
    const queryClient = useQueryClient();

    return useMutation(api.updateTask, {
        onSuccess: () => {
            queryClient.invalidateQueries("tasks");
            toast.success("更新に成功しました。");
        },
        onError: (error: AxiosError) => {
            // エラーメッセージ
            if (error.response?.data.errors) {
                Object.values(error.response.data.errors).map(
                    (messages: any) => {
                        messages.map((messages: string) => {
                            toast.error(messages);
                        });
                    }
                );
            } else {
                toast.error("更新に失敗しました。");
            }
            console.log(`aaa: ${JSON.stringify(error.response?.data)}`);
        },
    });
};

export { useTask, useUpdateTaskDone, useCreateTask, useDeleteTask, useUpdateTask };
