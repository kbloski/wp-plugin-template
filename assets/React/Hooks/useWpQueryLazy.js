const { useState, useCallback } = wp.element;

export function useWpQueryLazy() {
    const [data, setData] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);
    const [isSuccess, setIsSuccess] = useState(false);

    const runQuery = useCallback(async (options) => {
        if (!options?.path && !options?.url) return;

        setIsLoading(true);
        setError(null);
        setIsSuccess(false);

        try {
            const result = await wp.apiFetch(options);
            setData(result);
            setIsSuccess(true);
            return result;
        } catch (err) {
            setError(err?.message || 'Unknown error');
            setIsSuccess(false);
            throw err;
        } finally {
            setIsLoading(false);
        }
    }, []);

    return [runQuery, { data, isLoading, error, isSuccess }];
}