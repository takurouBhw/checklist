import React, { useState } from "react";
import { useCreateTask } from "../../../queries/TaskQuery";

const TaskInput: React.FC = () => {
    const [name, setName] = useState("");
    const creteCompany = useCreateTask();

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        creteCompany.mutate(name);
        setName("");
    };
    return (
        <form className="input-form" onSubmit={handleSubmit}>
            <div className="inner">
                <input
                    type="text"
                    className="input"
                    placeholder="TODOを入力してください。"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                />
                <button className="btn is-primary">追加</button>
            </div>
        </form>
    );
};

export default TaskInput;
