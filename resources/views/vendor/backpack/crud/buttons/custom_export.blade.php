{{-- Custom export button injected by ExportOperation --}}
<style>
    .custom-export-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .custom-export-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 31px;
        padding: 4px 12px;
        background: #fff;
        border: 1px solid #d3dde4;
        border-radius: 4px;
        color: #4d565e;
        font-size: 13px;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s;
        line-height: 1.4;
        white-space: nowrap;
    }
    .custom-export-btn:hover {
        background: #f6f8fa;
        color: #2b333b;
        text-decoration: none;
    }
    .custom-export-btn i { font-size: 14px; }

    .custom-export-btn .ce-state { display: none; align-items: center; gap: 6px; }
    .custom-export-btn.is-idle  .ce-idle  { display: inline-flex; }
    .custom-export-btn.is-busy  .ce-busy  { display: inline-flex; }
    .custom-export-btn.is-ready .ce-ready { display: inline-flex; color: #28a745; }
    .custom-export-btn.is-ready { border-color: #28a745; }

    .ce-bar {
        display: inline-block;
        width: 90px;
        height: 6px;
        background: #e0e6eb;
        border-radius: 3px;
        overflow: hidden;
        vertical-align: middle;
    }
    .ce-fill {
        display: block;
        height: 100%;
        width: 0%;
        background: #28a745;
        transition: width .3s ease;
    }
    .ce-percent {
        font-variant-numeric: tabular-nums;
        font-size: 12px;
        min-width: 36px;
        text-align: center;
        color: #4d565e;
    }
    .ce-cancel {
        color: #dc3545;
        text-decoration: none;
        font-size: 12px;
        cursor: pointer;
        padding: 0 4px;
    }
    .ce-cancel:hover { color: #b02a37; text-decoration: none; }

    .custom-export-dismiss,
    .custom-export-history {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border: 1px solid #d3dde4;
        border-radius: 4px;
        background: #fff;
        color: #6c757d;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        line-height: 1;
    }
    .custom-export-dismiss { display: none; }
    .custom-export-wrapper.is-ready .custom-export-dismiss { display: inline-flex; }
    .custom-export-dismiss:hover {
        background: #f6f8fa;
        color: #dc3545;
        text-decoration: none;
    }
    .custom-export-history:hover {
        background: #f6f8fa;
        color: #0d6efd;
        text-decoration: none;
    }

    /* History modal */
    .ce-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10500;
        padding: 20px;
    }
    .ce-modal-backdrop.is-open { display: flex; }
    .ce-modal {
        background: #fff;
        border-radius: 6px;
        width: 100%;
        max-width: 820px;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 40px rgba(0, 0, 0, .25);
        overflow: hidden;
    }
    .ce-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid #e6e9ec;
    }
    .ce-modal-header h4 { margin: 0; font-size: 16px; }
    .ce-modal-close {
        background: transparent;
        border: 0;
        font-size: 22px;
        color: #6c757d;
        cursor: pointer;
        line-height: 1;
    }
    .ce-modal-body {
        padding: 0;
        overflow-y: auto;
        flex: 1;
    }
    .ce-empty {
        padding: 40px 20px;
        text-align: center;
        color: #6c757d;
        font-size: 14px;
    }
    .ce-history-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .ce-history-table th,
    .ce-history-table td {
        padding: 10px 12px;
        text-align: right;
        border-bottom: 1px solid #f0f2f4;
        vertical-align: middle;
    }
    .ce-history-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #4d565e;
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .ce-history-table tbody tr:hover { background: #fafbfc; }
    .ce-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        line-height: 1.6;
        white-space: nowrap;
    }
    .ce-badge.completed { background: #d4edda; color: #155724; }
    .ce-badge.processing,
    .ce-badge.queued    { background: #d1ecf1; color: #0c5460; }
    .ce-badge.failed    { background: #f8d7da; color: #721c24; }
    .ce-badge.cancelled { background: #e2e3e5; color: #383d41; }
    .ce-row-actions { white-space: nowrap; display: inline-flex; gap: 6px; }
    .ce-row-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border: 1px solid #d3dde4;
        border-radius: 4px;
        background: #fff;
        color: #4d565e;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
        line-height: 1.4;
    }
    .ce-row-btn.download { color: #28a745; border-color: #b6e2c1; }
    .ce-row-btn.download:hover { background: #e8f6ec; color: #1e7e34; }
    .ce-row-btn.delete { color: #dc3545; border-color: #f1c0c4; }
    .ce-row-btn.delete:hover { background: #fdecee; color: #b02a37; }
    .ce-row-btn:hover { text-decoration: none; }
    .ce-loading { padding: 30px; text-align: center; color: #6c757d; }
</style>

<span class="custom-export-wrapper is-idle" id="customExportWrapper">
    <a href="javascript:void(0)"
       id="customExportButton"
       class="custom-export-btn is-idle"
       title="خروجی اکسل"
       data-start-url="{{ url($crud->route.'/export/start') }}"
       data-active-url="{{ url($crud->route.'/export/active') }}"
       data-progress-url="{{ url($crud->route.'/export/progress') }}"
       data-cancel-url="{{ url($crud->route.'/export/cancel') }}"
       data-download-url="{{ url($crud->route.'/export/download') }}"
       data-history-url="{{ url($crud->route.'/export/history') }}"
       data-delete-url="{{ url($crud->route.'/export') }}"
       data-csrf="{{ csrf_token() }}"
       data-crud-key="{{ basename($crud->route) }}">

        <span class="ce-state ce-idle">
            <i class="la la-file-excel-o"></i>
            <span>خروجی اکسل</span>
        </span>

        <span class="ce-state ce-busy">
            <span class="ce-bar"><span class="ce-fill"></span></span>
            <span class="ce-percent">0%</span>
            <span class="ce-cancel" data-action="cancel">
                <i class="la la-times-circle"></i> لغو
            </span>
        </span>

        <span class="ce-state ce-ready">
            <i class="la la-download"></i>
            <span>دانلود فایل</span>
        </span>
    </a>

    <a href="javascript:void(0)"
       class="custom-export-dismiss"
       id="customExportDismiss"
       title="شروع خروجی جدید">
        <i class="la la-times"></i>
    </a>

    <a href="javascript:void(0)"
       class="custom-export-history"
       id="customExportHistoryBtn"
       title="تاریخچه خروجی‌ها">
        <i class="la la-history"></i>
    </a>
</span>

{{-- History modal --}}
<div class="ce-modal-backdrop" id="customExportHistoryModal">
    <div class="ce-modal">
        <div class="ce-modal-header">
            <h4><i class="la la-history"></i> تاریخچه خروجی‌ها</h4>
            <button type="button" class="ce-modal-close" data-action="close-history">&times;</button>
        </div>
        <div class="ce-modal-body" id="customExportHistoryBody">
            <div class="ce-loading">در حال بارگذاری…</div>
        </div>
    </div>
</div>

@push('after_scripts')
<script>
(function(){
    if (window.__customExport) return;

    var wrapper = document.getElementById('customExportWrapper');
    var btn = document.getElementById('customExportButton');
    var dismissBtn = document.getElementById('customExportDismiss');
    var historyBtn = document.getElementById('customExportHistoryBtn');
    var modal = document.getElementById('customExportHistoryModal');
    var modalBody = document.getElementById('customExportHistoryBody');
    if (!btn) return;

    var startUrl    = btn.dataset.startUrl;
    var activeUrl   = btn.dataset.activeUrl;
    var progressUrl = btn.dataset.progressUrl;
    var cancelUrl   = btn.dataset.cancelUrl;
    var downloadUrl = btn.dataset.downloadUrl;
    var historyUrl  = btn.dataset.historyUrl;
    var deleteUrl   = btn.dataset.deleteUrl;
    var csrf        = btn.dataset.csrf;
    var crudKey     = btn.dataset.crudKey;
    var storageKey  = 'customExport:' + crudKey;

    var fillEl    = btn.querySelector('.ce-fill');
    var percentEl = btn.querySelector('.ce-percent');

    var pollTimer = null;
    var currentJobId = null;

    /* ----- Main button events ----- */
    btn.addEventListener('click', function(e){
        if (e.target.closest('[data-action="cancel"]')) {
            e.preventDefault();
            e.stopPropagation();
            doCancel();
            return;
        }
        if (btn.classList.contains('is-busy')) return;
        if (btn.classList.contains('is-ready') && currentJobId) {
            window.location = downloadUrl + '/' + currentJobId;
            return;
        }
        doStart();
    });

    dismissBtn.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        resetToIdle();
    });

    historyBtn.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        openHistory();
    });

    /* ----- Modal events ----- */
    modal.addEventListener('click', function(e){
        if (e.target === modal || e.target.closest('[data-action="close-history"]')) {
            closeHistory();
            return;
        }
        var dl = e.target.closest('[data-history-action="download"]');
        if (dl) {
            e.preventDefault();
            window.open(downloadUrl + '/' + dl.dataset.jobId, '_blank');
            return;
        }
        var del = e.target.closest('[data-history-action="delete"]');
        if (del) {
            e.preventDefault();
            if (confirm('این خروجی حذف شود؟')) {
                deleteHistoryItem(del.dataset.jobId);
            }
        }
    });

    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && modal.classList.contains('is-open')) {
            closeHistory();
        }
    });

    /* ----- State helpers ----- */
    function setState(state) {
        btn.classList.remove('is-idle', 'is-busy', 'is-ready');
        btn.classList.add('is-' + state);
        wrapper.classList.remove('is-idle', 'is-busy', 'is-ready');
        wrapper.classList.add('is-' + state);
    }
    function setProgress(p) {
        p = Math.max(0, Math.min(100, Math.floor(Number(p) || 0)));
        if (fillEl)    fillEl.style.width = p + '%';
        if (percentEl) percentEl.textContent = p + '%';
    }
    function rememberCompletedJob(id) {
        currentJobId = id;
        try { localStorage.setItem(storageKey, String(id)); } catch(e) {}
    }
    function forgetCompletedJob() {
        currentJobId = null;
        try { localStorage.removeItem(storageKey); } catch(e) {}
    }
    function getRememberedJob() {
        try {
            var v = localStorage.getItem(storageKey);
            return v ? parseInt(v, 10) : null;
        } catch(e) { return null; }
    }
    function resetToIdle() {
        forgetCompletedJob();
        setProgress(0);
        setState('idle');
    }

    /* ----- Polling ----- */
    function startPolling(id) {
        stopPolling();
        currentJobId = id;
        setState('busy');
        poll(id);
        pollTimer = setInterval(function(){ poll(id); }, 2000);
    }
    function stopPolling() {
        if (pollTimer) { clearInterval(pollTimer); pollTimer = null; }
    }
    function poll(id) {
        fetch(progressUrl + '/' + id, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(function(r){ return r.ok ? r.json() : null; })
        .then(function(data){
            if (!data) return;
            setProgress(data.progress);
            if (data.status === 'completed') {
                stopPolling();
                if (data.is_downloadable) {
                    rememberCompletedJob(id);
                    setProgress(100);
                    setState('ready');
                } else {
                    resetToIdle();
                }
            } else if (data.status === 'cancelled') {
                stopPolling();
                resetToIdle();
            } else if (data.status === 'failed') {
                stopPolling();
                resetToIdle();
                alert('خروجی با خطا مواجه شد' + (data.error_message ? ': ' + data.error_message : ''));
            }
        })
        .catch(function(){});
    }

    /* ----- Actions ----- */
    function doStart() {
        var params = window.location.search;
        fetch(startUrl + params, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(function(r){
            return r.json().then(function(data){ return { status: r.status, body: data }; });
        })
        .then(function(res){
            if ((res.status === 200 || res.status === 409) && res.body.job_id) {
                forgetCompletedJob();
                startPolling(res.body.job_id);
            } else {
                alert(res.body.message || 'خطا در شروع خروجی');
            }
        })
        .catch(function(){ alert('خطا در ارتباط با سرور'); });
    }

    function doCancel() {
        if (!currentJobId) return;
        fetch(cancelUrl + '/' + currentJobId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });
    }

    /* ----- History modal ----- */
    function openHistory() {
        modal.classList.add('is-open');
        loadHistory();
    }
    function closeHistory() {
        modal.classList.remove('is-open');
    }

    function escapeHtml(s) {
        if (s === null || s === undefined) return '';
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function loadHistory() {
        modalBody.innerHTML = '<div class="ce-loading">در حال بارگذاری…</div>';
        fetch(historyUrl, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(function(r){ return r.ok ? r.json() : null; })
        .then(function(data){
            if (!data) {
                modalBody.innerHTML = '<div class="ce-empty">خطا در بارگذاری</div>';
                return;
            }
            renderHistory(data.items || []);
        })
        .catch(function(){
            modalBody.innerHTML = '<div class="ce-empty">خطا در ارتباط با سرور</div>';
        });
    }

    function renderHistory(items) {
        if (!items.length) {
            modalBody.innerHTML = '<div class="ce-empty">هنوز خروجی‌ای ثبت نشده است.</div>';
            return;
        }
        var rows = items.map(function(it){
            var actions = '';
            if (it.is_downloadable) {
                actions += '<a href="javascript:void(0)" class="ce-row-btn download" data-history-action="download" data-job-id="' + it.id + '"><i class="la la-download"></i> دانلود</a>';
            }
            // Delete is allowed for any non-active job
            if (it.status !== 'queued' && it.status !== 'processing') {
                actions += '<a href="javascript:void(0)" class="ce-row-btn delete" data-history-action="delete" data-job-id="' + it.id + '"><i class="la la-trash"></i> حذف</a>';
            }

            var fileInfo = it.file_name ? escapeHtml(it.file_name) : '—';
            if (it.file_size_human) {
                fileInfo += ' <small style="color:#6c757d">(' + escapeHtml(it.file_size_human) + ')</small>';
            }

            var rowsInfo = it.total_rows
                ? escapeHtml(it.processed_rows) + ' / ' + escapeHtml(it.total_rows)
                : '—';

            return '<tr>' +
                '<td>' + escapeHtml(it.id) + '</td>' +
                '<td><span class="ce-badge ' + escapeHtml(it.status) + '">' + escapeHtml(it.status_label) + '</span></td>' +
                '<td>' + fileInfo + '</td>' +
                '<td>' + rowsInfo + '</td>' +
                '<td>' + escapeHtml(it.created_at || '—') + '</td>' +
                '<td>' + escapeHtml(it.completed_at || '—') + '</td>' +
                '<td><span class="ce-row-actions">' + actions + '</span></td>' +
                '</tr>';
        }).join('');

        modalBody.innerHTML =
            '<table class="ce-history-table">' +
                '<thead><tr>' +
                    '<th>#</th>' +
                    '<th>وضعیت</th>' +
                    '<th>فایل</th>' +
                    '<th>رکوردها</th>' +
                    '<th>زمان شروع</th>' +
                    '<th>زمان پایان</th>' +
                    '<th>عملیات</th>' +
                '</tr></thead>' +
                '<tbody>' + rows + '</tbody>' +
            '</table>';
    }

    function deleteHistoryItem(jobId) {
        fetch(deleteUrl + '/' + jobId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(function(r){ return r.json().then(function(d){ return { ok: r.ok, body: d }; }); })
        .then(function(res){
            if (!res.ok) {
                alert(res.body.message || 'حذف ممکن نشد');
                return;
            }
            // If the deleted job was the one currently shown as "ready", reset.
            if (parseInt(jobId, 10) === currentJobId) {
                resetToIdle();
            }
            loadHistory();
        })
        .catch(function(){ alert('خطا در ارتباط با سرور'); });
    }

    /* ----- Bootstrap ----- */
    function bootstrap() {
        fetch(activeUrl, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(function(r){ return r.ok ? r.json() : null; })
        .then(function(data){
            if (data && data.has_job) {
                setProgress(data.progress);
                startPolling(data.id);
                return;
            }
            var rememberedId = getRememberedJob();
            if (!rememberedId) return;
            fetch(progressUrl + '/' + rememberedId, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            })
            .then(function(r){ return r.ok ? r.json() : null; })
            .then(function(p){
                if (p && p.status === 'completed' && p.is_downloadable) {
                    currentJobId = rememberedId;
                    setProgress(100);
                    setState('ready');
                } else {
                    forgetCompletedJob();
                }
            })
            .catch(function(){});
        })
        .catch(function(){});
    }

    window.__customExport = {
        start: doStart,
        cancel: doCancel,
        reset: resetToIdle,
        openHistory: openHistory,
        closeHistory: closeHistory
    };
    bootstrap();
})();
</script>
@endpush
