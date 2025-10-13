import axios from 'axios';
import collapse from "@alpinejs/collapse";
import anchor from "@alpinejs/anchor";

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Element.prototype.on = function(eventName, selector, callback) {
    if (typeof selector === 'function') {
        callback = selector;
        this.addEventListener(eventName, callback);
    } else {
        this.addEventListener(eventName, function(event) {
            const target = event.target.closest(selector);
            if (target && this.contains(target)) {
                callback.call(target, event);
            }
        });
    }
    return this;
};

Element.prototype.trigger = function(eventName, data = {}) {
    const event = new CustomEvent(eventName, {
        detail: data,
        bubbles: true,
        cancelable: true
    });
    this.dispatchEvent(event);
    return this;
};
Document.prototype.on = Element.prototype.on;
Document.prototype.trigger = Element.prototype.trigger;

document.addEventListener(
    "alpine:init",
    () => {
        const modules = import.meta.glob("./plugins/**/*.js", { eager: true });

        for (const path in modules) {
            window.Alpine.plugin(modules[path].default);
        }
        window.Alpine.plugin(collapse);
        window.Alpine.plugin(anchor);
    },
    { once: true },
);
