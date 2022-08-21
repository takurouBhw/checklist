import { useQuery, useMutation } from "react-query";
import { toast } from "react-toastify";
import { AxiosError } from "axios";
import * as api from "../api/AuthAPI";
import { useAuth } from "../hooks/AuthContext";
import { useCookies } from "react-cookie";

const useUser = () => {
    return useQuery("users", api.getUser);
};

const useLogin = () => {
    const { setIsAuth } = useAuth();
    const [cookies, setCookie, removeCookie] = useCookies(['user_id', 'user_name']);

    return useMutation(api.login, {
        onSuccess: (user) => {
            if (user) {
                setIsAuth(true);
                // cookieを保存
                setCookie('user_id', user.user_id);
                setCookie('user_name', user.name);
                console.log(user);
            }
        },
        onError: () => {
            toast.error("ログインに失敗しました。");
        },
    });
};

const useLogout = () => {
    const { setIsAuth } = useAuth();
    const [cookies, setCookie, removeCookie] = useCookies(['user_id', 'user_name']);

    return useMutation(api.logout, {
        onSuccess: (user) => {
            if (user) {
                // falseにするとナビゲーションがログイン画面に設定される
                setIsAuth(false);
                // cookieを削除
                removeCookie('user_id');
                removeCookie('user_name');
            }
            console.log(user);
        },
        onError: () => {
            toast.error("ログアウトに失敗しました。");
        },
    });
};

export { useUser, useLogin, useLogout };
