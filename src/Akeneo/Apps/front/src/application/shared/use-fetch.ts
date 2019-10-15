import * as React from 'react';
import {RouterContext} from './router/router-context';

const defaultOptions: RequestInit = {
    credentials: 'include',
};

export const useFetch = <T extends object>(route: string, parameters?: object, options: RequestInit = {}) => {
    const {generate} = React.useContext(RouterContext);
    const url = generate(route, parameters);

    const [result, setResult] = React.useState<T>();
    const [error, setError] = React.useState<Error>();

    React.useEffect(() => {
        const doFetch = async () => {
            try {
                const response = await fetch(url, {...defaultOptions, ...options});
                if (!response.ok) {
                    throw new Error('TODO HANDLE ERROR 400 HERE');
                }

                const result = await response.json();

                setResult(result);
            } catch (error) {
                setError(error);
            }
        };
        doFetch();
    }, [url, options]);

    return {result, error};
};
