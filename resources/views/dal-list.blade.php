<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DAL Mobile Friendly View</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body{
      background:#f4f6f9;
      font-family:Arial, sans-serif;
    }

    .page-title{
      background:#0b3b63;
      color:white;
      padding:16px;
      font-size:22px;
      font-weight:700;
    }

    .dal-tabs .btn{
      border-radius:12px;
      padding:10px 18px;
      font-weight:600;
    }

    .dal-card{
      border:none;
      border-radius:18px;
      overflow:hidden;
      box-shadow:0 2px 10px rgba(0,0,0,0.08);
      margin-bottom:18px;
    }

    .dal-header{
      background:#f7d768;
      padding:12px 16px;
      font-weight:700;
      font-size:15px;
    }

    .dal-body{
      padding:16px;
      background:white;
    }

    .dal-row{
      display:flex;
      justify-content:space-between;
      padding:10px 0;
      border-bottom:1px solid #eee;
      gap:12px;
    }

    .dal-row:last-child{
      border-bottom:none;
    }

    .dal-label{
      color:#6c757d;
      font-size:14px;
      min-width:120px;
      font-weight:600;
    }

    .dal-value{
      text-align:right;
      font-weight:600;
      color:#0b3b63;
    }

    .approval-badge{
      background:#d1e7dd;
      color:#146c43;
      padding:4px 10px;
      border-radius:20px;
      font-size:12px;
      font-weight:700;
    }

    .remarks-box{
      background:#fff8dd;
      border-left:4px solid #ffc107;
      padding:10px;
      border-radius:10px;
      margin-top:14px;
      font-size:14px;
    }

    .hidden{
      display:none !important;
    }

    @media(min-width:992px){

      .mobile-view{
        display:none;
      }

      .desktop-view{
        display:block;
      }
    }

    @media(max-width:991px){

      .desktop-view{
        display:none;
      }

      .mobile-view{
        display:block;
      }
    }
  </style>
</head>

<body>

<div class="page-title">
  Delegation of Authority (DAL)
</div>

