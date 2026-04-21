const ver = Math.floor( Date.now() / 1000);
const { useState, useCallback, useRef, useEffect } = wp.element;

const { useWpQueryLazy } = await import(`../../../Hooks/useWpQueryLazy.js?v=${ver}`);
const { useWpMutation } = await import(`../../../Hooks/useWpMutation.js?v=${ver}`);
const {
    provideTags,
    invalidateTags
} = await import(`../../../Events/QueryTagsEvent.js?v=${ver}`);

const queryTags = Object.freeze({
    editCounter: "edit-counter"
});

export function useLazyGetCounterQuery()
{
    const [fetch, data] = useWpQueryLazy();

    function getCounter()
    {
        const request = {
            path: 'plugintemplate/v1/counter',
            method: 'GET'
        };

        fetch(request);
    }
    
    useEffect(() => {
        const unsubscribe = provideTags(queryTags.editCounter, () => getCounter());
        return unsubscribe;
    }, []);
    
    return [getCounter, data];
}

export function useEditCounter()
{
    const [mutate, data] = useWpMutation();
    
    function editCounter({ counter })
    {
        const request = {
            method: "PATCH",
            path: 'plugintemplate/v1/counter',
            body: { counter }
        }

        mutate(request)
    }

    useEffect(() => {
        if (!data?.isSuccess) return
        invalidateTags(queryTags.editCounter);
    }, [data?.isSuccess])

    return [editCounter, data];
}