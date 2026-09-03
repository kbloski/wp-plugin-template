const ver = window.__plugintemplate.config.version;
const { createElement } = wp.element;
const { useTranslations } = await import(`../../../../Hooks/useTranslations.js?v=${ver}`)

export default function HelloReact()
{
    const t = useTranslations();

    return createElement(
        'div', { className: 'plugintemplate-hello-react'},
        createElement("div", null, t('hello.react')),
    );
}
