// QueryTagsStore.js

// Singleton (jeden globalny system tagów)
const tagListeners = new Map();

/**
 * Rejestruje callback dla tagu.
 * Zwraca unsubscribe (ważne w React).
 */
function provideTag(tag, callback) {
    if (!tagListeners.has(tag)) {
        tagListeners.set(tag, new Set());
    }

    const listeners = tagListeners.get(tag);
    listeners.add(callback);

    // unsubscribe
    return () => {
        listeners.delete(callback);

        if (listeners.size === 0) {
            tagListeners.delete(tag);
        }
    };
}

/**
 * Unieważnia tag – wywołuje wszystkie callbacki
 */
function invalidateTag(tag) {
    const listeners = tagListeners.get(tag);
    if (!listeners) return;

    listeners.forEach(cb => {
        try {
            cb();
        } catch (e) {
            console.error(`Error in tag "${tag}" callback:`, e);
        }
    });
}

export {
    provideTag,
    invalidateTag
};
