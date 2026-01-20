const { createElement, createRoot, useState } = wp.element;

function Counter({ startCounter = 0 }) {
  const [count, setCount] = useState(0);

  return createElement(
    'div',
    null,
    createElement(
      'p',
      null,
      `Count: ${startCounter + count}`,
      createElement('div', null, 'Testowy')
    ),
    createElement(
      'button',
      { onClick: () => setCount(count + 1) },
      'Increment'
    )
  );
}


document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('my-react-app');
  if (!container) return;

  createRoot(container).render(
    createElement(Counter)
  );
});
