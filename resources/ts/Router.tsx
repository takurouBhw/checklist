import React from "react";
import { BrowserRouter, Switch, Route, Link } from "react-router-dom";
import axios from "axios";
import CompanyPage from "./pages/company";
import LoginPage from "./pages/login";
import CategoryPage from "./pages/category";
import CheklistWorkPage from "./pages/checklist_work";
import { useLogout, useUser } from "./queries/AuthQuery";
import { useAuth } from "./hooks/AuthContext";

export default function Router() {
    const logout = useLogout();
    const { isAuth, setIsAuth } = useAuth();

    const navigation = () => (
        <header className="global-head">
            <nav>
                <ul>
                    <li>
                        <Link to="/category">カテゴリ</Link>
                    </li>
                    <li>
                        <Link to="/company">会社</Link>
                    </li>
                    <li>
                        <Link to="/checklist_work">チェックリスト</Link>
                    </li>
                    <li onClick={() => logout.mutate()}>
                        <span>ログアウト</span>
                    </li>
                </ul>
            </nav>
        </header>
    );
    const loginNavigation = () => (
        <header className="global-head">
            <nav>
                <ul>
                    <li>
                        <Link to="/login">ログイン</Link>
                    </li>
                </ul>
            </nav>
        </header>
    );

    return (
        <BrowserRouter>
            <>
                {isAuth ? navigation : loginNavigation}
                {/* A <Switch> looks through its children <Route>s and
              renders the first one that matches the current URL. */}
                <Switch>
                    <Route path="/login">
                        <LoginPage />
                    </Route>
                    <Route path="/category">
                        <CategoryPage />
                    </Route>
                    <Route path="/company">
                        <CompanyPage />
                    </Route>
                    <Route path="/checklist_work">
                        <CheklistWorkPage />
                    </Route>
                </Switch>
            </>
        </BrowserRouter>
    );
}
