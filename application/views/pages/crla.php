<?php
$totals = array('learners_assessed' => 0, 'low_emerging' => 0, 'high_emerging' => 0, 'developing' => 0, 'transitioning' => 0, 'at_grade_level' => 0);
foreach ($records as $record) {
    foreach ($totals as $field => $unused) {
        $totals[$field] += (int) $record->$field;
    }
}
?>
<style>
    .reading-page{color:#38252b;padding:12px 0 32px}.reading-hero{margin:8px 0 18px;padding:24px 28px;border-radius:15px;color:#fff;background:linear-gradient(120deg,#3b0718,#922c43)}.reading-hero h1{margin:0 0 6px;color:#fff;font-size:24px}.reading-hero p{margin:0;color:#f1dce1}.reading-card{overflow:hidden;margin-bottom:18px;border:1px solid #ead7dc;border-radius:13px;background:#fff;box-shadow:0 5px 16px rgba(59,7,24,.045)}.reading-card-head{padding:15px 18px;border-bottom:1px solid #f0e4e7;background:#fdf9fa}.reading-card-head h2{margin:0;color:#3b0718;font-size:16px;font-weight:700}.reading-card-head p{margin:4px 0 0;color:#786971;font-size:12px}.reading-card-body{padding:18px}.reading-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}.reading-grid .form-group{margin:0}.reading-page label{display:block;margin-bottom:5px;font-size:12px;font-weight:700}.reading-page .form-control{height:39px;border-color:#dfcbd1;border-radius:7px}.reading-page .btn-primary{border-color:#922c43;background:#922c43}.reading-metrics{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:18px}.reading-metric{padding:15px;border:1px solid #ead7dc;border-radius:11px;background:#fff}.reading-metric span{display:block;color:#786971;font-size:10px;font-weight:800;text-transform:uppercase}.reading-metric strong{display:block;margin-top:6px;color:#3b0718;font-size:23px}.reading-table{min-width:900px;margin:0}.reading-table th{background:#fbf4f5;color:#70545d;font-size:10px;text-transform:uppercase;white-space:nowrap}.reading-table td,.reading-table th{padding:10px 12px;vertical-align:middle}.reading-count{text-align:right;font-variant-numeric:tabular-nums}.reading-actions{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-top:15px;padding-top:14px;border-top:1px solid #f0e4e7}.reading-muted{color:#786971;font-size:12px}
    @media(max-width:767px){.reading-grid,.reading-metrics{grid-template-columns:repeat(2,minmax(0,1fr))}.reading-hero{padding:20px}}
    @media(max-width:480px){.reading-grid{grid-template-columns:1fr}.reading-actions{align-items:stretch;flex-direction:column}.reading-actions .btn{width:100%}}
</style>
<div class="container-fluid reading-page">
    <header class="reading-hero"><h1>Comprehensive Rapid Literacy Assessment</h1><p>Record aggregate CRLA reading profiles for your division for Grades 1–3 by language and assessment period.</p></header>
    <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success"><?= html_escape($this->session->flashdata('success')); ?></div><?php endif; ?>
    <?php if ($this->session->flashdata('danger')): ?><div class="alert alert-danger"><?= $this->session->flashdata('danger'); ?></div><?php endif; ?>

    <section class="reading-card">
        <div class="reading-card-head"><h2>Default division school year · <?= html_escape($division_name); ?></h2><p>The selected year applies to new division summaries and the saved results below.</p></div>
        <div class="reading-card-body">
            <form method="post" action="<?= base_url('Pages/crla_setup_sy'); ?>" class="reading-actions" style="justify-content:flex-start;border:0;padding:0;margin:0">
                <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
                <div class="form-group mb-0"><label for="crla-sy">School year</label><select id="crla-sy" name="school_year" class="form-control" required><?php foreach ($school_year_options as $year => $label): ?><option value="<?= (int) $year; ?>" <?= (int) $year === (int) $selected_sy ? 'selected' : ''; ?>><?= html_escape($label); ?></option><?php endforeach; ?></select></div>
                <button type="submit" class="btn btn-outline-primary">Save default year</button>
                <span class="reading-muted">Active: <?= html_escape($school_year); ?></span>
            </form>
        </div>
    </section>

    <section class="reading-metrics" aria-label="CRLA results summary">
        <div class="reading-metric"><span>Entries</span><strong><?= number_format(count($records)); ?></strong></div>
        <div class="reading-metric"><span>Learners assessed</span><strong><?= number_format($totals['learners_assessed']); ?></strong></div>
        <div class="reading-metric"><span>Low emerging</span><strong><?= number_format($totals['low_emerging']); ?></strong></div>
        <div class="reading-metric"><span>At grade level</span><strong><?= number_format($totals['at_grade_level']); ?></strong></div>
    </section>

    <section class="reading-card">
        <div class="reading-card-head"><h2>Enter CRLA results</h2><p>Use one aggregate entry for each grade, language, and assessment period. Profile counts must not exceed learners assessed.</p></div>
        <div class="reading-card-body">
            <form method="post" action="<?= base_url('Pages/crla_save'); ?>">
                <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><?php endif; ?>
                <div class="reading-grid">
                    <div class="form-group"><label for="crla-grade">Grade level</label><select id="crla-grade" name="grade_level" class="form-control" required><option value="1">Grade 1</option><option value="2">Grade 2</option><option value="3">Grade 3</option></select></div>
                    <div class="form-group"><label for="crla-language">Assessment language</label><select id="crla-language" name="language" class="form-control" required></select></div>
                    <div class="form-group"><label for="crla-period">Assessment period</label><select id="crla-period" name="assessment_period" class="form-control" required><option value="BOSY">Beginning of School Year (BOSY)</option><option value="EOSY">End of School Year (EOSY)</option></select></div>
                    <?php foreach (array('learners_assessed' => 'Learners assessed', 'low_emerging' => 'Low emerging', 'high_emerging' => 'High emerging', 'developing' => 'Developing', 'transitioning' => 'Transitioning', 'at_grade_level' => 'At grade level') as $field => $label): ?>
                        <div class="form-group"><label for="crla-<?= $field; ?>"><?= $label; ?></label><input id="crla-<?= $field; ?>" name="<?= $field; ?>" type="number" class="form-control" min="0" step="1" value="0" required></div>
                    <?php endforeach; ?>
                </div>
                <div class="reading-actions"><span class="reading-muted">Language options follow the selected grade. Saving the same grade/language/period replaces its existing entry.</span><button class="btn btn-primary" type="submit">Save results</button></div>
            </form>
        </div>
    </section>

    <section class="reading-card">
        <div class="reading-card-head"><h2>Saved results · <?= html_escape($school_year); ?></h2></div>
        <div class="table-responsive"><table class="table reading-table">
            <thead><tr><th>Grade</th><th>Language</th><th>Assessment period</th><th class="reading-count">Assessed</th><th class="reading-count">Low emerging</th><th class="reading-count">High emerging</th><th class="reading-count">Developing</th><th class="reading-count">Transitioning</th><th class="reading-count">At grade level</th></tr></thead>
            <tbody>
                <?php if (empty($records)): ?><tr><td colspan="9" class="text-center reading-muted">No CRLA division summary has been entered for this school year.</td></tr>
                <?php else: foreach ($records as $record): ?><tr><td>Grade <?= (int) $record->grade_level; ?></td><td><?= html_escape($record->language); ?></td><td><?= $record->assessment_period === 'BOSY' ? 'Beginning of School Year' : 'End of School Year'; ?></td><?php foreach (array('learners_assessed', 'low_emerging', 'high_emerging', 'developing', 'transitioning', 'at_grade_level') as $field): ?><td class="reading-count"><?= number_format((int) $record->$field); ?></td><?php endforeach; ?></tr><?php endforeach; endif; ?>
            </tbody>
        </table></div>
    </section>
</div>
<script>
(function () {
    var grade = document.getElementById('crla-grade');
    var language = document.getElementById('crla-language');
    function updateLanguages() {
        var level = parseInt(grade.value, 10);
        var options = [{value: 'Mother Tongue (L1)', label: 'Mother Tongue (L1)'}];
        if (level >= 2) options.push({value: 'Filipino', label: 'Filipino'});
        if (level >= 3) options.push({value: 'English', label: 'English'});
        var previous = language.value;
        language.innerHTML = '';
        options.forEach(function (option) {
            var item = document.createElement('option');
            item.value = option.value;
            item.textContent = option.label;
            language.appendChild(item);
        });
        if (options.some(function (option) { return option.value === previous; })) language.value = previous;
    }
    grade.addEventListener('change', updateLanguages);
    updateLanguages();
}());
</script>
