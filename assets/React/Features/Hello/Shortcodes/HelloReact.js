const { createElement, useEffect, lazy} = wp.element;
// import { injectStyleOnce } from "../../Utils/injectStyleOnce.js";
// const Counter = lazy(() => import(`../../Components/Counter.js`))

// const styles = `
//     .plugintemplate-hello-react {
//         border-radius: 4px;
//         box-shadow: 0 0 4px black;
//         background: white;
//         padding: 1rem;
//     }
// `;

export default function HelloReact()
{
    // Styles Loading Busting
    // useEffect(() => {
    //     injectStyleOnce("plugintemplate-hello-react", styles)
    // }, []);


    return createElement(
        'div', { className: 'plugintemplate-hello-react'},
        createElement("div", null,'❤️ Hello from REACT ❤️'),
        // createElement(Counter, {}),
    );
}