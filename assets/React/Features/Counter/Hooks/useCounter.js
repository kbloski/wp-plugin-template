const ver = Math.floor( Date.now() / 1000);
const { useWpQuery } = await import(`../../../Hooks/useWpQuery.js?v=${ver}`);
const { useWpMutation } = await import(`../../../Hooks/useWpMutation.js?v=${ver}`);

export function useGetCounter()
{
    let path = 'plugintemplate/v1/counter';
    const method = "GET";

    const query = useWpQuery({ path, method});
    return query;
}

export function useEditCounter()
{
    const method = "PATCH";
    let path = 'plugintemplate/v1/counter';
    const request = useWpMutation({ path, method });

    function mutate( counter )
    {
        request.mutate({
            path, method,
            body: {
                counter
            }
        })
    }

    return { ...request, mutate};
}