const ver = Math.floor(Date.now() / 1000);
const { useState, useEffect, createElement } = wp.element;
const { useSelect, useDispatch } = wp.data;
const store = (await import(`../../../../Store/store.js?v=${ver}`)).default;

export default function GlobalCounter() 
{
    const dispatch = useDispatch(store.namespace);
    const counter = useSelect( (select) => select(store.namespace).getCounter() , [store] );

    const onIncrement = () => dispatch.increment();
    const onDecrement = () => dispatch.decrement();

    return createElement(
        "div",
        null,
        createElement("div", null, `Global Counter: (${counter })`),
        createElement("div", null, 
            createElement(
                "button",
                { onClick: onDecrement },
                "Decrement"
            ),
            createElement(
                "button",
                { onClick: onIncrement },
                "Increment"
            ),
        )
    );
}
