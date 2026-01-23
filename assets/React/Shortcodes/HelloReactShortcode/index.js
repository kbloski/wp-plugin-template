const { createElement, useState } = wp.element;
import { Button } from '../../Components/index.js';


export default function HelloReactShortcode( props = {}) {

  console.log(props.root.dataset);

  const [count, setCount] = useState( parseInt( props.root.dataset?.startCounter) ?? 0);
  const [input, setInput] = useState("");

  return createElement(
    'div',
    null,
    createElement("h1", null, "Hello from React wp.elements ❤️😁"),
    createElement('div', null, 
      createElement('input', {onChange: p => setInput(p.target.value) }),
      'Input value: ' + input,
    ),
    createElement('div', null, 
      Button({
        label: '−',
        onClick: () => setCount(count - 1),
      }),
      Button({
        label: '+',
        onClick: () => setCount(count + 1),
      }),
      createElement("p", null, `Counter: ${count}`)
    ),
  );
}
