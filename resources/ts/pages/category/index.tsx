import React from "react";
import { useCategory } from "../../queries/CategoryQuery";

const CategoryPage: React.FC = () => {
    const { data: tasks, status } = useCategory();

    if (status === "loading") {
        return <div className="loader" />;
    } else if (status === "error") {
        return (
            <div className="align-center">データの読み込みに失敗しました。</div>
        );
    } else if (!tasks || tasks.length <= 0) {
        return (
            <div className="align-center">
                登録されたカテゴリが存在しません。
            </div>
        );
    }

    return (
        <div>
            <table>
                <tr>
                    <th>

                    </th>
                </tr>
            </table>
        </div>
    );
};

export default CategoryPage;
