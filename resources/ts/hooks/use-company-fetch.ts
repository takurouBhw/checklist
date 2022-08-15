import { useState, useEffect } from "react";
// import { Property } from '../domains/checklist/models/Property';

const useCompanyFetch = (): [
    Properties: [],
    setProperties: (properties: []) => void
] => {
    const [properties, setPropperties] = useState<[]>([]);

    useEffect(() => {
        void fetch("/companies", { method: "GET" })
            .then((res) => res.json())
            .then((data) => {
                // eslint-disable-next-line
                console.log(data);
                // eslint-disable-next-line @typescript-eslint/no-unsafe-argument
                setPropperties(data);
            });
    }, []);

    return [properties, setPropperties];
};

export default useCompanyFetch;
