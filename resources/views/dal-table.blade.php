<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DAL - Delegation of Authority</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    background: #f5f7fa;
}

header {
    background: #0b3c5d;
    color: white;
    padding: 12px 30px;
    font-size: 16px;
    font-weight: bold;
}

nav {
    background: #ffffff;
    padding: 10px 20px;
    border-bottom: 1px solid #ddd;
}

nav button {
    margin-right: 10px;
    padding: 8px 15px;
    border: none;
    background: #0b3c5d;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}

.container {
    padding: 10px;
}

.search-box {
    margin-bottom: 15px;
}

.search-box input {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.table-container {
    overflow-x: auto;
    background: white;
    border-radius: 10px;
    padding: 10px;
	max-height: 1200px
}

table {
    border-collapse: collapse;
    width: 100%;
    min-width: 1200px;
}

th, td {
    padding: 6px;
    border: 1px solid #ddd;
    text-align: center;
    font-size: 11px;
}

thead th {
    background: #0b3c5d;
    color: white;
    position: sticky;
    top: 0;
    z-index: 2;
}




.section-title {
    background: #ffd966;
    font-weight: bold;
    text-align: left;
}

.highlight {
    background: #fff2cc;
}

.hidden {
    display: none;
}
</style>
</head>

<body>

<header>
    Delegation of Authority (DAL)
</header>

<nav>
    <button onclick="showSection('capital')">Capital Expenditure</button>
    <button onclick="showSection('noncapital')">Non-Capital Expenditure</button>
</nav>

<div class="container">

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search DAL..." onkeyup="filterTable()">
    </div>

    <!-- CAPITAL SECTION -->
    <div id="capitalSection">
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
    </div>

    <!-- NON CAPITAL SECTION -->
    <div id="noncapitalSection" class="hidden">
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
    </div>

</div>

<script>
function showSection(section) {
    document.getElementById("capitalSection").classList.add("hidden");
    document.getElementById("noncapitalSection").classList.add("hidden");

    if(section === "capital") {
        document.getElementById("capitalSection").classList.remove("hidden");
    } else {
        document.getElementById("noncapitalSection").classList.remove("hidden");
    }
}

function filterTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let tables = document.querySelectorAll("table");

    tables.forEach(table => {
        let rows = table.getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            let text = rows[i].innerText.toLowerCase();
            rows[i].style.display = text.includes(input) ? "" : "none";
        }
    });
}
</script>

</body>
</html>