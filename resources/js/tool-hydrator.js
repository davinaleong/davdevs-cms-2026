const parseJson = (raw, fallback) => {
    try {
        return JSON.parse(raw ?? 'null') ?? fallback;
    } catch {
        return fallback;
    }
};

const showFallback = (element, message) => {
    const fallback = element.querySelector('[data-tool-fallback]');

    if (! fallback) {
        return;
    }

    fallback.textContent = message;
    fallback.classList.remove('hidden');
};

const hydrateTool = async (element) => {
    const bundlePath = element.dataset.bundlePath;
    const componentName = element.dataset.componentName;
    const props = parseJson(element.dataset.toolProps, {});

    if (! bundlePath) {
        showFallback(element, 'Tool bundle path is missing.');

        return;
    }

    try {
        const module = await import(/* @vite-ignore */ bundlePath);
        const renderer = module.default ?? module[componentName] ?? module.render;

        if (typeof renderer !== 'function') {
            showFallback(element, 'Tool renderer was not found in bundle.');

            return;
        }

        await renderer(element, props);
    } catch (error) {
        showFallback(element, 'Unable to load this tool right now.');
        console.error(error);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-tool-mount]').forEach((element) => {
        hydrateTool(element);
    });

    document.querySelectorAll('[data-reveal-answer]').forEach((button) => {
        button.addEventListener('click', () => {
            const answer = button.closest('[data-joke-card]')?.querySelector('[data-joke-answer]');

            if (! answer) {
                return;
            }

            button.disabled = true;

            window.setTimeout(() => {
                answer.classList.remove('hidden');
                button.classList.add('hidden');
            }, 700);
        });
    });
});
