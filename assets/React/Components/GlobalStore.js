const { useState, useEffect, createElement } = wp.element;
const { useSelect, useDispatch } = wp.data;
import { getStore } from "../Store/store.js";

export default function GlobalStore() {
    const {select, dispatch} = getStore();
    const counter = useSelect(() => select().getCounter(), [] );

    // useEffect(() => {
    //     import(`../Store/store.js?v=${Date.now()}`)
    //         .then((module) => setStoreApi(module.getStore()));
    // }, []);
    // if (!storeApi) {
    //     return createElement("div", null, "Loading...");
    // }
    

    return createElement(
        "div",
        null,
        createElement("div", null, `Global Counter: (${select().getCounter()})`),
        createElement("div", null, 
            createElement(
                "button",
                { onClick: () => dispatch().increment() },
                "Increment"
            ),
            createElement(
                "button",
                { onClick: () => dispatch().decrement() },
                "Decrement"
            ),
        )
    );
}
