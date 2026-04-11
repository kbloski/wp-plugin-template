const ver = Math.floor( Date.now() / 1000);
const { useWpQueryLazy } = await import(`../../../Hooks/useWpQueryLazy.js?v=${ver}`);
const { useWpMutation } = await import(`../../../Hooks/useWpMutation.js?v=${ver}`);
const {
    provideTag,
    invalidateTag
} = await import(`../../../Events/QueryTagsEvent.js?v=${ver}`);

const queryTags = Object.freeze({
    editCounter: "edit-counter"
});

export function useLazyGetCounterQuery()
{
    const request = {
        path: 'plugintemplate/v1/counter',
        method: 'GET'
    };
    const query = useWpQueryLazy( request );

    provideTag(queryTags.editCounter, () => query[0](request));
    
    return query;
}

export function useEditCounter()
{
    const method = "PATCH";
    let path = 'plugintemplate/v1/counter';
    const [mutate, data] = useWpMutation({ path, method });
    
    function editCounter({ counter })
    {
        mutate({
            path, method,
            body: { counter }
        })
        invalidateTag(queryTags.editCounter);

    }

    return [editCounter, data];
}