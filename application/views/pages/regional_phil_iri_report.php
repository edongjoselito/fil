<?php
$levels = array(
    'independent' => array('Independent', '#348455'),
    'instructional' => array('Instructional', '#3988b5'),
    'frustration' => array('Frustration', '#e89535'),
    'non_reader' => array('Non-reader', '#c94c4c'),
);
$labels = array();
$chart_values = array_fill_keys(array_keys($levels), array());
foreach ($groups as $group) {
    $labels[] = 'Grade ' . $group['grade_level'] . ' · ' . $group['language'] . ' · ' . $group['assessment_period'];
    foreach ($levels as $field => $unused) {
        $chart_values[$field][] = $group['learners_assessed'] > 0
            ? round(($group[$field] / $group['learners_assessed']) * 100, 1)
            : 0;
    }
}
?>
<style>
    .report-page{color:#38252b;padding:10px 0 32px}.report-hero{display:flex;justify-content:space-between;align-items:center;gap:20px;margin:8px 0 18px;padding:24px 28px;border-radius:15px;color:#fff;background:linear-gradient(120deg,#3b0718,#922c43)}.report-hero h1{margin:0 0 6px;color:#fff;font-size:23px}.report-hero p{margin:0;color:#f1dce1}.report-hero .year{font-size:19px;font-weight:800}.report-card{overflow:hidden;margin-bottom:18px;border:1px solid #ead7dc;border-radius:13px;background:#fff;box-shadow:0 5px 16px rgba(59,7,24,.045)}.report-card-head{padding:15px 18px;border-bottom:1px solid #f0e4e7;background:#fdf9fa}.report-card-head h2{margin:0;color:#3b0718;font-size:16px;font-weight:700}.report-card-head p{margin:4px 0 0;color:#786971;font-size:12px}.report-filter{display:flex;align-items:end;gap:10px;flex-wrap:wrap;padding:16px 18px}.report-filter .form-group{min-width:160px;margin:0}.report-page label{display:block;margin-bottom:5px;font-size:11px;font-weight:700}.report-page .form-control{height:38px;border-color:#dfcbd1;border-radius:7px}.report-page .btn-primary{border-color:#922c43;background:#922c43}.report-metrics{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:18px}.report-metric{padding:15px;border:1px solid #ead7dc;border-radius:11px;background:#fff}.report-metric span{display:block;color:#786971;font-size:10px;font-weight:800;text-transform:uppercase}.report-metric strong{display:block;margin-top:6px;color:#3b0718;font-size:23px}.report-table{min-width:780px;margin:0}.report-table th{background:#fbf4f5;color:#70545d;font-size:10px;text-transform:uppercase;white-space:nowrap}.report-table td,.report-table th{padding:10px 12px;vertical-align:middle}.report-num{text-align:right;font-variant-numeric:tabular-nums}.report-chart{height:350px;padding:18px}.report-empty{padding:25px!important;text-align:center;color:#786971}.report-school{min-width:200px}
    @media(max-width:767px){.report-hero{align-items:flex-start;flex-direction:column;padding:20px}.report-metrics{grid-template-columns:repeat(2,minmax(0,1fr))}.report-filter{align-items:stretch;flex-direction:column}.report-filter .form-group{width:100%}.report-chart{height:300px}}
    @media print{.no-print{display:none!important}.report-page{padding:0}.report-hero{padding:12px 18px;print-color-adjust:exact}.report-card,.report-metric{break-inside:avoid;box-shadow:none}.report-chart{height:250px}.report-table{min-width:0;font-size:9px}.report-table td,.report-table th{padding:5px}}
</style>
<div class="container-fluid report-page">
    <header class="report-hero">
        <div><small><?= html_escape($scope_label); ?> · Reading assessment summary</small><h1><?= html_escape($scope_heading); ?></h1><p><?= html_escape($grade_bands[$grade_band]['label']); ?> division summaries</p></div>
        <div><small>School year</small><div class="year"><?= html_escape($school_year_label); ?></div><button class="btn btn-light btn-sm no-print" type="button" onclick="window.print()">Print / Save PDF</button></div>
    </header>
    <section class="report-card no-print">
        <form class="report-filter" method="get" action="<?= base_url('Pages/regional_phil_iri_report'); ?>">
            <div class="form-group"><label for="phil-sy">School year</label><select id="phil-sy" name="sy" class="form-control"><?php for ($year = (int) date('Y') + 2; $year >= 2023; $year--): ?><option value="<?= $year; ?>" <?= $year === (int) $school_year ? 'selected' : ''; ?>><?= ($year - 1) . '-' . $year; ?></option><?php endfor; ?></select></div>
            <div class="form-group"><label for="phil-band">Grade band</label><select id="phil-band" name="grade_band" class="form-control"><?php foreach ($grade_bands as $key => $band): ?><option value="<?= html_escape($key); ?>" <?= $key === $grade_band ? 'selected' : ''; ?>><?= html_escape($band['label']); ?></option><?php endforeach; ?></select></div>
            <button type="submit" class="btn btn-primary">Apply filters</button>
        </form>
    </section>
    <section class="report-metrics" aria-label="Phil-IRI regional summary">
        <div class="report-metric"><span>Divisions in scope</span><strong><?= number_format($eligible_division_count); ?></strong></div>
        <div class="report-metric"><span>Divisions reporting</span><strong><?= number_format($reported_division_count); ?></strong></div>
        <div class="report-metric"><span>Learners assessed</span><strong><?= number_format($totals['learners_assessed']); ?></strong></div>
        <div class="report-metric"><span>Independent readers</span><strong><?= number_format($totals['independent']); ?></strong></div>
    </section>

    <?php if ($show_division_summary): ?>
    <section class="report-card">
        <div class="report-card-head"><h2>Summary by division</h2><p>Totals reflect the selected school year and grade band.</p></div>
        <div class="table-responsive"><table class="table report-table"><thead><tr><th>Division</th><th class="report-num">Summaries</th><th class="report-num">Assessed</th><?php foreach ($levels as $label): ?><th class="report-num"><?= html_escape($label[0]); ?></th><?php endforeach; ?></tr></thead><tbody>
            <?php if (empty($divisions)): ?><tr><td colspan="7" class="report-empty">No Phil-IRI summaries match these filters.</td></tr><?php else: foreach ($divisions as $division): ?><tr><td><?= html_escape($division['name']); ?></td><td class="report-num"><?= number_format($division['division_count']); ?></td><?php foreach (array('learners_assessed', 'independent', 'instructional', 'frustration', 'non_reader') as $field): ?><td class="report-num"><?= number_format($division[$field]); ?></td><?php endforeach; ?></tr><?php endforeach; endif; ?>
        </tbody></table></div>
    </section>
    <?php endif; ?>

    <section class="report-card">
        <div class="report-card-head"><h2>Reading levels by grade and language</h2><p>Bars show the percentage of assessed learners in each level. Historical school-level entries are retained but excluded from division totals.</p></div>
        <div class="report-chart"><?php if (empty($groups)): ?><div class="report-empty">No Phil-IRI division summaries match these filters.</div><?php else: ?><canvas id="philIriChart" aria-label="Phil-IRI reading levels by grade and language"></canvas><?php endif; ?></div>
    </section>
    <section class="report-card">
        <div class="report-card-head"><h2>Results by grade, language, and assessment</h2></div>
        <div class="table-responsive"><table class="table report-table"><thead><tr><th>Grade</th><th>Language</th><th>Assessment</th><th class="report-num">Divisions</th><th class="report-num">Assessed</th><?php foreach ($levels as $label): ?><th class="report-num"><?= html_escape($label[0]); ?></th><?php endforeach; ?></tr></thead><tbody>
            <?php if (empty($groups)): ?><tr><td colspan="9" class="report-empty">No matching results.</td></tr><?php else: foreach ($groups as $group): ?><tr><td>Grade <?= (int) $group['grade_level']; ?></td><td><?= html_escape($group['language']); ?></td><td><?= html_escape($group['assessment_period']); ?></td><td class="report-num"><?= number_format($group['division_count']); ?></td><?php foreach (array('learners_assessed', 'independent', 'instructional', 'frustration', 'non_reader') as $field): ?><td class="report-num"><?= number_format($group[$field]); ?></td><?php endforeach; ?></tr><?php endforeach; endif; ?>
        </tbody></table></div>
    </section>
    <section class="report-card">
        <div class="report-card-head"><h2>Division summaries</h2><p>Aggregate entries for the selected year and grade band.</p></div>
        <div class="table-responsive"><table class="table report-table"><thead><tr><th>Division</th><th>Entry type</th><th>Grade</th><th>Language</th><th>Assessment</th><th class="report-num">Assessed</th><?php foreach ($levels as $label): ?><th class="report-num"><?= html_escape($label[0]); ?></th><?php endforeach; ?></tr></thead><tbody>
            <?php if (empty($records)): ?><tr><td colspan="10" class="report-empty">No division summaries found for these filters.</td></tr><?php else: foreach ($records as $record): ?><tr><td><?= html_escape($record->division_name); ?></td><td>Division summary</td><td>Grade <?= (int) $record->grade_level; ?></td><td><?= html_escape($record->language); ?></td><td><?= html_escape($record->assessment_period); ?></td><td class="report-num"><?= number_format((int) $record->learners_assessed); ?></td><?php foreach (array('independent', 'instructional', 'frustration', 'non_reader') as $field): ?><td class="report-num"><?= number_format((int) $record->$field); ?></td><?php endforeach; ?></tr><?php endforeach; endif; ?>
        </tbody></table></div>
    </section>
</div>
<?php if (!empty($groups)): ?>
<script src="<?= base_url('assets/libs/chart-js/Chart.bundle.min.js'); ?>"></script>
<script>
(function () {
    var canvas = document.getElementById('philIriChart');
    if (!canvas || typeof Chart === 'undefined') return;
    var labels = <?= json_encode($labels, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var values = <?= json_encode($chart_values, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var profiles = <?= json_encode($levels, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var datasets = Object.keys(profiles).map(function (key) {
        return {label: profiles[key][0], data: values[key], backgroundColor: profiles[key][1], borderWidth: 0};
    });
    new Chart(canvas.getContext('2d'), {type: 'bar', data: {labels: labels, datasets: datasets}, options: {
        responsive: true, maintainAspectRatio: false, legend: {position: 'bottom'},
        tooltips: {mode: 'index', intersect: false, callbacks: {label: function (item, data) {
            return data.datasets[item.datasetIndex].label + ': ' + Number(item.yLabel).toFixed(1) + '%';
        }}},
        scales: {xAxes: [{gridLines: {display: false}, barPercentage: 0.8, categoryPercentage: 0.75}], yAxes: [{ticks: {
            beginAtZero: true, max: 100, callback: function (value) { return value + '%'; }
        }}]}
    }});
}());
</script>
<?php endif; ?>
