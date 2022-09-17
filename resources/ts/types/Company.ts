type Company = {
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
    is_done: boolean;
    input?: string;
};

export default Company;
