<?php
/**
 * Regional Filipino subject overview — served at /region.
 *
 * Every figure on this page is read back from submitted learning-gap records,
 * so a reader can trace any number here to the records list behind it.
 */
$region_id = (int) $this->session->region;
$scope = array('type' => 'region', 'id' => $region_id);

$summary = $this->Page_model->learning_gap_summary($scope);
$term_performance = $this->Page_model->learning_gap_term_performance($scope);
$thematic_analysis = $this->Page_model->learning_gap_thematic_analysis($scope);
$division_rows = $this->Page_model->learning_gap_division_summary($region_id);
$division_performance_rows = $this->Page_model->learning_gap_division_performance($region_id);

$performance_by_division = array();
foreach ($division_performance_rows as $performance_row) {
    $performance_by_division[(int) $performance_row->division_id] = $performance_row;
}

$records_url = base_url('Pages/learning_gap_records');
$overview_url = base_url('Pages/learning_gap');

$display_name = isset($this->session->user) && trim((string) $this->session->user) !== ''
    ? mb_convert_case((string) $this->session->user, MB_CASE_TITLE, 'UTF-8')
    : 'Regional User';

$record_count = (int) $summary->record_count;
$reporting_division_count = (int) $summary->school_count;
$learners_assessed = (int) $summary->learners_assessed;
$learners_with_gap = (int) $summary->learners_with_gap;
$gap_rate = $learners_assessed > 0 ? ($learners_with_gap / $learners_assessed) * 100 : 0;

$cpl_record_count = array_sum(array_map(function ($row) {
    return (int) $row->cpl_record_count;
}, $term_performance));
$cpl_coverage = $record_count > 0 ? ($cpl_record_count / $record_count) * 100 : 0;

$divisions_total = count($division_rows);
$divisions_reporting = 0;
foreach ($division_rows as $division_row) {
    if ((int) $division_row->record_count > 0) {
        $divisions_reporting++;
    }
}
$reporting_rate = $divisions_total > 0 ? ($divisions_reporting / $divisions_total) * 100 : 0;

/* The summary query already orders divisions by learners with gap, so the top
   of the list is the shortlist a regional officer follows up on first. */
$priority_rows = array_slice(array_values(array_filter($division_rows, function ($row) {
    return (int) $row->learners_with_gap > 0;
})), 0, 4);

$theme_max_count = !empty($thematic_analysis['themes'])
    ? max(array_map(function ($theme) { return (int) $theme->record_count; }, $thematic_analysis['themes']))
    : 0;

?>
<link rel="stylesheet" href="<?= base_url('assets/css/region-dashboard.css'); ?>?v=<?= filemtime(FCPATH . 'assets/css/region-dashboard.css'); ?>">

