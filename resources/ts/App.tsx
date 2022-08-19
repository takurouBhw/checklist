import React from "react";
import Router from "./Router";
import { QueryClient, QueryClientProvider } from "react-query";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

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
                <ToastContainer hideProgressBar={true}/>
            </QueryClientProvider>
        </h1>
    );
};

export default App;
