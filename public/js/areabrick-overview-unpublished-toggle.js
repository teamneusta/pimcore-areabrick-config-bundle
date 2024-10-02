document.addEventListener("DOMContentLoaded", function () {

    document/*.getElementById(this.tabId)*/.addEventListener('click', event => {
        const el = event.target.closest('#neusta_areabrick_config .accordion');
        if (el) {
            el.classList.toggle("active");
            var panel = el.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        }
    });
});


