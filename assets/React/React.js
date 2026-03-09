const ver = Math.floor(Date.now());
const { lazy } = wp.element;

export const HelloReact = lazy(() => import(`./Features/Hello/Shortcodes/HelloReact.js?v=${ver}`));