const ver = Math.floor( Date.now() / 1000);
const { useState, useCallback, useRef, useEffect } = wp.element;

const { useWpQueryLazy } = await import(`../../../Hooks/useWpQueryLazy.js?v=${ver}`);
const { useWpMutation } = await import(`../../../Hooks/useWpMutation.js?v=${ver}`);
const {
    provideTags,
    invalidateTags
} = await import(`../../../Events/QueryTagsEvent.js?v=${ver}`);

export function useLazyGetExamples()
{
    const [fetch, data] = useWpQueryLazy();

    function getCounter()
    {
        const request = {
            method: 'GET',
            path: 'plugintemplate/v1/examples',
        };

        fetch(request);
    }
    
    useEffect(() => {
        const unsubscribe = provideTags([ "examples" ], () => getCounter());
        return unsubscribe;
    }, []);
    
    return [getCounter, data];
}

export function useCreateExample()
{
    const [mutate, data] = useWpMutation();
    
    function editCounter({ 
        userId, 
        message
    })
    {
        const request = {
            method: "POST",
            path: 'plugintemplate/v1/examples',
            body: { 
                user_id: userId,
                message
            }
        }

        mutate(request)
    }

    useEffect(() => {
        if (!data?.isSuccess) return
        invalidateTags([ "examples" ]);
    }, [data?.isSuccess])

    return [editCounter, data];
}