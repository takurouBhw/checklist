import React, { useState } from "react";
import Task from "../../../types/Task";
import { toast } from "react-toastify";

import {
    useUpdateTaskDone,
    useDeleteTask,
    useUpdateTask,
} from "../../../queries/TaskQuery";

type Props = {
    task: Task;
    id: number;
};

const TaskItem: React.FC<Props> = ({ task, id }) => {
    const updateTaskDone = useUpdateTaskDone();
    const updateTask = useUpdateTask();
    const [editTitle, setEditTitle] = useState<string | undefined>(undefined);

    const handleToggleEdit = () => {
        setEditTitle(task.title);
    };
    const handleOnKey = (e: React.KeyboardEvent<HTMLInputElement>) => {
        if (["Escape", "Tab"].includes(e.key)) {
            setEditTitle(undefined);
        }
    };
    const handleOnBlur = () => {
        setEditTitle(undefined);
    };
    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setEditTitle(e.target.value);
    };
    const handleUpdate = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();

        // 未入力の場合
        if (editTitle === undefined) {
            toast.error('タスク名');
            return;
        }

        const newTask = { ...task };
        newTask.title = editTitle;

        updateTask.mutate(({
            id: task.id,
            task: newTask,
        }))

        setEditTitle(undefined);
    };
    const itemInput = () => {
        return (
            <>
                <form>
                    <input
                        type="text"
                        className="input"
                        defaultValue={editTitle}
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
                <span>{task.title}</span>
            </div>
            <button className="btn is-delete">削除</button>
        </>
    );

    return (
        <li key={id} className={task.is_done ? "done" : ""}>
            <label className="checkbox-label">
                <input
                    type="checkbox"
                    className="checkbox-input"
                    onClick={() => updateTaskDone.mutate(task)} />

            </label>
            {editTitle === undefined ? itemText() : itemInput()}
        </li>
    );
};

export default TaskItem;
