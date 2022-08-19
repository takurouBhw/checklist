import React from "react";
import { BrowserRouter, Switch, Route, Link , useLocation} from "react-router-dom";
import CompanyPage from "./pages/company";
import LoginPage from "./pages/login";
import CategoryPage from "./pages/category";
import CheklistWorkPage from "./pages/checklist_work";

export default function App() {
    return (
        <BrowserRouter>
            <div>
                <header className="global-head">
                    <nav>
                        <ul>
                            <li>
                                <Link to="/company">会社</Link>
                            </li>
                            <li>
                                <Link to="/login">ログイン</Link>
                            </li>
                            <li>
                                <Link to="/category">カテゴリ</Link>
                            </li>
                            <li>
                                <Link to="/checklist_work">チェックリスト</Link>
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
                    <Route path="/company">
                        <CompanyPage />
                    </Route>
                    <Route path="/checklist_work">
                        <CheklistWorkPage />
                    </Route>
                </Switch>
            </div>
        </BrowserRouter>
    );
}
