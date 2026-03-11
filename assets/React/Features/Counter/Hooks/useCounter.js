const ver = Math.floor( Date.now() / 1000);
const { useWpQuery } = await import(`../../../Hooks/useWpQuery.js?v=${ver}`);
const { useWpMutation } = await import(`../../../Hooks/useWpMutation.js?v=${ver}`);
const {
    provideTag,
    invalidateTag
} = await import(`../../../Events/QueryTagsEvent.js?v=${ver}`);

const queryTags = Object.freeze({
    editCounter: "edit-counter"
});

export function useGetCounter()
{
    const request = {
        path: 'plugintemplate/v1/counter',
        method: 'GET'
    };
    const query = useWpQuery( request );

    provideTag(queryTags.editCounter, () => query.refetch(request));
    
    return query;
}

export function useEditCounter()
{
    const method = "PATCH";
    let path = 'plugintemplate/v1/counter';
    const request = useWpMutation({ path, method });

    function mutate({ counter })
    {
        request.mutate({
            path, method,
            body: { counter }
        })
        invalidateTag(queryTags.editCounter);

    }

    return { ...request, mutate};
}