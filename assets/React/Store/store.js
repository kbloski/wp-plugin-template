const { registerStore, select } = wp.data;

// Stała nazwa store, singleton dla całej strony
const storeNamespace = new URL('.', import.meta.url).pathname + "store";
const store = select(storeNamespace)

if (!store)
{
    registerStore(
        storeNamespace, 
        {
            reducer: (state = { counter: 2 }, action) => {
                switch (action.type) {
                    case 'INCREMENT':
                        return { ...state, counter: state.counter + 1 };
                    case "DECREMENT":
                        return { ...state, counter: state.counter - 1};
                    default:
                        return state;
                }
            },
            actions: {
                increment() {
                    return { type: 'INCREMENT' };
                },
                decrement() {
                    return { type: "DECREMENT"}
                }
            },
            selectors: {
                getCounter(state) {
                    return state.counter;
                }
            }
        }
    );
}

export default {
    namespace: storeNamespace,
}
 