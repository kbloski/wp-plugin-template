const { useState, createElement } = wp.element;

export default function Counter()
{
    const [counter, setCounter] = useState(2)

    return createElement("div", null, 
        createElement("div", null, `Counter: (${counter})`),
        createElement("div", null, 
            createElement("button", { onClick: () => setCounter(p => --p)}, "Decrement"),
            createElement("button", { onClick: () => setCounter(p => ++p)}, "Increment"),
        )
    );
}