<div class="rd-page">
    <header class="rd-header">
        <div>
            <span class="rd-eyebrow">FILIPINO DATAHUB · Filipino Subject</span>
            <h1>Regional Filipino Learning Overview</h1>
            <p class="rd-header-meta">
                <span>Welcome, <?= html_escape($display_name); ?></span>
                <span class="rd-num">School Year <?= html_escape(school_year_range($this->session->fy)); ?></span>
                <span class="rd-num"><?= number_format($divisions_total); ?> division<?= $divisions_total === 1 ? '' : 's'; ?></span>
            </p>
            <p>Division-encoded summaries only; historical school-level entries remain stored but are excluded from these totals.</p>
        </div>
        <div class="rd-header-actions">
            <a class="btn btn-light" href="<?= $overview_url; ?>"><i class="mdi mdi-chart-bar" aria-hidden="true"></i> Learning gap summary</a>
            <a class="btn btn-outline-light" href="<?= $records_url; ?>"><i class="mdi mdi-format-list-bulleted" aria-hidden="true"></i> View records</a>
            <a class="btn btn-light" href="<?= base_url('Pages/regional_phil_iri_report'); ?>"><i class="mdi mdi-book-open-page-variant" aria-hidden="true"></i> Phil-IRI report</a>
            <a class="btn btn-outline-light" href="<?= base_url('Pages/regional_crla_report'); ?>"><i class="mdi mdi-book-open-variant" aria-hidden="true"></i> CRLA report</a>
        </div>
    </header>

    <div class="rd-metrics">
        <a class="rd-metric" href="<?= $records_url; ?>">
            <span class="rd-metric-top">
                <span class="rd-metric-label">Reporting divisions</span>
                <span class="rd-metric-icon"><i class="mdi mdi-office-building" aria-hidden="true"></i></span>
            </span>
            <strong class="rd-metric-value rd-num"><?= number_format($divisions_reporting); ?></strong>
            <small class="rd-metric-note"><?= number_format($reporting_rate, 1); ?>% of divisions have an encoded summary</small>
        </a>
        <a class="rd-metric" href="<?= $records_url; ?>">
            <span class="rd-metric-top">
                <span class="rd-metric-label">Encoded records</span>
                <span class="rd-metric-icon"><i class="mdi mdi-file-document-outline" aria-hidden="true"></i></span>
            </span>
            <strong class="rd-metric-value rd-num"><?= number_format($record_count); ?></strong>
            <small class="rd-metric-note">Filipino competency gap entries submitted region-wide</small>
        </a>
        <a class="rd-metric" href="<?= $records_url; ?>">
            <span class="rd-metric-top">
                <span class="rd-metric-label">Learners assessed</span>
                <span class="rd-metric-icon"><i class="mdi mdi-account-group-outline" aria-hidden="true"></i></span>
            </span>
            <strong class="rd-metric-value rd-num"><?= number_format($learners_assessed); ?></strong>
            <small class="rd-metric-note">Sum of the assessed counts on submitted records</small>
        </a>
        <a class="rd-metric rd-metric-focus" href="<?= $records_url; ?>">
            <span class="rd-metric-top">
                <span class="rd-metric-label">Recorded gap rate</span>
                <span class="rd-metric-icon"><i class="mdi mdi-alert-circle-outline" aria-hidden="true"></i></span>
            </span>
            <strong class="rd-metric-value rd-num"><?= $learners_assessed > 0 ? number_format($gap_rate, 1) . '%' : '—'; ?></strong>
            <small class="rd-metric-note">
                <?= $learners_assessed > 0
                    ? number_format($learners_with_gap) . ' of ' . number_format($learners_assessed) . ' learners'
                    : 'No assessed learners recorded yet'; ?>
            </small>
            <?php if ($learners_assessed > 0) : ?>
                <span class="rd-meter" aria-hidden="true"><span style="width:<?= min(100, max(0, $gap_rate)); ?>%"></span></span>
            <?php endif; ?>
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <section class="rd-card" aria-labelledby="rd-term-title">
                <div class="rd-card-head">
                    <h2 id="rd-term-title">Proficiency and gap rate by term</h2>
                    <span class="rd-tag"><i class="mdi mdi-chart-timeline-variant" aria-hidden="true"></i> CPL on <?= number_format($cpl_record_count); ?>/<?= number_format($record_count); ?> records</span>
                    <p>Gap rate is the sum of recorded gap counts divided by the sum of recorded assessed counts. Class proficiency level is weighted by assessed count across the records that carry a CPL value.</p>
                </div>
                <div class="rd-card-body">
                    <div class="rd-chart">
                        <canvas id="rdTermChart" role="img" aria-label="Class proficiency level and recorded gap rate for each term"></canvas>
                        <div id="rdTermEmpty" class="rd-chart-empty">
                            <div><i class="mdi mdi-chart-line-variant" aria-hidden="true"></i>No per-term assessment data has been submitted yet.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xl-4">
            <section class="rd-card" aria-labelledby="rd-coverage-title">
                <div class="rd-card-head">
                    <h2 id="rd-coverage-title">Division reporting coverage</h2>
                    <span class="rd-tag rd-tag-quiet rd-num"><?= $divisions_reporting; ?> / <?= $divisions_total; ?></span>
                </div>
                <div class="rd-card-body">
                    <div class="rd-coverage-value rd-num"><?= number_format($reporting_rate, 1); ?>%</div>
                    <p class="rd-coverage-label">of divisions have at least one submitted learning-gap record</p>
                    <div class="rd-bar" aria-hidden="true"><span style="width:<?= min(100, max(0, $reporting_rate)); ?>%"></span></div>
                    <div class="rd-bar-legend">
                        <span><strong class="rd-num"><?= number_format($divisions_reporting); ?></strong> reporting</span>
                        <span><strong class="rd-num"><?= number_format(max(0, $divisions_total - $divisions_reporting)); ?></strong> without records</span>
                    </div>
                </div>
            </section>

            <section class="rd-card" aria-labelledby="rd-priority-title">
                <div class="rd-card-head">
                    <h2 id="rd-priority-title">Priority attention</h2>
                    <a class="rd-link" href="<?= $records_url; ?>">All records <i class="mdi mdi-arrow-right" aria-hidden="true"></i></a>
                    <p>Divisions carrying the largest recorded number of learners with gaps.</p>
                </div>
                <div class="rd-card-body">
                    <?php if (empty($priority_rows)) : ?>
                        <div class="rd-empty">
                            <i class="mdi mdi-check-circle-outline" aria-hidden="true"></i>
                            <p>No division has recorded learners with gaps yet.</p>
                        </div>
                    <?php else : ?>
                        <ol class="rd-priority">
                            <?php foreach ($priority_rows as $index => $row) : ?>
                                <li>
                                    <span class="rd-priority-rank"><?= $index + 1; ?></span>
                                    <span class="rd-priority-name">
                                        <a href="<?= $records_url; ?>?division_id=<?= (int) $row->division_id; ?>"><?= html_escape($row->division_name); ?></a>
                                        <small><?= (int) $row->record_count > 0 ? 'Division summary entered' : 'No division summary'; ?> · <?= number_format((int) $row->record_count); ?> record<?= (int) $row->record_count === 1 ? '' : 's'; ?></small>
                                    </span>
                                    <span class="rd-priority-value">
                                        <strong class="rd-num"><?= number_format((int) $row->learners_with_gap); ?></strong>
                                        <small>with gap</small>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>

    <section class="rd-card" aria-labelledby="rd-division-chart-title">
        <div class="rd-card-head">
            <h2 id="rd-division-chart-title">Proficiency and gap rate by division</h2>
            <span class="rd-tag rd-tag-quiet rd-num"><?= number_format($divisions_total); ?> division<?= $divisions_total === 1 ? '' : 's'; ?></span>
            <p>Both measures come from submitted records. Divisions without a CPL value are excluded from the proficiency bar and reported under coverage instead.</p>
        </div>
        <div class="rd-card-body">
            <div class="rd-chart rd-chart-tall">
                <canvas id="rdDivisionChart" role="img" aria-label="Comparison of class proficiency level and recorded gap rate for each division"></canvas>
                <div id="rdDivisionEmpty" class="rd-chart-empty">
                    <div><i class="mdi mdi-chart-bar" aria-hidden="true"></i>No division performance data is available yet.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="rd-card" aria-labelledby="rd-table-title">
        <div class="rd-card-head">
            <h2 id="rd-table-title">Performance by division</h2>
            <div class="rd-filter">
                <i class="mdi mdi-magnify" aria-hidden="true"></i>
                <input type="search" id="rdDivisionFilter" placeholder="Filter divisions" aria-label="Filter divisions by name" autocomplete="off">
            </div>
            <p>Counts are direct sums from submitted records. Select a column heading to reorder the table.</p>
        </div>
        <div class="rd-card-body rd-card-body-flush">
            <?php if (empty($division_rows)) : ?>
                <div class="rd-empty">
                    <i class="mdi mdi-office-building" aria-hidden="true"></i>
                    <p>No divisions are configured for this regional account.</p>
                </div>
            <?php else : ?>
                <div class="rd-table-wrap">
                    <table class="rd-table" id="rdDivisionTable">
                        <thead>
                            <tr>
                                <th class="rd-sort" data-type="text" scope="col">Division</th>
                                <th class="rd-sort" data-type="number" scope="col">Status</th>
                                <th class="rd-sort" data-type="number" scope="col">Records</th>
                                <th class="rd-sort" data-type="number" scope="col">Assessed</th>
                                <th class="rd-sort" data-type="number" scope="col">With gap</th>
                                <th class="rd-sort" data-type="number" scope="col">Weighted CPL</th>
                                <th class="rd-sort" data-type="number" data-dir="desc" scope="col">Gap rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($division_rows as $row) : ?>
                                <?php
                                $record_link = $records_url . '?division_id=' . (int) $row->division_id;
                                $row_assessed = (int) $row->learners_assessed;
                                $row_records = (int) $row->record_count;
                                $row_gap_rate = $row_assessed > 0 ? ((int) $row->learners_with_gap / $row_assessed) * 100 : null;
                                $row_performance = isset($performance_by_division[(int) $row->division_id])
                                    ? $performance_by_division[(int) $row->division_id]
                                    : null;
                                $row_cpl = $row_performance && $row_performance->class_proficiency_level !== null
                                    ? (float) $row_performance->class_proficiency_level
                                    : null;
                                ?>
                                <tr>
                                    <td data-sort="<?= html_escape(mb_strtolower((string) $row->division_name, 'UTF-8')); ?>">
                                        <span class="rd-division-name"><?= html_escape($row->division_name); ?></span>
                                    </td>
                                    <td data-sort="<?= $row_records > 0 ? 1 : 0; ?>">
                                        <span class="rd-pill<?= $row_records > 0 ? '' : ' rd-pill-muted'; ?>"><?= $row_records > 0 ? 'Reporting' : 'No records'; ?></span>
                                    </td>
                                    <td class="rd-num" data-sort="<?= $row_records; ?>"><a href="<?= $record_link; ?>"><?= number_format($row_records); ?></a></td>
                                    <td class="rd-num" data-sort="<?= $row_assessed; ?>"><?= number_format($row_assessed); ?></td>
                                    <td class="rd-num" data-sort="<?= (int) $row->learners_with_gap; ?>"><?= number_format((int) $row->learners_with_gap); ?></td>
                                    <td data-sort="<?= $row_cpl === null ? -1 : $row_cpl; ?>">
                                        <?php if ($row_cpl === null) : ?>
                                            <span class="rd-sub">Not reported</span>
                                        <?php else : ?>
                                            <span class="rd-num"><?= number_format($row_cpl, 1); ?>%</span>
                                            <span class="rd-sub rd-num"><?= number_format((int) $row_performance->cpl_record_count); ?> of <?= number_format((int) $row_performance->record_count); ?> records</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-sort="<?= $row_gap_rate === null ? -1 : $row_gap_rate; ?>">
                                        <?php if ($row_gap_rate === null) : ?>
                                            <span class="rd-sub">—</span>
                                        <?php else : ?>
                                            <span class="rd-rate">
                                                <span class="rd-rate-bar" aria-hidden="true"><span style="width:<?= min(100, max(0, $row_gap_rate)); ?>%"></span></span>
                                                <span class="rd-rate-value rd-num"><?= number_format($row_gap_rate, 1); ?>%</span>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="rd-table-foot" id="rdDivisionCount" data-total="<?= $divisions_total; ?>">Showing all <?= number_format($divisions_total); ?> division<?= $divisions_total === 1 ? '' : 's'; ?>. CPL coverage region-wide is <?= number_format($cpl_coverage, 1); ?>%.</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<script src="<?= base_url('assets/libs/chart-js/Chart.bundle.min.js'); ?>"></script>
