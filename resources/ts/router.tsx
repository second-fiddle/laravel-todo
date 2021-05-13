import React from "react";
import { BrowserRouter, Switch, Route, Link } from "react-router-dom";
import HelpPage from "./pages/help/index";
import LoginPage from "./pages/login/index";
import TaskPage from "./pages/tasks/index";

const Router = () => {
    return (
        <BrowserRouter>
            <div>
                <header className="global-head">
                    <ul>
                        <li>
                            <Link to="/">Home</Link>
                        </li>
                        <li>
                            <Link to="/help">Help</Link>
                        </li>
                        <li>
                            <Link to="/login">Login</Link>
                        </li>
                        <li>
                            <span>Logout</span>
                        </li>
                    </ul>
                </header>

                {/* A <Switch> looks through its children <Route>s and
            renders the first one that matches the current URL. */}
                <Switch>
                    <Route path="/help">
                        <HelpPage />
                    </Route>
                    <Route path="/login">
                        <LoginPage />
                    </Route>
                    <Route path="/">
                        <TaskPage />
                    </Route>
                </Switch>
            </div>
        </BrowserRouter>
    );
};

export default Router;
