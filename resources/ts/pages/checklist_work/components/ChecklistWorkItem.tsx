import React from "react";
import ChecklistWork from "../../../types/ChecklistWork";

type Props = {
    checklistWork: ChecklistWork;
};

const ChecklistWorkItem: React.FC<Props> = ({ checklistWork }) => (
    <li key={checklistWork.id}>
        <label className="checkbox-label">
            <input type="checkbox" className="checkbox-input" />
        </label>
        <div>
            <span>{checklistWork.title}</span>
        </div>
        <button className="btn is-delete">削除</button>
    </li>
);

export default ChecklistWorkItem;
