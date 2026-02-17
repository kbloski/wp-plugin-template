const { registerStore, select, dispatch } = wp.data;

// Stała nazwa store, singleton dla całej strony
const storeNamespace = `store-${Math.random().toString(36).substr(2, 9)}`;
let isRegistered = false;

export function getStore() {
    if (!isRegistered) {
        registerStore(storeNamespace, {
            reducer: (state = { counter: 2 }, action) => {
                switch (action.type) {
                    case 'INCREMENT':
                        return { ...state, counter: state.counter + 1 }; // ✅ immutable
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
        });

        isRegistered = true;
    }

    return {
        select: () => select(storeNamespace),
        dispatch: () => dispatch(storeNamespace),
        namespace: storeNamespace
    };
}
