const { createElement, useState } = wp.element;
import Button from '../../Components/Button/index.js';

export default function HelloReactShortcode({ startCounter = 0 }) {
  const [count, setCount] = useState(startCounter);

  return createElement(
    'div',
    null,
    createElement("h1", null, "Hello from React wp.elements ❤️😁"),
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
