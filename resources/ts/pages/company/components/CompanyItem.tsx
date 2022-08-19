import React, { useState } from "react";
import Company from "../../../types/Company";
import { toast } from "react-toastify";

import {
    useUpdateCompanyDone,
    useDeleteCompany,
    useUpdateCompany,
} from "../../../queries/CompanyQuery";

type Props = {
    company: Company;
    id: number;
};

const CompanyItem: React.FC<Props> = ({ company, id }) => {
    const updateCompanyDone = useUpdateCompanyDone();
    const updateCompany = useUpdateCompany();
    const [editName, setEditName] = useState<string | undefined>(undefined);

    const handleToggleEdit = () => {
        setEditName(company.name);
    };
    const handleOnKey = (e: React.KeyboardEvent<HTMLInputElement>) => {
        if (["Escape", "Tab"].includes(e.key)) {
            setEditName(undefined);
        }
    };
    const handleOnBlur = () => {
        setEditName(undefined);
    };
    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setEditName(e.target.value);
    };
    const handleUpdate = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();

        // 未入力の場合
        if (editName === undefined) {
            toast.error('会社名を入力してください。');
            return;
        }

        const newCompany = { ...company };
        newCompany.name = editName;

        updateCompany.mutate(({
            id: company.id,
            company: newCompany,
        }))

        setEditName(undefined);
    };
    const itemInput = () => {
        return (
            <>
                <form>
                    <input
                        type="text"
                        className="input"
                        defaultValue={editName}
                        onKeyDown={handleOnKey}
                        onBlur={handleOnBlur}
                        onChange={handleInputChange}
                    />
                </form>
                <button className="btn" onClick={handleUpdate}>
                    更新
                </button>
            </>
        );
    };
    const itemText = () => (
        <>
            <div onClick={handleToggleEdit}>
                <span>{company.name}</span>
            </div>
            <button className="btn is-delete">削除</button>
        </>
    );

    return (
        <li key={id} className={company.is_done ? "done" : ""}>
            <label className="checkbox-label">
                <input
                    type="checkbox"
                    className="checkbox-input"
                    onClick={() => updateCompanyDone.mutate(company)}
                />
            </label>
            {editName === undefined ? itemText() : itemInput()}
        </li>
    );
};

export default CompanyItem;
