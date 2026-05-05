const ver = Math.floor(Date.now());
const { createElement, useEffect, lazy} = wp.element;
const { injectStyleOnce } = await import(`../../../../Utils/injectStyleOnce.js?v=${ver}`);
const { useTranslations } = await import(`../../../../Hooks/useTranslations.js?v=${ver}`)

const styles = `
    .plugintemplate-hello-react 
    {
        border-radius: 4px;
        box-shadow: 0 0 4px rgba(0,0,0,0.12);
        text-align: center;
        background: white;
        padding: 1rem;
    }
`;

export default function HelloReact()
{
    const t = useTranslations();

    // Styles Loading
    useEffect(() => {
        injectStyleOnce("plugintemplate-hello-react", styles)
    }, []);


    return createElement(
        'div', { className: 'plugintemplate-hello-react'},
        createElement("div", null, t('Hello from REACT')),
    );
}