const { useState, createElement } = wp.element;

export default function Counter()
{
    const [counter, setCounter] = useState(0)

    return createElement("div", null, 
        createElement("div", null, `Counterr: (${counter})`),
        createElement("div", null, 
            createElement("button", { onClick: () => setCounter(p => ++p)}, "Increment"),
            createElement("button", { onClick: () => setCounter(p => --p)}, "Decrement")
        )
    );
}