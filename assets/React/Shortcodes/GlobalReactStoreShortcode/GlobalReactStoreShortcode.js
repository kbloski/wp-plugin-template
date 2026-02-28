const { createElement, useEffect, lazy} = wp.element;
const GlobalStore = lazy(() => import(`../../Components/GlobalStore.js`))

export default function HelloReactShortcode()
{
    return createElement(
        'div', {},
        createElement("div", null, "Global store usage"),
        createElement(GlobalStore, {})
    );
}