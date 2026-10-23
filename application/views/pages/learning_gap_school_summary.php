<link rel="stylesheet" href="<?= base_url('assets/css/learning-gap-records.css'); ?>?v=<?= filemtime(FCPATH . 'assets/css/learning-gap-records.css'); ?>">
<style>
    .lg-summary-theme{--records-blue:#0038a8;--records-line:#d7e0ee;--records-muted:#647487;color:#1d2e40}
    .lg-summary-theme .lg-records-header{position:relative;overflow:hidden;padding:34px 36px;border-radius:20px;background:linear-gradient(125deg,#082b4c,#0038a8);box-shadow:0 16px 36px rgba(18,63,99,.20)}
    .lg-summary-theme .lg-records-header:before{position:absolute;inset:0 auto 0 0;width:6px;background:linear-gradient(to bottom,#0038a8 0 40%,#f0aa20 40% 60%,#ce1126 60% 100%);content:''}
    .lg-summary-theme .lg-records-header:after{position:absolute;right:-90px;bottom:-180px;width:320px;height:320px;border:40px solid rgba(255,255,255,.12);border-radius:50%;content:''}
    .lg-summary-theme .lg-records-header>div{position:relative;z-index:1}.lg-summary-theme .records-eyebrow{color:#ffe09a}.lg-summary-theme .lg-records-header h1{font-size:30px;letter-spacing:-.02em}
    .lg-summary-theme .lg-records-card{border:0;border-radius:16px;box-shadow:0 8px 22px rgba(18,63,99,.07)}
    .lg-summary-theme .records-filter-card{padding:24px}.lg-summary-theme .lg-records-tools{padding:22px 26px;background:#fbfdfe;border-bottom-color:#d7e0ee}
    .lg-summary-theme h2{color:#082b4c}.lg-summary-theme .record-filter label{color:#1d2e40}
    .lg-summary-theme .record-filter .custom-select{min-height:40px;border-color:#c9d9e4;border-radius:8px}.lg-summary-theme .record-filter .custom-select:focus{border-color:#0038a8;box-shadow:0 0 0 3px rgba(0,56,168,.14)}
    .lg-summary-theme .btn-primary{border-color:#0038a8;background:#0038a8}.lg-summary-theme .btn-primary:hover{border-color:#082b4c;background:#082b4c}.lg-summary-theme .btn-outline-primary{border-color:#0038a8;color:#0038a8}.lg-summary-theme .btn-outline-primary:hover{color:#fff;background:#0038a8}
    .lg-summary-theme table thead th{padding:14px 18px;border-top:0;border-bottom:1px solid #d7e0ee;background:#edf3ff;color:#405a78;font-size:11px;letter-spacing:.04em;text-transform:uppercase}
    .lg-summary-theme table tbody th,.lg-summary-theme table tbody td{padding:16px 18px;border-top:1px solid #edf2f5;vertical-align:middle}.lg-summary-theme table tbody tr:hover{background:#f8fbff}.lg-summary-theme table tbody th{color:#082b4c}
    .lg-summary-theme :is(a,button,summary,select,input,[tabindex]):focus-visible{outline:3px solid #0038a8;outline-offset:3px}
    @media(max-width:575px){.lg-summary-theme .lg-records-header{padding:25px 23px}.lg-summary-theme .lg-records-header h1{font-size:24px}.lg-summary-theme .records-filter-card{padding:18px}.lg-summary-theme .lg-records-tools{padding:18px}}
</style>
<div class="lg-records lg-summary-theme">
    <header class="lg-records-header"><div><span class="records-eyebrow"><?= $is_region ? 'Regional' : 'Division'; ?> summary</span><h1>Learning Gap Summary</h1><p>Filipino learning competencies with gaps and the number of division summaries reporting each one.</p></div></header>
    <section class="lg-records-card records-filter-card" aria-label="Grade level filter">
        <form method="get" action="<?= base_url('Pages/learning_gap_school_summary'); ?>" class="record-filter">
            <div class="record-filter-field"><label for="summary-grade">Grade level</label><select name="grade_level" id="summary-grade" class="custom-select"><option value="">All grade levels</option>
            <?php if ($grade_filter !== '' && !in_array($grade_filter, $grade_options, true)) $grade_options[] = $grade_filter; ?>
            <?php foreach ($grade_options as $grade): ?><option value="<?= html_escape($grade); ?>" <?= $grade_filter === $grade ? 'selected' : ''; ?>><?= html_escape($grade); ?></option><?php endforeach; ?>
            </select></div>
            <div class="record-filter-actions"><button class="btn btn-primary" type="submit">Apply filter</button><?php if ($grade_filter !== ''): ?><a class="btn btn-outline-secondary" href="<?= base_url('Pages/learning_gap_school_summary'); ?>">Clear filter</a><?php endif; ?></div>
        </form>
    </section>
    <section class="lg-records-card" aria-labelledby="division-summary-title">
        <div class="lg-records-tools"><h2 id="division-summary-title">Competencies with Learning Gap</h2><p><?= number_format(count($competency_rows)); ?> competencies · <?= number_format($reporting_division_count); ?> reporting divisions · <?= $grade_filter !== '' ? html_escape($grade_filter) : 'All grade levels'; ?></p><p>Each division is counted once per competency, grade, and learning area, across all terms.</p></div>
        <div class="table-responsive" tabindex="0" role="region" aria-label="Competencies and reporting division counts">
            <table class="table mb-0"><thead><tr><th scope="col">Competencies with Learning Gap</th><th scope="col" class="text-right">Reporting Divisions</th><th scope="col">Action</th></tr></thead><tbody>
            <?php if (empty($competency_rows)): ?><tr><td colspan="3" class="records-empty">No competencies found<?= $grade_filter !== '' ? ' for the selected grade level' : ' within your assigned scope'; ?>.</td></tr><?php endif; ?>
            <?php foreach ($competency_rows as $competency):
                $details_url = base_url('Pages/learning_gap_records') . '?' . http_build_query(array(
                    'grade_level' => $competency['grade'],
                    'learning_area' => $competency['area'],
                    'competency' => $competency['text']
                ), '', '&', PHP_QUERY_RFC3986);
            ?><tr><th scope="row"><?= html_escape($competency['text']); ?><small class="d-block text-muted"><?= html_escape($competency['grade'] . ' · ' . $competency['area']); ?></small></th><td class="text-right"><strong><?= number_format($competency['division_count']); ?></strong></td><td><a class="btn btn-sm btn-outline-primary" href="<?= html_escape($details_url); ?>">View details<span class="sr-only"> for <?= html_escape($competency['text']); ?></span></a></td></tr><?php endforeach; ?>
            </tbody></table>
        </div>
    </section>
</div>
