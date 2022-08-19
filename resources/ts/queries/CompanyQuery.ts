import { useQuery, useMutation, useQueryClient } from "react-query";
import { toast } from "react-toastify";
import { AxiosError } from "axios";
import * as api from "../api/CompanyAPI";

const useCompany = () => {
    return useQuery("companies", api.getCompanies);
};

const useUpdateCompanyDone = () => {
    const queryClient = useQueryClient();

    return useMutation(api.updateCompanyDone, {
        onSuccess: () => {
            queryClient.invalidateQueries("companies");
        },
        onError: () => {
            toast.error("更新に失敗しました。");
        },
    });
};

const useCreateCompany = () => {
    const queryClient = useQueryClient();

    return useMutation(api.createCompany, {
        onSuccess: () => {
            queryClient.invalidateQueries("companies");
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

const useDeleteCompany = () => {
    const queryClient = useQueryClient();

    return useMutation(api.deleteCompany, {
        onSuccess: () => {
            queryClient.invalidateQueries("companies");
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

const useUpdateCompany = () => {
    const queryClient = useQueryClient();

    return useMutation(api.updateCompany, {
        onSuccess: () => {
            queryClient.invalidateQueries("companies");
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

export { useCompany, useUpdateCompanyDone, useCreateCompany, useDeleteCompany, useUpdateCompany };
