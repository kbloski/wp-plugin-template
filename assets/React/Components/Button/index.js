const { createElement } = wp.element;

export default function Button({ 
    label = "Click me",
    onClick = () => {} 
}) {
    return createElement(
        'button', 
        { onClick, style: { cursor: 'pointer' } },
        label
    );
}
