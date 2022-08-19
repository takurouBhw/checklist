import React from "react";
import { useCompany } from "../../../queries/CompanyQuery";
import CompanyItem from './CompanyItem';


const CompanyList: React.FC = () => {
    const { data: companies, status } = useCompany();

    if (status === "loading") {
        return <div className="loader" />;
    } else if (status === "error") {
        return (
            <div className="align-center">データの読み込みに失敗しました。</div>
        );
    } else if (!companies || companies.length <= 0) {
        return (
            <div className="align-center">
                登録された会社情報が存在しません。
            </div>
        );
    }
    return (
        <>
            <div className="inner">
                <ul className="task-list">
                    {companies.map((company) => (
                        <CompanyItem company={company} id={company.id}/>
                    ))}
                </ul>
            </div>
        </>
    );
};

export default CompanyList;
