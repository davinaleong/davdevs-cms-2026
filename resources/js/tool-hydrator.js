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
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.querySelectorAll('[data-tool-mount]').forEach((element) => {
        hydrateTool(element);
    });

    document.querySelectorAll('[data-like-toggle]').forEach((button) => {
        button.addEventListener('click', async () => {
            const postSlug = button.dataset.postSlug;
            const countElement = document.querySelector('[data-like-count]');

            if (!postSlug || !csrfToken) {
                return;
            }

            button.disabled = true;

            try {
                const response = await fetch(`/api/posts/${postSlug}/likes/toggle`, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                if (!response.ok) {
                    return;
                }

                const payload = await response.json();

                if (countElement) {
                    countElement.textContent = String(payload.data.likes_count ?? 0);
                }

                button.textContent = payload.data.liked ? 'Unlike' : 'Like';
            } finally {
                button.disabled = false;
            }
        });
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
