const ver = Math.floor(Date.now());
const { lazy } = wp.element;

export const HelloReact = lazy(() => import(`./Features/Hello/Shortcodes/HelloReact/HelloReact.js?v=${ver}`));
export const Counter = lazy(() => import(`./Features/Counter/Shortcodes/Counter/Counter.js?v=${ver}`));
export const GlobalCounter = lazy(() => import(`./Features/Counter/Shortcodes/GlobalCounter/GlobalCounter.js?${ver}`));
export const ApiCounter = lazy(() => import(`./Features/Counter/Shortcodes/ApiCounter/ApiCounter.js?v=${ver}`));