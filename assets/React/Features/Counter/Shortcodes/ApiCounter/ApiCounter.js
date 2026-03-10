const ver = Math.floor( Date.now() / 1000);
const { createElement } = wp.element; 

export default function ApiCounter()
{
    return createElement('div', {},
        "API COUNTER"
    );
}

