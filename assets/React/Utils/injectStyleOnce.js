export function injectStyleOnce(id, css = "") {
    if (!document.getElementById(id)) {
        const style = document.createElement('style');
        style.id = id;
        style.innerHTML = css;
        document.head.appendChild(style);
    }
}