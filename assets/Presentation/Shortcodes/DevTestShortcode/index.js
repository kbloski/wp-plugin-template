const { createElement, createRoot, useState, useEffect } = wp.element;

function Counter({ startCounter = 0 }) // Props
{
  const [count, setCount] = useState(startCounter);

  useEffect(() => console.log(count), [count]);

  return createElement(
    'div',
    null,
    createElement(
      'p',
      null,
      `Count: ${count}`,
      createElement('div', null, 'Testowy')
    ),
    createElement(
        'button',
        { onClick: () => setCount(prev => prev - 1) },
        "Decrement"
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
    createElement(Counter, { startCounter: 5}) // use Props
  );
});
