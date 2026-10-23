<?php
$totals = array('learners_assessed' => 0, 'independent' => 0, 'instructional' => 0, 'frustration' => 0, 'non_reader' => 0);
foreach ($records as $record) {
    foreach ($totals as $field => $unused) {
        $totals[$field] += (int) $record->$field;
    }
}
?>
<style>
    .reading-page{--reading-navy:#082b4c;--reading-blue:#0038a8;--reading-sky:#edf3ff;--reading-line:#d7e0ee;--reading-ink:#1d2e40;--reading-muted:#647487;--reading-gold:#f0aa20;--reading-red:#ce1126;color:var(--reading-ink);padding:12px 0 32px}
    .reading-hero{position:relative;overflow:hidden;margin:8px 0 22px;padding:34px 36px;border-radius:20px;color:#fff;background:linear-gradient(125deg,var(--reading-navy),var(--reading-blue));box-shadow:0 16px 36px rgba(18,63,99,.20)}
    .reading-hero:before{position:absolute;inset:0 auto 0 0;width:6px;background:linear-gradient(to bottom,var(--reading-blue) 0 40%,var(--reading-gold) 40% 60%,var(--reading-red) 60% 100%);content:''}
    .reading-hero:after{position:absolute;right:-90px;bottom:-180px;width:320px;height:320px;border:40px solid rgba(255,255,255,.12);border-radius:50%;content:''}
    .reading-hero h1,.reading-hero p{position:relative;z-index:1}.reading-hero h1{margin:0 0 7px;color:#fff;font-size:30px;font-weight:700}.reading-hero p{margin:0;color:#dceefa;font-size:15px;line-height:1.55}
    .reading-card{overflow:hidden;margin-bottom:24px;border:1px solid var(--reading-line);border-radius:16px;background:#fff;box-shadow:0 8px 22px rgba(18,63,99,.07)}.reading-card-head{padding:22px 26px;border-bottom:1px solid var(--reading-line);background:#fbfdfe}.reading-card-head h2{margin:0;color:var(--reading-navy);font-size:17px;font-weight:700}.reading-card-head p{margin:4px 0 0;color:var(--reading-muted);font-size:12px}.reading-card-body{padding:24px 26px}
    .reading-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}.reading-grid .form-group{margin:0}.reading-page label{display:block;margin-bottom:5px;color:var(--reading-ink);font-size:12px;font-weight:700}.reading-page .form-control{height:39px;border-color:var(--reading-line);border-radius:7px}.reading-page .btn-primary{border-color:var(--reading-blue);background:var(--reading-blue)}.reading-page .btn-primary:hover{border-color:var(--reading-navy);background:var(--reading-navy)}.reading-page .btn-outline-primary{border-color:var(--reading-blue);color:var(--reading-blue)}.reading-page .btn-outline-primary:hover{color:#fff;background:var(--reading-blue)}
    .reading-metrics{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:24px}.reading-metric{padding:18px;border:1px solid var(--reading-line);border-radius:14px;background:#fff;box-shadow:0 5px 16px rgba(18,63,99,.05)}.reading-metric span{display:block;color:var(--reading-muted);font-size:10px;font-weight:800;text-transform:uppercase}.reading-metric strong{display:block;margin-top:6px;color:var(--reading-navy);font-size:25px}.reading-table{min-width:760px;margin:0}.reading-table th{background:#edf3ff;color:#405a78;font-size:10px;text-transform:uppercase;white-space:nowrap}.reading-table td,.reading-table th{padding:10px 12px;vertical-align:middle}.reading-table tbody tr:hover{background:#f8fbff}.reading-count{text-align:right;font-variant-numeric:tabular-nums}.reading-actions{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-top:15px;padding-top:14px;border-top:1px solid var(--reading-line)}.reading-muted{color:var(--reading-muted);font-size:12px}
    @media(max-width:767px){.reading-grid,.reading-metrics{grid-template-columns:repeat(2,minmax(0,1fr))}.reading-hero{align-items:flex-start;padding:26px;border-radius:16px}.reading-hero h1{font-size:24px}.reading-card-head,.reading-card-body{padding:18px}.reading-grid .form-group{min-width:0}}
    @media(max-width:480px){.reading-grid{grid-template-columns:1fr}.reading-actions{align-items:stretch;flex-direction:column}.reading-actions .btn{width:100%}}
</style>
<div class="container-fluid reading-page">
    <header class="reading-hero">
        <h1>Philippine Informal Reading Inventory</h1>
        <p>Encode aggregate reading results for your division for Grades 4–10 by language and assessment period.</p>
    </header>
    <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success"><?= html_escape($this->session->flashdata('success')); ?></div><?php endif; ?>
    <?php if ($this->session->flashdata('danger')): ?><div class="alert alert-danger"><?= $this->session->flashdata('danger'); ?></div><?php endif; ?>

    <section class="reading-card">
        <div class="reading-card-head"><h2>Default division school year · <?= html_escape($division_name); ?></h2><p>The selected year applies to new division summaries and the saved results below.</p></div>
        <div class="reading-card-body">
            <form method="post" action="<?= base_url('Pages/phil_iri_setup_sy'); ?>" class="reading-actions" style="justify-content:flex-start;border:0;padding:0;margin:0">
                <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
                <div class="form-group mb-0"><label for="phil-sy">School year</label><select id="phil-sy" name="school_year" class="form-control" required><?php foreach ($school_year_options as $year => $label): ?><option value="<?= (int) $year; ?>" <?= (int) $year === (int) $selected_sy ? 'selected' : ''; ?>><?= html_escape($label); ?></option><?php endforeach; ?></select></div>
                <button type="submit" class="btn btn-outline-primary">Save default year</button>
                <span class="reading-muted">Active: <?= html_escape($school_year); ?></span>
            </form>
        </div>
    </section>

    <section class="reading-metrics" aria-label="Phil-IRI results summary">
        <div class="reading-metric"><span>Entries</span><strong><?= number_format(count($records)); ?></strong></div>
        <div class="reading-metric"><span>Learners assessed</span><strong><?= number_format($totals['learners_assessed']); ?></strong></div>
        <div class="reading-metric"><span>Independent readers</span><strong><?= number_format($totals['independent']); ?></strong></div>
        <div class="reading-metric"><span>Needs support</span><strong><?= number_format($totals['instructional'] + $totals['frustration'] + $totals['non_reader']); ?></strong></div>
    </section>

    <section class="reading-card">
        <div class="reading-card-head"><h2>Enter reading results</h2><p>Use aggregate learner counts for one grade, language, and assessment period.</p></div>
        <div class="reading-card-body">
            <form method="post" action="<?= base_url('Pages/phil_iri_save'); ?>">
                <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
                <div class="reading-grid">
                    <div class="form-group"><label for="phil-grade">Grade level</label><select id="phil-grade" name="grade_level" class="form-control" required><?php foreach ($grades as $grade): ?><option value="<?= (int) $grade; ?>">Grade <?= (int) $grade; ?></option><?php endforeach; ?></select></div>
                    <div class="form-group"><label for="phil-language">Language</label><select id="phil-language" name="language" class="form-control" required><option>English</option><option>Filipino</option></select></div>
                    <div class="form-group"><label for="phil-period">Assessment period</label><select id="phil-period" name="assessment_period" class="form-control" required><option>Pre-test</option><option>Post-test</option></select></div>
                    <?php foreach (array('learners_assessed' => 'Learners assessed', 'independent' => 'Independent', 'instructional' => 'Instructional', 'frustration' => 'Frustration', 'non_reader' => 'Non-reader') as $field => $label): ?>
                        <div class="form-group"><label for="phil-<?= $field; ?>"><?= $label; ?></label><input id="phil-<?= $field; ?>" name="<?= $field; ?>" type="number" class="form-control" min="0" step="1" value="0" required></div>
                    <?php endforeach; ?>
                </div>
                <div class="reading-actions"><span class="reading-muted">Reading-level totals must not exceed learners assessed. Saving the same grade/language/period replaces its existing entry.</span><button class="btn btn-primary" type="submit">Save results</button></div>
            </form>
        </div>
    </section>

    <section class="reading-card">
        <div class="reading-card-head"><h2>Saved results · <?= html_escape($school_year); ?></h2></div>
        <div class="table-responsive"><table class="table reading-table">
            <thead><tr><th>Grade</th><th>Language</th><th>Assessment</th><th class="reading-count">Assessed</th><th class="reading-count">Independent</th><th class="reading-count">Instructional</th><th class="reading-count">Frustration</th><th class="reading-count">Non-reader</th></tr></thead>
            <tbody>
                <?php if (empty($records)): ?><tr><td colspan="8" class="text-center reading-muted">No Phil-IRI division summary has been entered for this school year.</td></tr>
                <?php else: foreach ($records as $record): ?><tr><td>Grade <?= (int) $record->grade_level; ?></td><td><?= html_escape($record->language); ?></td><td><?= html_escape($record->assessment_period); ?></td><?php foreach (array('learners_assessed', 'independent', 'instructional', 'frustration', 'non_reader') as $field): ?><td class="reading-count"><?= number_format((int) $record->$field); ?></td><?php endforeach; ?></tr><?php endforeach; endif; ?>
            </tbody>
        </table></div>
    </section>
</div>
