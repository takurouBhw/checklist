import React from "react";
import ChecklistWorkInput from "./components/ChecklistWorkInput";
import ChecklistWorkList from "./components/ChecklistWorkList";

const ChecklistWorkPane: React.FC = () => (
    <>
        <ChecklistWorkInput />
        <ChecklistWorkList />
    </>
);

export default ChecklistWorkPane;
