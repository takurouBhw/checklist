import React, { useEffect } from "react";
import {
    BrowserRouter,
    Switch,
    Route,
    Link,
    RouteProps,
    Redirect,
} from "react-router-dom";
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
    const { isLoading, data: authUser } = useUser();
    useEffect(() => {
        if (authUser) {
            setIsAuth(true);
        }
    }, [authUser]);

    const GuardRoute = (props: RouteProps) => {
        if (!isAuth) return <Redirect to="/login" />;
        return <Route {...props} />;
    };

    const LoginRoute = (props: RouteProps) => {
        if (isAuth) return <Redirect to="/" />;
        return <Route {...props} />;
    };

    const Navigation: React.FC = () => (
        <header className="global-head">
            <nav>
                <ul>
                    <li>
                        <Link to="/">トップ</Link>
                    </li>
                    <li>
                        <Link to="/company">会社</Link>
                    </li>
                    <li onClick={() => logout.mutate()}>
                        <span>ログアウト</span>
                    </li>
                </ul>
            </nav>
            <p>{}</p>
        </header>
    );
    const LoginNavigation: React.FC = () => (
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
                {
                    isAuth ? <Navigation /> : <LoginNavigation />
                    /* A <Switch> looks through its children <Route>s and
              renders the first one that matches the current URL. */
                }
                <Switch>
                    <GuardRoute
                        path="/"
                        exact
                    ><h1>ヘロー</h1></GuardRoute>
                    <LoginRoute path="/login">
                        <LoginPage />
                    </LoginRoute>
                    <GuardRoute
                        path="/company"
                        exact
                        component={CompanyPage}
                    />
                </Switch>
            </>
        </BrowserRouter>
    );
}
