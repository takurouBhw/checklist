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
import TaskPage from "./pages/task";
import LoginPage from "./pages/login";
import NotFoundPage from "./pages/error";
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

    // const GuardRoute = (props: RouteProps) => {
    //     if (!isAuth) return <Redirect to="/login" />;
    //     return <Route {...props} />;
    // };

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
                        <Link to="/task">タスク</Link>
                    </li>
                    <li onClick={() => logout.mutate()}>
                        <span>ログアウト</span>
                    </li>
                </ul>
            </nav>
            <p>{ }</p>
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
                <Navigation />
                <Switch>
                    <Route path="/task" exact component={TaskPage} />
                    <Route path="/" ><h1>HOME</h1></Route>
                    {/* <GuardRoute path="/" exact>
                        <h1>Home</h1>
                    </GuardRoute>
                    <LoginRoute path="/login">
                        <LoginPage />
                    </LoginRoute>
                    <GuardRoute path="/task" exact component={TaskPage} /> */}
                    <Route component={NotFoundPage} />
                </Switch>
            </>
        </BrowserRouter>
    );
}
