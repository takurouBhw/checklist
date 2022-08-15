import React from "react";
import Router from "./Router";
import { QueryClient, QueryClientProvider } from "react-query";

const App = () => {
    const quｆeryClient = new QueryClient({
        defaultOptions: {
            queries: {
                retry: false,
            },
            mutations: {
                retry: false,
            },
        },
    });
    return (
        <h1>
            <QueryClientProvider client={quｆeryClient}>
                <Router />
            </QueryClientProvider>
        </h1>
    );
};

export default App;
