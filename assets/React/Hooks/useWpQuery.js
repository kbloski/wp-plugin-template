const { useState, useEffect, useCallback, useMemo } = wp.element;

export function useWpQuery(defaultOptions = {}) {
    const [data, setData] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);
    const [isSuccess, setIsSuccess] = useState(false);

    // Memoizujemy domyślne opcje, żeby referencja się nie zmieniała
    const memoOptions = useMemo(() => defaultOptions, [JSON.stringify(defaultOptions)]);

    const fetchData = useCallback(
        (overrideOptions = {}) => {
            const options = { ...memoOptions, ...overrideOptions };

            if (!options.path && !options.url) return;

            setIsLoading(true);
            setError(null);
            setIsSuccess(false);

            wp.apiFetch(options)
                .then((result) => {
                    setData(result);
                    setIsSuccess(true);
                })
                .catch((err) => setError(err))
                .finally(() => setIsLoading(false));
        },
        [memoOptions]
    );

    // fetch przy mount
    useEffect(() => {
        fetchData();
    }, [fetchData]);

    return { data, isLoading, error, isSuccess, refetch: fetchData };
}
