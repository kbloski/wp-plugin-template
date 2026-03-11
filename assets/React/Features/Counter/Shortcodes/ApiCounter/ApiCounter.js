
const ver = Math.floor( Date.now() / 1000);
const { createElement, useEffect,useState} = wp.element; 
const {useGetCounter, useEditCounter} = await import(`../../Hooks/useCounter.js?v=${ver}`)

export default function ApiCounter()
{
    const [isLoading, setIsLoading] = useState(false);
    const counter = useGetCounter();
    const { mutate : editCounter, isLoading : editIsLoading } = useEditCounter();

    useState(() => {
        setIsLoading( !!counter.isLoading || !!editIsLoading)
    }, [ counter.isLoading, editIsLoading]);

    function onIncrement()
    {
        if (isLoading) return;
        editCounter(1);
    }

    return createElement('div', {},
        createElement('pre', {}, JSON.stringify(counter, null, 4)),

        createElement('button', {
            onClick: onIncrement
        }, isLoading ? "Loading..." : "Increment") 
        


    );
}

