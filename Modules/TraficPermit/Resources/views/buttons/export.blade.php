<a href="{{ url($crud->route.'/export') }}" class="btn btn-primary export-link export-button" data-style="zoom-in">
    <span class="export-label"><i class="la la-file-excel-o"></i> خروجی اکسل</span>
</a>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateExportLink() {
            let exportLink = document.querySelector('a.export-link');
            if (exportLink) {
                let currentUrl = window.location.pathname.replace(/^\//, '').replace(/\//g, '');

                let storageKey = currentUrl + '_list_url';
                let storedUrl = localStorage.getItem(storageKey);

                if (storedUrl) {
                    let url = new URL(storedUrl);
                    let queryParams = url.searchParams.toString();

                    let baseUrl = exportLink.href.split('?')[0];
                    exportLink.href = baseUrl + '?' + queryParams;
                }
            }
        }

        updateExportLink();

        let storageKey = window.location.pathname.replace(/^\//, '').replace(/\//g, '') + '_list_url';
        let lastStoredUrl = localStorage.getItem(storageKey);
        setInterval(function() {
            let currentStoredUrl = localStorage.getItem(storageKey);
            if (currentStoredUrl !== lastStoredUrl) {
                lastStoredUrl = currentStoredUrl;
                updateExportLink();
            }
        }, 1000);

        window.addEventListener('popstate', function () {
            updateExportLink();
        });
    });
</script>
