import React from "react";
import { useChecklistWork } from "../../../queries/ChecklistWorkQuery";
import ChecklistWorkItem from "./ChecklistWorkItem";

const ChecklistWorkList: React.FC = () => {
    const { data: checklist_works, status } = useChecklistWork();
    if (status === "loading") {
        return <div className="loader" />;
    } else if (status === "error") {
        return (
            <div className="align-center">データの読み込みに失敗しました。</div>
        );
    } else if (!checklist_works || checklist_works.length <= 0) {
        return (
            <div className="align-center">
                登録されたチェックリストが存在しません。
            </div>
        );
    }
    return (
        <>
            <div className="inner">
                <ul className="task-list">
                    {checklist_works.map((checklistWork) => (
                        <ChecklistWorkItem checklistWork={checklistWork} />
                    ))}
                    <li>
                        <label className="checkbox-label">
                            <input type="checkbox" className="checkbox-input" />
                        </label>
                        <div>
                            <span>新しいTODO</span>
                        </div>
                        <button className="btn is-delete">削除</button>
                    </li>
                    <li>
                        <label className="checkbox-label">
                            <input type="checkbox" className="checkbox-input" />
                        </label>
                        <form>
                            <input
                                type="text"
                                className="input"
                                defaultValue="編集中のTODO"
                            />
                        </form>
                        <button className="btn">更新</button>
                    </li>
                    <li className="done">
                        <label className="checkbox-label">
                            <input type="checkbox" className="checkbox-input" />
                        </label>
                        <div>
                            <span>実行したTODO</span>
                        </div>
                        <button className="btn is-delete">削除</button>
                    </li>
                    <li>
                        <label className="checkbox-label">
                            <input type="checkbox" className="checkbox-input" />
                        </label>
                        <div>
                            <span>ゴミ捨て</span>
                        </div>
                        <button className="btn is-delete">削除</button>
                    </li>
                    <li>
                        <label className="checkbox-label">
                            <input type="checkbox" className="checkbox-input" />
                        </label>
                        <div>
                            <span>掃除</span>
                        </div>
                        <button className="btn is-delete">削除</button>
                    </li>
                </ul>
            </div>
        </>
    );
};

export default ChecklistWorkList;
