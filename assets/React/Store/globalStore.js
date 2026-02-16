const { registerStore, select, dispatch } = wp.data;

// rejestracja store
registerStore('my-plugin/global', {
    reducer(state = { counter: 0 }, action) {
        switch (action.type) {
            case 'INCREMENT':
                return { ...state, counter: state.counter + 1 };
            default:
                return state;
        }
    },
    actions: {
        increment() {
            return { type: 'INCREMENT' };
        }
    },
    selectors: {
        getCounter(state) {
            return state.counter;
        }
    }
});

// użycie
dispatch('my-plugin/global').increment();
const value = select('my-plugin/global').getCounter();
console.log(value);
