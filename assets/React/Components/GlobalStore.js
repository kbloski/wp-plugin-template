const { useState, useEffect, createElement } = wp.element;
const { useSelect, useDispatch } = wp.data;
import { getStore } from "../Store/store.js";

export default function GlobalStore() 
{
    const { select, dispatch } = getStore();
    const counter = useSelect(() =>  select().getCounter(), [select] );
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
