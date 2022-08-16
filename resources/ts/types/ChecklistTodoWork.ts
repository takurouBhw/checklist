// 見出しフラグ
export const HEADING_FLAG = {
    // 見出しデフォルト
    OFF: 0,
    // 見出しONにするとチェック項目から除外
    ON: 1,
} as const;

type HeadingFlage = typeof HEADING_FLAG[keyof typeof HEADING_FLAG];

type ChecklistTodoWorks = {
    id: number;
    category_id: number;
    checklist_id: number;
    user_id: string;
    headline: HeadingFlage;
    attention: number;
    check_item: [];
    checked: [];
    memo: string;
    second: [];
};

export default ChecklistTodoWorks;
