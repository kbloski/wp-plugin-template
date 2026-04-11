const { useState, useEffect, useCallback, useMemo } = wp.element;

export function useWpQueryLazy(defaultOptions = {}) {
    const [data, setData] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);
    const [isSuccess, setIsSuccess] = useState(false);

    const memoOptions = useMemo(() => defaultOptions, [defaultOptions]);

    const fetch = useCallback(
        async (overrideOptions = {}) => {
            const options = { ...memoOptions, ...overrideOptions };

            if (!options.path && !options.url) return;

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
        },
        [memoOptions]
    );

    return [fetch, { data, isLoading, error, isSuccess }];
}