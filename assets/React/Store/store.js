const 

// document.addEventListener('DOMContentLoaded', () => register(storeNamespace))

// function register( storeNamespace )
// {
//     wp.data.registerStore(
//         storeNamespace, 
//         {
//             reducer: (state = { counter: 2 }, action) => {
//                 switch (action.type) {
//                     case 'INCREMENT':
//                         return { ...state, counter: state.counter + 1 }; // ✅ immutable
//                     case "DECREMENT":
//                         return { ...state, counter: state.counter - 1};
//                     default:
//                         return state;
//                 }
//             },
//             actions: {
//                 increment() {
//                     return { type: 'INCREMENT' };
//                 },
//                 decrement() {
//                     return { type: "DECREMENT"}
//                 }
//             },
//             selectors: {
//                 getCounter(state) {
//                     return state.counter;
//                 }
//             }
//         }
//     );
// }

export default {
    namespace: storeNamespace
}