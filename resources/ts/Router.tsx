import React from "react";
import { BrowserRouter, Switch, Route, Link } from "react-router-dom";
import CompanyPage from "./pages/company";
import LoginPage from "./pages/login";
import CategoryPage from "./pages/category";

export default function App() {
    return (
        <BrowserRouter>
            <div>
                <header className="global-head">
                    <nav>
                        <ul>
                            <li>
                                <Link to="/">会社</Link>
                            </li>
                            <li>
                                <Link to="/login">ログイン</Link>
                            </li>
                            <li>
                                <Link to="/category">カテゴリ</Link>
                            </li>
                        </ul>
                    </nav>
                </header>
                {/* A <Switch> looks through its children <Route>s and
              renders the first one that matches the current URL. */}
                <Switch>
                    <Route path="/login">
                        <LoginPage />
                    </Route>
                    <Route path="/category">
                        <CategoryPage />
                    </Route>
                    <Route path="/">
                        <CompanyPage />
                    </Route>
                </Switch>
            </div>
        </BrowserRouter>
    );
}
