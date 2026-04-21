// QueryTagsStore.js

const tagListeners = new Map();


// =========================
// SUBSCRIPTION
// =========================

function provideTags(tags, callback) {
    const tagList = Array.isArray(tags) ? tags : [tags];

    tagList.forEach(tag => {
        if (!tagListeners.has(tag)) {
            tagListeners.set(tag, new Set());
        }

        tagListeners.get(tag).add(callback);
    });

    return () => {
        tagList.forEach(tag => {
            const listeners = tagListeners.get(tag);
            if (!listeners) return;

            listeners.delete(callback);

            if (listeners.size === 0) {
                tagListeners.delete(tag);
            }
        });
    };
}


// =========================
// INVALIDATION (MULTI)
// =========================

function invalidateTags(tags) {
    const tagList = Array.isArray(tags) ? tags : [tags];

    const firedCallbacks = new Set();

    tagList.forEach(tag => {
        const listeners = tagListeners.get(tag);
        if (!listeners) return;

        listeners.forEach(cb => {
            // 🔥 dedupe - ten sam callback nie odpali 2x
            if (firedCallbacks.has(cb)) return;

            firedCallbacks.add(cb);

            try {
                cb();
            } catch (e) {
                console.error(`Error in tag "${tag}" callback:`, e);
            }
        });
    });
}


// =========================
// EXPORT
// =========================

export {
    provideTags,
    invalidateTags
};