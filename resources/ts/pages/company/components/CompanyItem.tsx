import React from "react";
import Company from "../../../types/Company";

type Props = {
    company: Company;
};

const CompanyItem: React.FC<Props> = ({ company }) => (
    <li key={company.id}>
        <label className="checkbox-label">
            <input type="checkbox" className="checkbox-input" />
        </label>
        <div>
            <span>{company.name}</span>
        </div>
        <button className="btn is-delete">削除</button>
    </li>
);

export default CompanyItem;
