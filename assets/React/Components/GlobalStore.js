const { useState, useEffect, createElement } = wp.element;
const { useSelect, useDispatch } = wp.data;
import { namespace } from "../Store/store.js";

export default function GlobalStore() 
{
    const counter = useSelect(() =>  select(namespace).getCounter(), [select] );
    const {increment, decrement} = useDispatch(namespace);

    function onIncrement()
    {
        dispatch().increment();
    }

    function onDecrement() 
    {
        dispatch().decrement();
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
