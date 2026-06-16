<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DAL - Delegation of Authority</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Delegation of Authority matrix for capital and non-capital expenditure approvals.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

body {
    font-family: 'Inter', Arial, sans-serif;
    margin: 0;
    background: #f0f4f8;
    color: #1e293b;
}

/* ── Header ── */
header {
    background: linear-gradient(135deg, #0b3c5d 0%, #1e5f94 100%);
    color: white;
    padding: 14px 20px;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    position: sticky;
    top: 0;
    z-index: 100;
}

header .header-icon {
    background: #f7d768;
    color: #0b3c5d;
    font-size: 13px;
    font-weight: 800;
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* ── Nav tabs ── */
nav {
    background: #ffffff;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

nav button {
    padding: 8px 18px;
    border: 1.5px solid #0b3c5d;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    background: transparent;
    color: #0b3c5d;
    font-family: inherit;
}

nav button.active, nav button:hover {
    background: #0b3c5d;
    color: #f7d768;
}

/* ── Main layout ── */
.container {
    padding: 12px;
    max-width: 1400px;
    margin: 0 auto;
}

/* ── Search ── */
.search-box {
    margin-bottom: 14px;
}

.search-box input {
    padding: 10px 14px;
    width: 100%;
    max-width: 380px;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    font-size: 13px;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s;
    background: white;
}

.search-box input:focus {
    border-color: #0b3c5d;
    box-shadow: 0 0 0 3px rgba(11,60,93,0.08);
}

/* ── Desktop table ── */
.table-container {
    overflow-x: auto;
    background: white;
    border-radius: 12px;
    padding: 0;
    max-height: 70vh;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
}

table {
    border-collapse: collapse;
    width: 100%;
    min-width: 1200px;
}

th, td {
    padding: 7px 6px;
    border: 1px solid #e2e8f0;
    text-align: center;
    font-size: 11px;
}

thead th {
    background: #0b3c5d;
    color: white;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 2;
    white-space: nowrap;
}

tbody tr:hover:not(.section-title) { background: #f8faff; }

.section-title {
    background: #fef9c3;
    font-weight: 700;
    text-align: left;
    color: #92400e;
    border-left: 4px solid #f7d768;
}

.section-title td {
    padding: 8px 10px;
    font-size: 11.5px;
}

.highlight { background: #fefce8; }

.hidden { display: none; }

/* ── Legend pills ── */
.legend {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 10px;
    font-size: 12px;
}

.legend-pill {
    display: flex;
    align-items: center;
    gap: 5px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 4px 10px;
    color: #475569;
    font-weight: 500;
}

.legend-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    display: inline-block;
}

/* ── Mobile accordion ── */
.mobile-view {
    display: none;
}

.m-section {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 10px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

.m-section-header {
    background: linear-gradient(90deg, #0b3c5d, #1e5f94);
    color: white;
    padding: 11px 14px;
    font-size: 13px;
    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.m-section-header .toggle-icon {
    font-size: 18px;
    line-height: 1;
    transition: transform 0.25s;
}

.m-section-header.open .toggle-icon {
    transform: rotate(45deg);
}

.m-section-body {
    display: none;
    padding: 0;
}

.m-section-body.open { display: block; }

.m-row {
    border-bottom: 1px solid #f1f5f9;
    padding: 12px 14px;
}

.m-row:last-child { border-bottom: none; }

.m-row-num {
    font-size: 11px;
    color: #94a3b8;
    font-weight: 600;
    margin-bottom: 6px;
}

.m-row-currencies {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 8px;
}

.m-chip {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    border-radius: 20px;
    padding: 3px 10px;
    font-size: 12px;
    font-weight: 600;
}

.m-chip.approval {
    background: #f0fdf4;
    color: #166534;
    border-color: #bbf7d0;
}

.m-approvers {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 6px;
}

.m-approver-pill {
    background: #f1f5f9;
    color: #334155;
    border-radius: 6px;
    padding: 3px 8px;
    font-size: 11px;
    font-weight: 600;
}

.m-approver-pill .role { color: #64748b; font-weight: 400; }

.m-remarks {
    background: #fffbeb;
    border-left: 3px solid #f7d768;
    padding: 7px 10px;
    border-radius: 0 6px 6px 0;
    font-size: 12px;
    color: #78350f;
    margin-top: 6px;
}

@media (max-width: 767px) {
    .desktop-view { display: none !important; }
    .mobile-view  { display: block !important; }
    .search-box input { max-width: 100%; }
    header { font-size: 14px; padding: 12px 14px; }
    nav button { font-size: 12px; padding: 7px 14px; }
}
</style>
</head>

<body>

<header>
    <div class="header-icon">D</div>
    Delegation of Authority (DAL)
</header>

<nav>
    <button id="btn-capital" class="active" onclick="showSection('capital', this)">Capital Expenditure</button>
    <button id="btn-noncapital" onclick="showSection('noncapital', this)">Non-Capital Expenditure</button>
</nav>

<div class="container">

    {{-- Legend --}}
    <div class="legend">
        <div class="legend-pill"><span class="legend-dot" style="background:#2563eb"></span> A = Approve</div>
        <div class="legend-pill"><span class="legend-dot" style="background:#16a34a"></span> R = Recommend</div>
        <div class="legend-pill"><span class="legend-dot" style="background:#d97706"></span> P = Propose</div>
        <div class="legend-pill"><span class="legend-dot" style="background:#9333ea"></span> I = Inform</div>
        <div class="legend-pill"># = Subject to conditions</div>
    </div>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search DAL entries..." oninput="filterTable()">
    </div>

    <!-- CAPITAL SECTION -->
    <div id="capitalSection">

        {{-- ===== MOBILE ACCORDION VIEW ===== --}}
        <div class="mobile-view" id="capitalMobile">

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    4.1 Acquisition of Budgeted Capital Expenditure
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body open">
                    <div class="m-row">
                        <div class="m-row-num">Row 1</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&gt; RM250k</span>
                            <span class="m-chip">&gt; SGD250k</span>
                            <span class="m-chip">&gt; AUD250k</span>
                            <span class="m-chip">&gt; USD125k</span>
                            <span class="m-chip">&gt; JPY6 mil</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                            <span class="m-approver-pill">Dep.GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&le; RM250k</span>
                            <span class="m-chip">&le; SGD250k</span>
                            <span class="m-chip">&le; AUD250k</span>
                            <span class="m-chip">&le; USD125k</span>
                            <span class="m-chip">&le; JPY6 mil</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.CEO <span class="role">A#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                            <span class="m-approver-pill">Dep.GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 3</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&le; RM200k</span>
                            <span class="m-chip">&le; SGD200k</span>
                            <span class="m-chip">&le; AUD200k</span>
                            <span class="m-chip">&le; USD100k</span>
                            <span class="m-chip">&le; JPY5 mil</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">SEVP <span class="role">A#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">R#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 4</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&le; RM150k</span>
                            <span class="m-chip">&le; SGD150k</span>
                            <span class="m-chip">&le; AUD150k</span>
                            <span class="m-chip">&le; USD75k</span>
                            <span class="m-chip">&le; JPY4 mil</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">EVP <span class="role">A#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">R#</span></span>
                            <span class="m-approver-pill">Dep.GM <span class="role">R#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 5</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&le; RM100k</span>
                            <span class="m-chip">&le; SGD100k</span>
                            <span class="m-chip">&le; AUD100k</span>
                            <span class="m-chip">&le; USD50k</span>
                            <span class="m-chip">&le; JPY3 mil</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">DGM <span class="role">A#</span></span>
                            <span class="m-approver-pill">GM <span class="role">R#</span></span>
                            <span class="m-approver-pill">Dep.GM <span class="role">R#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 6</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&le; RM50k</span>
                            <span class="m-chip">&le; SGD50k</span>
                            <span class="m-chip">&le; AUD50k</span>
                            <span class="m-chip">&le; USD25k</span>
                            <span class="m-chip">&le; JPY1.5 mil</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">GM <span class="role">A#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 7 (MY &amp; SG only)</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&le; RM25k</span>
                            <span class="m-chip">&le; SGD25k</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.GM <span class="role">A#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    4.2 Disposal / Write-Off of Budgeted CAPEX &amp; Transfer of Fixed Assets
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — &gt; RM250k / SGD250k / AUD250k / USD125k / JPY6 mil</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                            <span class="m-approver-pill">Dep.GM <span class="role">P#</span></span>
                        </div>
                        <div class="m-remarks">*Based on the disposal value</div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2 — &le; RM250k thresholds</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.CEO <span class="role">A#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    4.3 Procurement of Budgeted Contingencies / Misc. CAPEX
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-remarks" style="margin:12px 14px;">*10% of approved individual CAPEX line item, subject to max 5% of total approved budgeted CAPEX.</div>
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — More than RM500k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">Dep.CEO <span class="role">R#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">P#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2 — Up to RM500k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    4.4 Acquisition of Non-Budgeted Capital Expenditure
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — Any Amount</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">BOD <span class="role">A</span></span>
                            <span class="m-approver-pill">CEO <span class="role">R</span></span>
                            <span class="m-approver-pill">Dep.CEO <span class="role">R#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">P#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">P#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    4.5 Non-Budgeted Disposal &amp; Write Off of CAPEX
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-remarks" style="margin:12px 14px;">*Based on the disposal value</div>
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — More than RM100k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">BOD <span class="role">A</span></span>
                            <span class="m-approver-pill">CEO <span class="role">R</span></span>
                            <span class="m-approver-pill">Dep.CEO <span class="role">R#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">P#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2 — Up to RM100k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">Dep.CEO <span class="role">R#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    4.6 Non-Budgeted Transfer of Fixed Assets within the Group
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — Any Amount</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">Dep.CEO <span class="role">R#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">P#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">P#</span></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end mobile-view --}}

        {{-- ===== DESKTOP TABLE VIEW ===== --}}
        <div class="desktop-view">
        <div class="table-container">
            <table id="capitalTable">
                <thead>
                    <tr>
                        <th>No</th>                       
                        <th>Malaysia</th>
                        <th>Singapore</th>
                        <th>Australia</th>
                        <th>Vietnam</th>
                        <th>Japan</th>
						<th>SHR</th>
						<th>Sub SHR</th>
						<th>BOD</th>
						<th>Sub BOD</th>
						<th>NRC</th>
						<th>AC</th>
						<th>RMC</th>
						<th>TPC</th>
						<th>FIC</th>
						<th>SC</th>
						<th>Sub EXCO</th>
                        <th>CEO</th>
                        <th>Deputy CEO/COO</th>
						<th>SEVP</th>
						<th>EVP</th>
						<th>DGM</th>
						<th>GM</th>						
                        <th>Deputy GM / Head</th>
                        <th width="150">Remarks and Clarification</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
						<td colspan="25">This section covers the approval for procurement of capital expenditure (CAPEX) items. The execution of the relevant documentation can only be delegated to the personnel as per corporate rankings specified in the approved Group Corporate Finance’s Standard Operating Procedures (SOPs).</td>
                    </tr>
					<tr class="section-title">
                        <td colspan="25"><strong>4.1 Acquisition of Budgeted Capital Expenditure</strong> <em>(exclude land and building)</em></td>
                    </tr>
                    <tr>                        
						<td>1.</td>
						<td>&gt; RM250k</td>
						<td>&gt; SGD250k</td>
						<td>&gt; AUD250k</td>
						<td>&gt; USD125k</td>
						<td>&gt; JPY6 mil</td>						
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td>
						<td>A</td>
						<td></td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td>P#</td>
						<td>P#</td>
						<td></td>
                    </tr>
                    <tr>                        
						<td>2.</td>
						<td>&le; RM250k</td>
						<td>&le; SGD250k</td>
						<td>&le; AUD250k</td>
						<td>&le; USD125k</td>
						<td>&le; JPY6 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td>P#</td>
						<td>P#</td>
						<td></td>
                    </tr>
					
					<tr>
						<td>3.</td>
						<td>&le; RM200k</td>
						<td>&le; SGD200k</td>
						<td>&le; AUD200k</td>
						<td>&le; USD100k</td>
						<td>&le; JPY5 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td></td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td></td>
					</tr>

					<tr>
						<td>4.</td>
						<td>&le; RM150k</td>
						<td>&le; SGD150k</td>
						<td>&le; AUD150k</td>
						<td>&le; USD75k</td>
						<td>&le; JPY4 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td></td>
					</tr>

					<tr>
						<td>5.</td>
						<td>&le; RM100k</td>
						<td>&le; SGD100k</td>
						<td>&le; AUD100k</td>
						<td>&le; USD50k</td>
						<td>&le; JPY3 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td>R#</td>
						<td>R#</td>
						<td></td>
					</tr>

					<tr>
						<td>6.</td>
						<td>&le; RM50k</td>
						<td>&le; SGD50k</td>
						<td>&le; AUD50k</td>
						<td>&le; USD25k</td>
						<td>&le; JPY1.5 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td>7.</td>
						<td>&le; RM25k</td>
						<td>&le; SGD25k</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td></td>
					</tr>


                    <tr class="section-title">
                        <td colspan="24">						
							<strong>4.2&nbsp; Disposal / Write-Off of Budgeted Capital Expenditure and Budgeted Transfer of Fixed Assets within the Group</strong>
							<em>(exclude land and building)*</em>
						</td>
						<td>*Based on the disposal value</td>
                    </tr>
                    
					<tr>
					  <td>1.</td>
					  <td>&gt; RM250k</td>
					  <td>&gt; SGD250k</td>
					  <td>&gt; AUD250k</td>
					  <td>&gt; USD125k</td>
					  <td>&gt; JPY6 mil</td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>A</td><td></td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>

					<tr>
					  <td>2.</td>
					  <td>&le; RM250k</td>
					  <td>&le; SGD250k</td>
					  <td>&le; AUD250k</td>
					  <td>&le; USD125k</td>
					  <td>&le; JPY6 mil</td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td>
					  <td>A#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>

					<tr>
					  <td>3.</td>
					  <td>&le; RM200k</td>
					  <td>&le; SGD200k</td>
					  <td>&le; AUD200k</td>
					  <td>&le; USD100k</td>
					  <td>&le; JPY5 mil</td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td>
					  <td></td>
					  <td>A#</td>
					  <td></td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td></td>
					</tr>

					<tr>
					  <td>4.</td>
					  <td>&le; RM150k</td>
					  <td>&le; SGD150k</td>
					  <td>&le; AUD150k</td>
					  <td>&le; USD75k</td>
					  <td>&le; JPY4 mil</td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td>
					  <td></td>
					  <td></td>
					  <td>A#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="24">						
							<strong>4.3&nbsp; Procurement of Budgeted Contingencies / Miscellaneous Capital Expenditure*</strong>
						</td>
						<td>*10% of the approved individual CAPEX line item subject to a limit of not exceeding 5% of the total approved budgeted CAPEX.</td>
                    </tr>
                    
					<tr>
					  <td>1.</td>
					  <td colspan="5">More than RM500k </td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>A</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>2.</td>
					  <td colspan="5">Up to RM500k </td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td>A</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="25">						
							<strong>4.4&nbsp; Acquisition of Non-Budgeted Capital Expenditure</strong>
							<em>(exclude land and building, and items under budgeted contingencies / miscellaneous capital expenditure)</em>
						</td>
                    </tr>
                    
					<tr>
					  <td>1.</td>
					  <td colspan="5"> Any Amount</td>					  
					  <td></td><td></td><td>A</td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>R</td>
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="24">						
							<strong>4.5&nbsp; Non-Budgeted Disposal and Write Off of Capital Expenditure* </strong>
							<em>(exclude land and building)</em>
						</td>
						<td>*Based on the disposal value</td>
                    </tr>
                    
					<tr>
					  <td>1.</td>
					  <td colspan="5">More than RM100k</td>					  
					  <td></td><td></td><td>A</td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>R</td>
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>2.</td>
					  <td colspan="5">Up to RM100k </td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>A</td>
					  <td></td>
					  <td>R#</td>
					  <td>R#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="24">						
							<strong>4.6&nbsp; Non-Budgeted Transfer of Fixed Assets within the Group*</strong>
							<em>(exclude land and building)</em>
							<em>(Transfer of assets due to staff or equipment transfer within the group of companies for which management control is under S P Setia Berhad) </em>
						</td>
						<td>*Based on the disposal value</td>
                    </tr>
                    
					<tr>
					  <td>1.</td>
					  <td colspan="5"> Any Amount</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>A</td>
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
                </tbody>
            </table>
        </div>
        </div>{{-- end desktop-view --}}
    </div>{{-- end capitalSection --}}

    <!-- NON CAPITAL SECTION -->
    <div id="noncapitalSection" class="hidden">

        {{-- ===== NON-CAPITAL MOBILE ACCORDION ===== --}}
        <div class="mobile-view" id="noncapitalMobile">

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    5.1 Procurement of Budgeted Non-Capital Expenditure
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body open">
                    <div class="m-remarks" style="margin:12px 14px;">Appointment of legal firm must be in consultation with Group Legal</div>
                    <div class="m-row">
                        <div class="m-row-num">Row 1</div>
                        <div class="m-row-currencies">
                            <span class="m-chip">&gt; RM250k</span><span class="m-chip">&gt; SGD250k</span>
                            <span class="m-chip">&gt; AUD250k</span><span class="m-chip">&gt; USD125k</span>
                            <span class="m-chip">&gt; JPY6 mil</span>
                        </div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2 — &le; RM250k thresholds</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.CEO <span class="role">A#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 3 — &le; RM200k thresholds</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">SEVP <span class="role">A#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">R#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 4 — &le; RM150k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">EVP <span class="role">A#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">R#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 5 — &le; RM100k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">DGM <span class="role">A#</span></span>
                            <span class="m-approver-pill">GM <span class="role">R#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 6 — &le; RM50k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">GM <span class="role">A#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 7 — &le; RM25k (MY &amp; SG)</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.GM <span class="role">A#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 8 — &le; RM25k (all regions)</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.GM <span class="role">A#(1)</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    5.2 Contribution / Sponsorship
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — RM100k and above</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">BOD <span class="role">A</span></span>
                            <span class="m-approver-pill">CEO <span class="role">R</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">P#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2 — Below RM100k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 3 — Below RM50k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.CEO <span class="role">A#</span></span>
                            <span class="m-approver-pill">SEVP <span class="role">R#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 4 — Below RM10k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">DGM <span class="role">A#</span></span>
                            <span class="m-approver-pill">GM <span class="role">A#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    5.3 Professional / Consultancy Services
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-remarks" style="margin:12px 14px;">Exclude out-of-pocket expenses</div>
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — More than RM1 mil</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">R</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2 — Up to RM1 mil</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">CEO <span class="role">A</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 3 — Up to RM100k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">Dep.CEO <span class="role">A (CFO)</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    5.5 Budgeted Contingencies / Misc. Non-CAPEX
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-row">
                        <div class="m-row-num">Row 1 — More than RM500k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">SEVP <span class="role">A#</span></span>
                            <span class="m-approver-pill">EVP <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">Row 2 — Up to RM500k</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">SEVP <span class="role">A#</span></span>
                            <span class="m-approver-pill">DGM <span class="role">R#</span></span>
                            <span class="m-approver-pill">GM <span class="role">P#</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-section">
                <div class="m-section-header" onclick="toggleSection(this)">
                    5.6 Non-Budgeted Non-CAPEX / 5.8 Appointment of Assurance Provider
                    <span class="toggle-icon">+</span>
                </div>
                <div class="m-section-body">
                    <div class="m-row">
                        <div class="m-row-num">5.6 — Any Amount</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">BOD <span class="role">A</span></span>
                            <span class="m-approver-pill">CEO <span class="role">R</span></span>
                            <span class="m-approver-pill">Dep.CEO <span class="role">P#</span></span>
                        </div>
                    </div>
                    <div class="m-row">
                        <div class="m-row-num">5.8 — Any Amount</div>
                        <div class="m-approvers">
                            <span class="m-approver-pill">AC <span class="role">A</span></span>
                            <span class="m-approver-pill">DGM <span class="role">p (CIA)</span></span>
                        </div>
                        <div class="m-remarks">For matters under AC's purview</div>
                    </div>
                </div>
            </div>

        </div>{{-- end non-capital mobile-view --}}

        {{-- ===== NON-CAPITAL DESKTOP TABLE ===== --}}
        <div class="desktop-view">
        <div class="table-container">
            <table id="nonCapitalTable">
				<thead>
                    <tr>
                        <th>No</th>                       
                        <th>Malaysia</th>
                        <th>Singapore</th>
                        <th>Australia</th>
                        <th>Vietnam</th>
                        <th>Japan</th>
						<th>SHR</th>
						<th>Sub SHR</th>
						<th>BOD</th>
						<th>Sub BOD</th>
						<th>NRC</th>
						<th>AC</th>
						<th>RMC</th>
						<th>TPC</th>
						<th>FIC</th>
						<th>SC</th>
						<th>Sub EXCO</th>
                        <th>CEO</th>
                        <th>Deputy CEO/COO</th>
						<th>SEVP</th>
						<th>EVP</th>
						<th>DGM</th>
						<th>GM</th>						
                        <th>Deputy GM / Head</th>
                        <th>Remarks and Clarification</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
						<td colspan="25">This section covers the approval for procurement of non-capital expenditure items. The execution of the relevant documentation can only be delegated to the personnel as per corporate rankings specified in the approved Group Corporate Finance’s Standard Operating Procedures (SOPs).																								
</td>
                    <tr>
					<tr class="section-title">
                        <td colspan="24"><strong>5.1 Procurement of Budgeted Non-Capital Expenditure</strong></td>
						<td>Appointment of legal firm must be in consultation with Group Legal</td>
					</tr>
                    <tr>                        
						<td>1.</td>
						<td>&gt; RM250k</td>
						<td>&gt; SGD250k</td>
						<td>&gt; AUD250k</td>
						<td>&gt; USD125k</td>
						<td>&gt; JPY6 mil</td>						
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td>
						<td>A</td>
						<td></td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td>P#</td>
						<td>P#</td>
						<td></td>
                    </tr>
                    <tr>                        
						<td>2.</td>
						<td>&le; RM250k</td>
						<td>&le; SGD250k</td>
						<td>&le; AUD250k</td>
						<td>&le; USD125k</td>
						<td>&le; JPY6 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td>A#</td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td>P#</td>
						<td>P#</td>
						<td></td>
                    </tr>
					
					<tr>
						<td>3.</td>
						<td>&le; RM200k</td>
						<td>&le; SGD200k</td>
						<td>&le; AUD200k</td>
						<td>&le; USD100k</td>
						<td>&le; JPY5 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td>A#</td>
						<td></td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td></td>
					</tr>

					<tr>
						<td>4.</td>
						<td>&le; RM150k</td>
						<td>&le; SGD150k</td>
						<td>&le; AUD150k</td>
						<td>&le; USD75k</td>
						<td>&le; JPY4 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td>R#</td>
						<td>R#</td>
						<td>R#</td>
						<td></td>
					</tr>

					<tr>
						<td>5.</td>
						<td>&le; RM100k</td>
						<td>&le; SGD100k</td>
						<td>&le; AUD100k</td>
						<td>&le; USD50k</td>
						<td>&le; JPY3 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td>R#</td>
						<td>R#</td>
						<td></td>
					</tr>

					<tr>
						<td>6.</td>
						<td>&le; RM50k</td>
						<td>&le; SGD50k</td>
						<td>&le; AUD50k</td>
						<td>&le; USD25k</td>
						<td>&le; JPY1.5 mil</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td>7.</td>
						<td>&le; RM25k</td>
						<td>&le; SGD25k</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#</td>
						<td></td>
					</tr>
					<tr>
						<td>8.</td>
						<td>&le; RM25k</td>
						<td>&le; SGD25k</td>
						<td>&le; AUD5k</td>
						<td>&le; USD2.5k</td>
						<td>&le; JPY150k</td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>A#(1)</td>
						<td></td>
					</tr>


                    <tr class="section-title">
                        <td colspan="25">						
							<strong>5.2 Contribution/ Sponsorship (includes cash and in-kind sponsorship)    </strong>
						</td>
                    </tr>                    

					<tr>
					  <td>1.</td>
					  <td colspan="5">RM100k and above </td>					  
					  <td></td><td></td><td>A</td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>R</td>
					  <td></td>
					  <td>P#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>2.</td>
					  <td colspan="5">Below RM100k</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td>I</td><td></td><td></td><td></td>
					  <td></td>
					  <td>A</td>
					  <td></td>
					  <td>P#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>3.</td>
					  <td colspan="5">Below RM50k</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td>I</td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td>A#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>4.</td>
					  <td colspan="5">Below RM10k  </td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td>I</td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td>A#</td>
					  <td>A#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr> 
					
					<tr class="section-title">
                        <td colspan="24">						
							<strong>5.3 Professional/Consultancy Services for Corporate Related Matters</strong>
							<td>Exclude out-of-pocket expenses </td>
						</td>
                    </tr>                    

					<tr>
					  <td>1.</td>
					  <td colspan="5">More than RM1 mil</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>R</td>
					  <td></td>
					  <td></td>
					  <td>R</td>
					  <td></td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>2.</td>
					  <td colspan="5">Up to RM1 mil</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>A</td>
					  <td></td>
					  <td></td>
					  <td>R</td>
					  <td></td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>3.</td>
					  <td colspan="5">Up to RM100k</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td>A (CFO)</td>
					  <td></td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="25">						
							<strong>5.4 Appointment of Training Consultant</strong>
						</td>
                    </tr>                    

					<tr>
					  <td>1.</td>
					  <td colspan="5">More than RM15k per day</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>A</td>
					  <td>R#</td>
					  <td></td>
					  <td></td>
					  <td>P (CHCO)</td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="24">						
							<strong>5.5 Procurement of Budgeted Contingencies/ Miscellaneous Non-Capital Expenditure*</strong>
						</td>
						<td>*10% of the approved individual Non-CAPEX line item subject to maximum cap limit of not exceeding 5% of the approved annual budgeted Non-CAPEX (excluding staff costs, non-cash items, donations and sponsorship)</td>
                    </tr>                    

					<tr>
					  <td>1.</td>
					  <td colspan="5">More than RM500k </td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td>A#</td>
					  <td>R#</td>					  
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>
					
					<tr>
					  <td>2.</td>
					  <td colspan="5">Up to RM500k </td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td>A#</td>
					  <td>R#</td>
					  <td>R#</td>					  
					  <td>R#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="25">						
							<strong>5.6 Acquisition of Non-Budgeted Non-Capital Expenditure</strong>
							<em>(excluding items under budgeted contingencies/ miscellaneous non-capital expenditure)</em>
						</td>
                    </tr>                    

					<tr>
					  <td>1.</td>
					  <td colspan="5">Any Amount</td>					  
					  <td></td><td></td><td>A</td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td>R</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td>P#</td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="25">						
							<strong>5.7 Acquisition of Non-Budgeted Non-Capital Expenditure</strong>
							<em>(excluding items under budgeted contingencies/ miscellaneous non-capital expenditure)</em>
						</td>
                    </tr>                    

					<tr>
					  <td>1.</td>
					  <td colspan="5">As per approved budgeted amount</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td>A#</td>
					  <td>A#</td>
					  <td>A#</td>
					  <td>R#</td>
					  <td>R#</td>
					  <td></td>
					</tr>
					
					<tr class="section-title">
                        <td colspan="24">						
							<strong>5.8 Appointment / Termination of Assurance Provider </strong>							
						</td>
						<td>For matters under AC's purview </td>
                    </tr>                    

					<tr>
					  <td>1.</td>
					  <td colspan="5">Any Amount</td>					  
					  <td></td><td></td><td></td><td></td><td></td>
					  <td>A</td><td></td><td></td><td></td><td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td>p (CIA)</td>
					  <td></td>
					  <td></td>
					  <td></td>
					</tr>	
				</tbody>
			</table>
        </div>
        </div>{{-- end desktop-view --}}
    </div>{{-- end noncapitalSection --}}

</div>

<script>
function showSection(section, btn) {
    document.getElementById('capitalSection').classList.add('hidden');
    document.getElementById('noncapitalSection').classList.add('hidden');
    document.querySelectorAll('nav button').forEach(b => b.classList.remove('active'));

    if (section === 'capital') {
        document.getElementById('capitalSection').classList.remove('hidden');
    } else {
        document.getElementById('noncapitalSection').classList.remove('hidden');
    }
    if (btn) btn.classList.add('active');
    // Clear search
    document.getElementById('searchInput').value = '';
    filterTable();
}

function toggleSection(header) {
    header.classList.toggle('open');
    const body = header.nextElementSibling;
    body.classList.toggle('open');
}

function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();

    // Desktop filter
    document.querySelectorAll('table').forEach(table => {
        table.querySelectorAll('tbody tr').forEach(row => {
            if (row.classList.contains('section-title') || row.cells.length <= 1) return;
            row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
        });
    });

    // Mobile filter
    document.querySelectorAll('.m-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>

</body>
</html>