<script>
    (function () {
        var NAVY = '#123d61';
        var BLUE = '#2877a9';
        var AMBER = '#c98616';
        var GREEN = '#1d6b3c';
        var GRID = 'rgba(28,72,101,.08)';

        function percentTick(value) { return value + '%'; }
        function percentLabel(value, label) {
            return label + ': ' + (value === null || value === undefined ? 'No data' : Number(value).toFixed(1) + '%');
        }

        /* ---------- Per-term chart ---------- */
        var termRows = <?= json_encode(array_map(function ($row) {
            $assessed = (int) $row->learners_assessed;
            return array(
                'term' => (string) $row->term,
                'cpl' => $row->class_proficiency_level === null ? null : round((float) $row->class_proficiency_level, 2),
                'gapPercentage' => $assessed > 0 ? round(((int) $row->learners_with_gap / $assessed) * 100, 2) : null,
                'assessed' => $assessed,
            );
        }, $term_performance), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

        var divisionRows = <?= json_encode(array_map(function ($row) {
            $assessed = (int) $row->learners_assessed;
            return array(
                'division' => (string) $row->division_name,
                'cpl' => $row->class_proficiency_level === null ? null : round((float) $row->class_proficiency_level, 2),
                'gapPercentage' => $assessed > 0 ? round(((int) $row->learners_with_gap / $assessed) * 100, 2) : null,
                'assessed' => $assessed,
            );
        }, $division_performance_rows), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

        function showEmpty(canvasId, emptyId) {
            var canvas = document.getElementById(canvasId);
            var empty = document.getElementById(emptyId);
            if (canvas) {
                canvas.style.display = 'none';
                if (canvas.parentNode) { canvas.parentNode.className += ' is-empty'; }
            }
            if (empty) { empty.style.display = 'flex'; }
        }

        function hasData(rows) {
            return rows.some(function (row) { return row.assessed > 0 || row.cpl !== null; });
        }

        if (typeof Chart !== 'undefined') {
            Chart.defaults.global.defaultFontColor = '#6b7f92';
            Chart.defaults.global.defaultFontFamily = getComputedStyle(document.body).fontFamily;
        }

        var termCanvas = document.getElementById('rdTermChart');
        if (typeof Chart !== 'undefined' && termCanvas && hasData(termRows)) {
            new Chart(termCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: termRows.map(function (row) { return row.term; }),
                    datasets: [
                        {
                            label: 'Recorded gap rate',
                            data: termRows.map(function (row) { return row.gapPercentage; }),
                            backgroundColor: 'rgba(201,134,22,.75)',
                            hoverBackgroundColor: 'rgba(201,134,22,.92)',
                            borderColor: AMBER,
                            borderWidth: 0,
                            borderSkipped: 'bottom'
                        },
                        {
                            type: 'line',
                            label: 'Class proficiency level',
                            data: termRows.map(function (row) { return row.cpl; }),
                            borderColor: GREEN,
                            backgroundColor: 'rgba(29,107,60,.08)',
                            pointBackgroundColor: GREEN,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            borderWidth: 2,
                            fill: false,
                            spanGaps: true,
                            lineTension: .25
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { top: 6 } },
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18, boxWidth: 8 } },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: NAVY,
                        titleMarginBottom: 8,
                        xPadding: 12,
                        yPadding: 10,
                        cornerRadius: 6,
                        callbacks: {
                            label: function (item, data) {
                                return percentLabel(item.yLabel, data.datasets[item.datasetIndex].label);
                            }
                        }
                    },
                    scales: {
                        xAxes: [{ gridLines: { display: false }, barPercentage: .5, categoryPercentage: .6 }],
                        yAxes: [{
                            ticks: { beginAtZero: true, max: 100, stepSize: 20, callback: percentTick },
                            gridLines: { color: GRID, drawBorder: false, zeroLineColor: GRID }
                        }]
                    }
                }
            });
        } else {
            showEmpty('rdTermChart', 'rdTermEmpty');
        }

        /* ---------- Per-division chart ---------- */
        var divisionCanvas = document.getElementById('rdDivisionChart');
        if (typeof Chart !== 'undefined' && divisionCanvas && hasData(divisionRows)) {
            new Chart(divisionCanvas.getContext('2d'), {
                type: 'horizontalBar',
                data: {
                    labels: divisionRows.map(function (row) { return row.division; }),
                    datasets: [
                        {
                            label: 'Class proficiency level',
                            data: divisionRows.map(function (row) { return row.cpl; }),
                            backgroundColor: 'rgba(40,119,169,.8)',
                            hoverBackgroundColor: BLUE,
                            borderWidth: 0
                        },
                        {
                            label: 'Recorded gap rate',
                            data: divisionRows.map(function (row) { return row.gapPercentage; }),
                            backgroundColor: 'rgba(201,134,22,.75)',
                            hoverBackgroundColor: AMBER,
                            borderWidth: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18, boxWidth: 8 } },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: NAVY,
                        titleMarginBottom: 8,
                        xPadding: 12,
                        yPadding: 10,
                        cornerRadius: 6,
                        callbacks: {
                            label: function (item, data) {
                                return percentLabel(item.xLabel, data.datasets[item.datasetIndex].label);
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: { beginAtZero: true, max: 100, stepSize: 20, callback: percentTick },
                            gridLines: { color: GRID, drawBorder: false, zeroLineColor: GRID }
                        }],
                        yAxes: [{ gridLines: { display: false }, barPercentage: .78, categoryPercentage: .74 }]
                    }
                }
            });
        } else {
            showEmpty('rdDivisionChart', 'rdDivisionEmpty');
        }

        /* ---------- Division table: filter and sort ---------- */
        var table = document.getElementById('rdDivisionTable');
        if (!table) { return; }

        var body = table.tBodies[0];
        var countNote = document.getElementById('rdDivisionCount');
        var total = countNote ? parseInt(countNote.getAttribute('data-total'), 10) || 0 : 0;
        var allRows = Array.prototype.slice.call(body.rows);

        function updateCount(visible) {
            if (!countNote) { return; }
            countNote.textContent = visible === total
                ? 'Showing all ' + total + ' division' + (total === 1 ? '' : 's') + '.'
                : 'Showing ' + visible + ' of ' + total + ' division' + (total === 1 ? '' : 's') + '.';
        }

        var filter = document.getElementById('rdDivisionFilter');
        if (filter) {
            filter.addEventListener('input', function () {
                var needle = filter.value.trim().toLowerCase();
                var visible = 0;
                allRows.forEach(function (row) {
                    var name = row.cells[0].getAttribute('data-sort') || '';
                    var match = needle === '' || name.indexOf(needle) !== -1;
                    row.hidden = !match;
                    if (match) { visible++; }
                });
                updateCount(visible);
            });
        }

        function sortValue(row, index, type) {
            var raw = row.cells[index].getAttribute('data-sort');
            return type === 'number' ? parseFloat(raw) : (raw || '');
        }

        Array.prototype.forEach.call(table.tHead.rows[0].cells, function (header, index) {
            if (header.className.indexOf('rd-sort') === -1) { return; }
            header.setAttribute('tabindex', '0');
            header.setAttribute('role', 'button');

            function sort() {
                var type = header.getAttribute('data-type') || 'text';
                /* Numbers read best largest-first, names A to Z. */
                var current = header.getAttribute('data-dir');
                var dir = current === 'desc' ? 'asc' : (current === 'asc' ? 'desc' : (type === 'number' ? 'desc' : 'asc'));

                Array.prototype.forEach.call(table.tHead.rows[0].cells, function (other) {
                    other.removeAttribute('data-dir');
                });
                header.setAttribute('data-dir', dir);

                allRows.slice().sort(function (left, right) {
                    var a = sortValue(left, index, type);
                    var b = sortValue(right, index, type);
                    var result = type === 'number' ? a - b : String(a).localeCompare(String(b));
                    return dir === 'asc' ? result : -result;
                }).forEach(function (row) {
                    body.appendChild(row);
                });
            }

            header.addEventListener('click', sort);
            header.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    sort();
                }
            });
        });
    }());
</script>
