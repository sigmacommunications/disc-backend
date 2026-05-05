<script>
    const preloaderShownAt = Date.now();

    window.addEventListener('load', function() {
        const hide = () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'none';
            }
        };

        const elapsed = Date.now() - preloaderShownAt;
        const minShow = 900; // ms
        const remaining = Math.max(minShow - elapsed, 0);

        setTimeout(hide, remaining);
    });
</script>
