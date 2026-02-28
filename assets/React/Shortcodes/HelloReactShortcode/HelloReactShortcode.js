const { createElement, useEffect, lazy} = wp.element;
const Counter = lazy(() => import(`../../Components/Counter.js?v=${Date.now()}`))

const styles = `
    .plugintemplate-hello-react {
        border-radius: 4px;
        box-shadow: 0 0 4px black;
        background: white;
        padding: 1rem;
    }
`;

export default function HelloReactShortcode()
{
    // Styles Loading Busting
    useEffect(() => {
        import(`../../Utils/injectStyleOnce.js?v=${Date.now()}`)
        .then( m => m.injectStyleOnce("plugintemplate-hello-react", styles))
    }, []);

    return createElement(
        'div', { className: 'plugintemplate-hello-react'},
        createElement("div", null,'❤️ Hello from REACT ❤️'),
        createElement(Counter, {}),
    );
}