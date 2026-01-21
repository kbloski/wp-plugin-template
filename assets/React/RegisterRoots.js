const { createElement, createRoot, useState, useEffect } = wp.element;

import { HelloReactShortcode } from "./Shortcodes/index.js";

const componentsRegistry = {
    'hello-react' : HelloReactShortcode
}

document.addEventListener('DOMContentLoaded', () => {
    Object.entries(componentsRegistry)
        .forEach(([key, Component]) => {
        document.querySelectorAll(`[data-react-root="${key}"]`).forEach(el => {
            createRoot(el).render(createElement(Component, { instance: el.dataset.instance }));
        });
    });
});
