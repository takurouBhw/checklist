import React from "react";
import Company from "../../../types/Company";
import {useUpdateCompany} from '../../../queries/CompanyQuery'

type Props = {
    company: Company;
};

const CompanyItem: React.FC<Props> = ({ company }) => {
    const updateCompany = useUpdateCompany();

    return <li key={company.id} className={company.is_done ? "done" : ""}>
        <label className="checkbox-label">
            <input type="checkbox" className="checkbox-input" onClick={()=> updateCompany.mutate(company)} />
        </label>
        <div>
            <span>{company.name}</span>
        </div>
        <button className="btn is-delete">削除</button>
    </li>
}

export default CompanyItem;
