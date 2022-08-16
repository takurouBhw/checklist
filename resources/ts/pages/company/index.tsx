import React, { useEffect, useState } from "react";
import axios from "axios";
import { useQuery } from "react-query";

type CompanyProps = {
    id: number;
    client_key?: string;
    name: string;
    postal_code: string;
    address: string;
    email: string;
    phone: string;
    representative?: string;
    responsible?: string;
    url: string;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
};

const CompanyPage: React.FC = () => {
    const { data: companies, status } = useQuery("companies", async () => {
        const { data } = await axios.get<CompanyProps[]>("api/comapnies");
        console.log(data);
        return data;
        // setCompanies(data);
    });

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
            <form className="input-form">
                <div className="inner">
                    <input
                        type="text"
                        className="input"
                        placeholder="TODOを入力してください。"
                        defaultValue=""
                    />
                    <button className="btn is-primary">追加</button>
                </div>
            </form>
            <div className="inner">
                <ul className="task-list">
                    {companies.map((company) => (
                        <li key={company.id}>
                            <label className="checkbox-label">
                                <input
                                    type="checkbox"
                                    className="checkbox-input"
                                />
                            </label>
                            <div>
                                <span>{company.name}</span>
                            </div>
                            <button className="btn is-delete">削除</button>
                        </li>
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

export default CompanyPage;
