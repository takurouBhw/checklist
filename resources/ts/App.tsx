import React from "react";
import Router from "./Router";
import { QueryClient, QueryClientProvider } from "react-query";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { AuthProvider } from "./hooks/AuthContext";

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
            <AuthProvider>
                <QueryClientProvider client={quｆeryClient}>
                    <Router />
                    <ToastContainer hideProgressBar={true} />
                </QueryClientProvider>
            </AuthProvider>
        </h1>
    );
};

export default App;
