const ver = Math.floor( Date.now() / 1000);
const { useWpQuery } = await import(`../../../Hooks/useWpQuery.js?v=${ver}`);

export function useGetCounter()
{
    let path = 'plugintemplate/v1/counter';

    const query = useWpQuery({ path });

    return query;
}