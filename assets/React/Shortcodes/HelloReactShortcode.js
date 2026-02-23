
import Counter from "../Components/Counter.js";
// import GlobalStore from "../Components/GlobalStore.js";
const { createElement, useEffect } = wp.element;


const stylesId = 'plugintemplate-cards-list-styles';
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
    // Styles Loading 
    useEffect(() => {
        if (!document.getElementById(stylesId)) {
            const style = document.createElement('style');
            style.id = stylesId;
            style.innerHTML = styles;
            document.head.appendChild(style); 
        }
    }, []);

    return createElement(
        'div', { className: 'plugintemplate-hello-react'},
        createElement("div", null,'❤️ Hello from REACT ❤️'),
        createElement(Counter, {}),
        createElement("div", null, "Global store usage"),
        // createElement(GlobalStore, {})
    );
}