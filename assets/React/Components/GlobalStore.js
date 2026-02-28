const { useState, useEffect, createElement } = wp.element;
const { useSelect, useDispatch } = wp.data;

export default function GlobalStore() 
{
    // Loaidng required modules with cache busting 
    useEffect(() => {
        import(`../Store/store.js?v=${Date.now()}`).then( m => setStore(m.default))
    }, []);

    const [store, setStore] = useState(null) 

    const dispatch = useDispatch(store?.namespace);
    const counter = useSelect(
        (select) => store ? select(store.namespace).getCounter() : 0,
        [store]
    );


    function onIncrement()
    {
        dispatch?.increment?.();
    }

    function onDecrement() 
    {
        dispatch?.decrement?.();
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
