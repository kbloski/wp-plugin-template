const { useState, useEffect, createElement } = wp.element;
const { useSelect, useDispatch } = wp.data;
import Store from "../Store/store.js";

export default function GlobalStore() 
{
    const {namespace} = Store;
    const counter = useSelect(select =>  select(namespace).getCounter(), [] );
    const {increment, decrement} = useDispatch(namespace);

    function onIncrement()
    {
       increment?.();
    }

    function onDecrement() 
    {
        decrement?.();
    }

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
