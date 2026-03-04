const { useState, useCallback } = wp.element;

export function useWpMutation(defaultOptions = {}) {
    const [success, setSuccess] = useState(false); 
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    /**
     * Funkcja wywołująca mutację.
     * @param {Object} overrideOptions - opcje zapytania (path, method, body, headers)
     */
    const mutate = useCallback(
        async (overrideOptions = {}) => {
            const options = { ...defaultOptions, ...overrideOptions };

            if (!options.path && !options.url) {
                throw new Error('Missing `path` or `url` for API request');
            }

            setLoading(true);
            setError(null);
            setSuccess(false);

            // Detect FormData reliably (different execution contexts may make instanceof fail)
            const isFormData = (typeof FormData !== 'undefined' && options.body instanceof FormData) || (
                options.body && typeof options.body.append === 'function' && typeof options.body.get === 'function'
            );

            if (isFormData) {
                if (options.headers) {
                    const headersCopy = { ...options.headers };
                    for (const key of Object.keys(headersCopy)) {
                        if (key.toLowerCase() === 'content-type') delete headersCopy[key];
                    }
                    options.headers = Object.keys(headersCopy).length ? headersCopy : undefined;
                } else {
                    options.headers = undefined;
                }
            } else if (options.body && typeof options.body === 'object') {
                options.headers = {
                    'Content-Type': 'application/json',
                    ...(options.headers || {}),
                };
                options.body = JSON.stringify(options.body);
            }

            try {
                const result = await wp.apiFetch({
                    ...options,
                });

                setData(result);
                setSuccess(true);
                return result;
            } catch (err) {
                setError(err);
                setSuccess(false);
                throw err;
            } finally {
                setLoading(false);
            }
        },
        [defaultOptions]
    );

    return { isSuccess: success, data, isLoading: loading, error, mutate };
}
