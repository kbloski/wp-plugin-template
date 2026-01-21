const { createElement, useState } = wp.element;
import Button from '../../Components/Button/index.js';

export default function HelloReactShortcode({ startCounter = 0 }) {
  const [count, setCount] = useState(startCounter);

  return createElement(
    'div',
    null,
    createElement('p', null, `Count: ${count}`),

    Button({
      label: '−',
      onClick: () => setCount(count - 1),
    }),

    Button({
      label: '+',
      onClick: () => setCount(count + 1),
    })
  );
}
