const ver = Math.floor(Date.now() / (1000 * 60));
const { createElement, useEffect, useState } = wp.element; 
const { useLazyGetCounterQuery, useEditCounter } = await import(`../../Hooks/useCounter.js?v=${ver}`);
const { useTranslations } = await import(`../../../../Hooks/useTranslations.js?v=${ver}`);

export default function ApiCounter() {
    const [getCounter, data] = useLazyGetCounterQuery();
    const [editCounter, { isLoading: editIsLoading }] = useEditCounter();
    const t = useTranslations();
    const isLoading = data.isLoading; // || editIsLoading;

    useEffect(() => {  getCounter() }, []);

    function onIncrement() {
        if (isLoading) return;

        const newVal = data?.data?.counter + 1;
        editCounter({ counter: newVal });   
    }

    return createElement('div', {},
        createElement('pre', {}, JSON.stringify(data, null, 4)),

        createElement('button', {
            onClick: onIncrement
        }, isLoading ? "Loading..." : t("button.increment"))
    );
}