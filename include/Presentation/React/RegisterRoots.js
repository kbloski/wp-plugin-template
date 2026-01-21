const { createElement, createRoot } = wp.element;

import { HelloReactShortcode } from "../../../assets/React/index.js";

const componentsRegistry = {
    ['hello-react'] : HelloReactShortcode
}









document.addEventListener('DOMContentLoaded', () => {
    Object.entries(componentsRegistry)
        .forEach(([key, Component]) => {
        document.querySelectorAll(`[data-react-root="${key}"]`).forEach(el => {
            createRoot(el).render(createElement(Component, { instance: el.dataset.instance }));
        });
    });
});
