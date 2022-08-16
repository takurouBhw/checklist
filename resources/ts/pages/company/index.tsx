import React from "react";
import { useCompany } from "../../queries/CompanyQuery";
import CompanyInput from "./components/CompanyInput";
import CompanyList from "./components/CompanyList";

const CompanyPage: React.FC = () => (
    <>
        <CompanyInput />
        <CompanyList />
    </>
);

export default CompanyPage;
