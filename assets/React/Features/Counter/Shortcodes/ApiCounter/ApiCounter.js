const ver = Math.floor(Date.now() / 1000);
const { createElement, useEffect, useState } = wp.element; 
const { useGetCounter, useEditCounter } = await import(`../../Hooks/useCounter.js?v=${ver}`);

export default function ApiCounter() {
    const counterRes = useGetCounter();
    const { mutate: editCounter, isLoading: editIsLoading } = useEditCounter();
    const isLoading = counterRes.isLoading || editIsLoading;

    function onIncrement() {
        if (isLoading) return;

        const newVal = counterRes.data?.counter + 1;
        editCounter({ counter: newVal });   
    }

    return createElement('div', {},
        createElement('pre', {}, JSON.stringify(counterRes, null, 4)),

        createElement('button', {
            onClick: onIncrement
        }, isLoading ? "Loading..." : "Increment")
    );
}