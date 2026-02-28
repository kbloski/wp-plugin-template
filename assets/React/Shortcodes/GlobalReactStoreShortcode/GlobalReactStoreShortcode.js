const { createElement, useEffect, lazy} = wp.element;
const GlobalStore = lazy(() => import(`../../Components/GlobalStore.js?v=${Date.now()}`))

export default function HelloReactShortcode()
{
    return createElement(
        'div', {},
        createElement("div", null, "Global store usage"),
        createElement(GlobalStore, {})
    );
}