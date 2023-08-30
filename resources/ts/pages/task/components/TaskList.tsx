import React from "react";
import { useTask } from "../../../queries/TaskQuery";
import TaskItem from './TaskItem';


const TaskList: React.FC = () => {
    const { data: tasks, status } = useTask();

    if (status === "loading") {
        return <div className="loader" />;
    } else if (status === "error") {
        return (
            <div className="align-center">データの読み込みに失敗しました。</div>
        );
    } else if (!tasks || tasks.length <= 0) {
        return (
            <div className="align-center">
                登録された会社情報が存在しません。
            </div>
        );
    }
    console.log(tasks);
    return (
        <>
            <div className="inner">
                <ul className="task-list">
                    {tasks.map((task) => (
                        <TaskItem key={task.id} task={task} id={task.id}/>
                    ))}
                </ul>
            </div>
        </>
    );
};

export default TaskList;
