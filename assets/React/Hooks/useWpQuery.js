const { useState, useEffect, useCallback, useMemo } = wp.element;

export function useWpQuery(defaultOptions = {}) {
    const [data, setData] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);
    const [isSuccess, setIsSuccess] = useState(false);

    // Memoizujemy domyślne opcje, żeby referencja się nie zmieniała
    const memoOptions = useMemo(() => defaultOptions, [JSON.stringify(defaultOptions)]);

    const fetchData = useCallback(
        async (overrideOptions = {}) => {
            const options = { ...memoOptions, ...overrideOptions };

            if (!options.path && !options.url) return;

            setIsLoading(true);
            setError(null);
            setIsSuccess(false);

            try {
                const result = await wp.apiFetch({
                    ...options,
                });

                setData(result);
                setIsSuccess(true);
                return result;
            } catch (err) 
            {
                let data = null;
                if (err instanceof Response) data = await err.json();
                setData(data);
                setError(err?.statusText);
                setIsSuccess(false);
                throw err;
            } finally {
                setIsLoading(false);
            }
        },
        [memoOptions]
    );

    // fetch przy mount
    useEffect(() => {
        fetchData();
    }, [fetchData]);

    return { data, isLoading, error, isSuccess, refetch: fetchData };
}
