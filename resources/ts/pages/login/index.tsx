import React, { useState } from "react";
import axios from "axios";
import { useLogin } from "../../queries/AuthQuery";

const LoginPage: React.FC = () => {
    const login = useLogin();
    const [email, setEmail] = useState<string>("test@test.com");
    const [password, setPassword] = useState<string>("123456789");

    const handleLogin = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        login.mutate({ email, password });
    };

    return (
        <>
            <div className="login-page">
                <div className="login-panel">
                    <form onSubmit={handleLogin}>
                        <div className="input-group">
                            <label>メールアドレス</label>
                            <input
                                type="email"
                                className="input"
                                value={email}
                                onChange={(e) => {
                                    setEmail(e.target.value);
                                }}
                            />
                        </div>
                        <div className="input-group">
                            <label>パスワード</label>
                            <input
                                type="password"
                                className="input"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                        </div>
                        <button type="submit" className="btn">
                            ログイン
                        </button>
                    </form>
                </div>
                <div className="links">
                    <a href="#">ヘルプ</a>
                </div>
            </div>
        </>
    );
};

export default LoginPage;
