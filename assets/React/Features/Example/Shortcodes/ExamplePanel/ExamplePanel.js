const ver = Math.floor(Date.now() / (1000 * 60));
const { createElement, useEffect, useState } = wp.element; 
const { useLazyGetExamples, useCreateExample } = await import(`../../Hooks/useExample.js?v=${ver}`);
const { useTranslations } = await import(`../../../../Hooks/useTranslations.js?v=${ver}`);

export default function ApiCounter() {
    const t = useTranslations();
    const [getExamples, getExampleRes] = useLazyGetExamples();
    const [createExample, createExampleRes] = useCreateExample();
    const isLoading = getExampleRes.isLoading || createExampleRes.isLoading; 

    useEffect(() => {  getExamples() }, []);

    function onSubmit( e )
    {
        e.preventDefault();
        createExample({
            message: "Generated message: " + Math.random()
        });
    }

    return createElement('div', {},

        createElement("form", {
            onSubmit
        },
            createElement("div", {}, "Generate random message"),
            createElement('button', {
                disabled: isLoading
            }, isLoading ? t("loading") : t("action.generate")),
        ),
        
        createElement('pre', {}, JSON.stringify(getExampleRes, null, 4)),
    );
}