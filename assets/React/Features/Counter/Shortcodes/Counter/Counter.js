const ver = Math.floor(Date.now() / (1000 * 60))
const { useState, createElement } = wp.element;
const { useTranslations } = await import(`../../../../Hooks/useTranslations.js?v=${ver}`)

export default function Counter()
{
    const [counter, setCounter] = useState(2)
    const t = useTranslations();

    return createElement("div", null, 
        createElement("div", null, t("counter") + `: +(${counter})`),
        createElement("div", null, 
            createElement("button", { onClick: () => setCounter(p => ++p)}, t("button.increment")),
            createElement("button", { onClick: () => setCounter(p => --p)}, t("button.decrement")),
        )
    );
}