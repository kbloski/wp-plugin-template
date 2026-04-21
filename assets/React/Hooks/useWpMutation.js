const { useState, useCallback, useRef } = wp.element;

export function useWpMutation() {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    const abortRef = useRef(null);

    const mutate = useCallback(async (options = {}) => {
        if (!options.path && !options.url) {
            throw new Error('Missing `path` or `url` for API request');
        }

        if (abortRef.current) {
            abortRef.current.abort();
        }

        const controller = new AbortController();
        abortRef.current = controller;

        setLoading(true);
        setError(null);
        setData(null);

        const isFormData =
            typeof FormData !== 'undefined' &&
            options.body instanceof FormData;

        const opts = {
            ...options,
            signal: controller.signal,
        };

        if (isFormData) {
            if (opts.headers) {
                const headersCopy = { ...opts.headers };

                for (const key of Object.keys(headersCopy)) {
                    if (key.toLowerCase() === 'content-type') {
                        delete headersCopy[key];
                    }
                }

                opts.headers = Object.keys(headersCopy).length
                    ? headersCopy
                    : undefined;
            }
        } else if (opts.body && typeof opts.body === 'object') {
            opts.headers = {
                'Content-Type': 'application/json',
                ...(opts.headers || {}),
            };

            opts.body = JSON.stringify(opts.body);
        }

        try {
            const result = await wp.apiFetch(opts);
            setData(result);
            return result;
        } catch (err) {
            if (err.name !== 'AbortError') {
                setError(err?.message || 'Unknown error');
                throw err;
            }
        } finally {
            setLoading(false);
        }
    }, []);

    return [
        mutate,
        {
            data,
            isLoading: loading,
            error,
            isSuccess: !!data && !error,
        },
    ];
}