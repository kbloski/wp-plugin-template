const ver = Math.floor(Date.now() / (1000 * 60));
const { useState, useEffect, createElement } = wp.element;
const { useSelect, useDispatch } = wp.data;
const { useTranslations } = await import(`../../../../Hooks/useTranslations.js?v=${ver}`);
const store = (await import(`../../../../Store/store.js?v=${ver}`)).default;

export default function GlobalCounter() 
{
    const t = useTranslations();
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
                { onClick: onIncrement },
                t("button.increment")
            ),
            createElement(
                "button",
                { onClick: onDecrement },
                t("button.decrement")
            ),
        )
    );
}
