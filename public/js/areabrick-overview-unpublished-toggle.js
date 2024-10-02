document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', event => {
        const el = event.target.closest('#neusta_areabrick_config .accordion');

        if (el) {
            el.querySelectorAll('button, ul').forEach(el => el.classList.toggle('active'));
        }
    });
}, { once: true });
