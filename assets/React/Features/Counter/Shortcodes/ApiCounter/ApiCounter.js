const ver = Math.floor( Date.now() / 1000);
const { createElement, useEffect} = wp.element; 
const {useGetCounter} = await import(`../../Hooks/useCounter.js?v=${ver}`)

export default function ApiCounter()
{
    const counter = useGetCounter();

    useEffect(() => console.log( counter) , [counter]);

    return createElement('div', {},
        "API COUNTER"
    );
}