<div class="container py-3">

  <!-- TABS -->
  <div class="d-flex gap-2 flex-wrap dal-tabs mb-3">

    <button class="btn btn-primary tab-btn active"
            data-tab="capital">
      Capital Expenditure
    </button>

    <button class="btn btn-outline-primary tab-btn"
            data-tab="noncapital">
      Non-Capital Expenditure
    </button>

  </div>

  <!-- SEARCH -->
  <div class="mb-4">
    <input type="text"
           id="searchInput"
           class="form-control form-control-lg"
           placeholder="Search DAL...">
  </div>

  <!-- ================================= -->
  <!-- CAPITAL SECTION -->
  <!-- ================================= -->

  <div id="capitalSection" class="dal-section">

    <!-- MOBILE VIEW -->
    <div class="mobile-view">

      <div class="card dal-card dal-item">

        <div class="dal-header">
          Capital Expenditure Approval
        </div>

        <div class="dal-body">

          <div class="dal-row">
            <div class="dal-label">Malaysia</div>
            <div class="dal-value">&gt; RM500k</div>
          </div>

          <div class="dal-row">
            <div class="dal-label">Singapore</div>
            <div class="dal-value">&gt; SGD500k</div>
          </div>

          <div class="dal-row">
            <div class="dal-label">Approver</div>
            <div class="dal-value">
              <span class="approval-badge">CEO Approval</span>
            </div>
          </div>

          <div class="remarks-box">
            Requires Board endorsement.
          </div>

        </div>
      </div>

    </div>

    <!-- DESKTOP VIEW -->
    <div class="desktop-view">

      <div class="table-responsive">

        <table class="table table-bordered bg-white">

          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Malaysia</th>
              <th>Singapore</th>
              <th>Approver</th>
              <th>Remarks</th>
            </tr>
          </thead>

          <tbody>

            <tr class="dal-item">
              <td>1</td>
              <td>&gt; RM500k</td>
              <td>&gt; SGD500k</td>
              <td>CEO</td>
              <td>Requires Board endorsement</td>
            </tr>

          </tbody>

        </table>

      </div>

    </div>

  </div>

  <!-- ================================= -->
  <!-- NON CAPITAL SECTION -->
  <!-- ================================= -->

  <div id="noncapitalSection" class="dal-section hidden">

    <!-- MOBILE VIEW -->
    <div class="mobile-view">

      <div class="card dal-card dal-item">

        <div class="dal-header">
          Non-Capital Expenditure
        </div>

        <div class="dal-body">

          <div class="dal-row">
            <div class="dal-label">Malaysia</div>
            <div class="dal-value">≤ RM250k</div>
          </div>

          <div class="dal-row">
            <div class="dal-label">Singapore</div>
            <div class="dal-value">≤ SGD250k</div>
          </div>

          <div class="dal-row">
            <div class="dal-label">Approver</div>
            <div class="dal-value">
              <span class="approval-badge">Deputy CEO</span>
            </div>
          </div>

          <div class="remarks-box">
            Consultation with Group Legal required.
          </div>

        </div>
      </div>

      <div class="card dal-card dal-item">

        <div class="dal-header">
          Small Purchase Approval
        </div>

        <div class="dal-body">

          <div class="dal-row">
            <div class="dal-label">Malaysia</div>
            <div class="dal-value">≤ RM50k</div>
          </div>

          <div class="dal-row">
            <div class="dal-label">Approver</div>
            <div class="dal-value">
              <span class="approval-badge">GM Approval</span>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- DESKTOP VIEW -->
    <div class="desktop-view">

      <div class="table-responsive">

        <table class="table table-bordered bg-white">

          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Malaysia</th>
              <th>Singapore</th>
              <th>Approver</th>
              <th>Remarks</th>
            </tr>
          </thead>

          <tbody>

            <tr class="dal-item">
              <td>1</td>
              <td>≤ RM250k</td>
              <td>≤ SGD250k</td>
              <td>Deputy CEO</td>
              <td>Consultation with Group Legal required</td>
            </tr>

            <tr class="dal-item">
              <td>2</td>
              <td>≤ RM50k</td>
              <td>-</td>
              <td>GM</td>
              <td>-</td>
            </tr>

          </tbody>

        </table>

      </div>

    </div>

  </div>

</div>

<!-- JAVASCRIPT -->
<script>

  // ==========================
  // TAB SWITCHING
  // ==========================

  const tabButtons = document.querySelectorAll('.tab-btn');

  tabButtons.forEach(button => {

    button.addEventListener('click', function(){

      // Remove active styling
      tabButtons.forEach(btn => {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');
      });

      // Add active styling
      this.classList.remove('btn-outline-primary');
      this.classList.add('btn-primary');

      // Hide all sections
      document.querySelectorAll('.dal-section')
        .forEach(section => section.classList.add('hidden'));

      // Show selected section
      const tab = this.dataset.tab;

      if(tab === 'capital'){
        document.getElementById('capitalSection')
          .classList.remove('hidden');
      }

      if(tab === 'noncapital'){
        document.getElementById('noncapitalSection')
          .classList.remove('hidden');
      }

      // Clear search when switching tabs
      document.getElementById('searchInput').value = '';

      // Show all items again
      document.querySelectorAll('.dal-item')
        .forEach(item => item.classList.remove('hidden'));

    });

  });

  // ==========================
  // SEARCH FUNCTION
  // ==========================

  const searchInput = document.getElementById('searchInput');

  searchInput.addEventListener('keyup', function(){

    const keyword = this.value.toLowerCase();

    // Search only visible section
    const visibleSection = document.querySelector('.dal-section:not(.hidden)');

    const items = visibleSection.querySelectorAll('.dal-item');

    items.forEach(item => {

      const text = item.innerText.toLowerCase();

      if(text.includes(keyword)){
        item.classList.remove('hidden');
      }else{
        item.classList.add('hidden');
      }

    });

  });

</script>

</body>
</html>