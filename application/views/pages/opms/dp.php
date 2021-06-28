<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="form-group-create">
    <form action="<?= base_url('dp'); ?>" method="post" accept-charset="utf-8">
        <div class="row">
        <div class="col-sm-12"><h1>DP</h1></div>
        <div class="col-sm-3">Date Applied Range: </div>
        <div class="col-sm-6" style="padding-bottom: 1rem">
                <input type="date" name="from_date"></input>
                -
                <input type="date" name="to_date"></input>
        </div>
        <div class="col-sm-3"></div>

        <div class="col-sm-3">Region </div>
        <div class="col-sm-6" style="padding-bottom: 1rem">
            <select name="region"> 
                <?php foreach($region as $rg) : ?>
                    <option value="<?php echo $rg['name']; ?>"><?php echo $rg['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-3"></div>

        <div class="col-sm-4" style="padding-bottom: 1rem">
            <button type="submit" class="btn btn-primary">Generate</button>
        </div>
        <div class="col-sm-8"></div>

        <div class="col-sm-12" style="text-align:center">
            <h1><?php echo (isset($sregion) ? $sregion : ''); ?></h1>
            <p><?php echo (isset($datefrom) ? date_format(date_create($datefrom),"F d, Y") : ''); ?> - <?php echo (isset($dateto) ? date_format(date_create($dateto),"F d, Y") : ''); ?></p>
        </div>

        <div class="col-sm-12">
            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button> -->
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card --> 
        </div>

        <div class="col-sm-1"><b>EXPORT:</b></div>

        </div>
    </form> 
<table id="myTable" class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%" >
    <thead>
        <tr>
            <th>OPMS No.</th>
            <th>Permit No.</th>
            <th>Date Approved</th>
            <th>Year</th>
            <th>EMB Region</th>
            <th>Type of Wastewater</th>
            <th>Office Name</th>
            <th>Office Street</th>
            <th>Office Barangay</th>
            <th>Office City</th>
            <th>Office Province</th>
            <th>Branch Name</th>
            <th>ECC</th>
            <th>CNC</th>
            <th>Branch Street</th>
            <th>Branch Barangay</th>
            <th>Branch City</th>
            <th>Branch Province</th>
            <th>Branch Geolocation</th>
            <th>Type of Industry</th>
            <th>Volume of WW Discharge per Month</th>
            <th>Days per Month with Discharge</th>
            <th>Days per Year with Discharge</th>
            <th>Months of Operation in a year</th>
            <th>Volume of WW Discharge in a Year (cu.m / yr)</th>
            <th>Annual Production Capacity</th>
            <th>Actual Production in Previous year</th>
            <th>Type of Process</th>
            <th>Has Waste Treatment System</th>
            <th>Waste Treatment System Capacity (cu.m / day)</th>
            <th>Has Primary Treatment</th>
            <th>Has Secondary Treatment</th>
            <th>Has Chemical Treatment</th>
            <th>Status</th>
            <th>Application Date</th>
            <th>Valid Permit</th>
            <th>DP</th>
            <th>PCO Name</th>
            <th>PCO Accreditation No.</th>
            <th>PCO Accreditation / Submission of Application Date</th>
            <th>PCO Tel No.</th>
            <th>PCO Fax No.</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $approved = 0; 
        $process = 0; 
        $pending = 0; 
        $disapprove = 0; 
        $archive = 0; 
        $total = 0; 

        if (isset($dp)) : ?>
            <?php foreach($dp as $app) : ?>
                <?php 
                if ($app['Status'] == 'Approved'){
                    $approved = $approved + 1;
                }

                if ($app['Status'] == 'In-process (EMB)'){
                    $process = $process + 1;
                }

                if ($app['Status'] == 'Pending (applicant)'){
                    $pending = $pending + 1;
                }

                if ($app['Status'] == 'Disapproved'){
                    $disapprove = $disapprove + 1;
                }

                if ($app['Status'] == 'Archived'){
                    $archive = $archive + 1;
                }

                    $total = $total + 1;
                ?>
                <tr class="table-active"> 
                    <td><?php echo $app['OPMS No.']; ?></td>
                    <td><?php echo $app['Permit No.']; ?></td>
                    <td><?php echo $app['Date Approved']; ?></td>
                    <td><?php echo $app['Year']; ?></td>
                    <td><?php echo $app['EMB Region']; ?></td>
                    <td><?php echo $app['Type of Wastewater']; ?></td>
                    <td><?php echo $app['Office Name']; ?></td>
                    <td><?php echo $app['Office Street']; ?></td>
                    <td><?php echo $app['Office Barangay']; ?></td>
                    <td><?php echo $app['Office City']; ?></td>
                    <td><?php echo $app['Office Province']; ?></td>
                    <td><?php echo $app['Branch Name']; ?></td>
                    <td><?php echo $app['ECC']; ?></td>
                    <td><?php echo $app['CNC']; ?></td>
                    <td><?php echo $app['Branch Street']; ?></td>
                    <td><?php echo $app['Branch Barangay']; ?></td>
                    <td><?php echo $app['Branch City']; ?></td>
                    <td><?php echo $app['Branch Province']; ?></td>
                    <td><?php echo $app['Branch Geolocation']; ?></td>
                    <td><?php echo $app['Type of Industry']; ?></td>
                    <td><?php echo $app['Volume of WW Discharge per Month']; ?></td>
                    <td><?php echo $app['Days per Month with Discharge']; ?></td>
                    <td><?php echo $app['Months per Year with Discharge']; ?></td>
                    <td><?php echo $app['Days of Operation in a year']; ?></td>
                    <td><?php echo $app['Volume of WW Discharge in a Year (cu.m / yr)']; ?></td>
                    <td><?php echo $app['Annual Production Capacity']; ?></td>
                    <td><?php echo $app['Actual Production in Previous year']; ?></td>
                    <td><?php echo $app['Type of Process']; ?></td>
                    <td><?php echo $app['Has Waste Treatment System']; ?></td>
                    <td><?php echo $app['Waste Treatment System Capacity (cu.m / day)']; ?></td>
                    <td><?php echo $app['Has Primary Treatment']; ?></td>
                    <td><?php echo $app['Has Secondary Treatment']; ?></td>
                    <td><?php echo $app['Has Chemical Treatment']; ?></td>
                    <td><?php echo $app['Status']; ?></td>
                    <td><?php echo $app['Application Date']; ?></td>
                    <td><?php echo $app['Valid Permit']; ?></td>
                    <td><?php echo $app['DP']; ?></td>
                    <td><?php echo $app['PCO Name']; ?></td>
                    <td><?php echo $app['PCO Accreditation No.']; ?></td>
                    <td><?php echo $app['PCO Accreditation / Submission of Application Date']; ?></td>
                    <td><?php echo $app['PCO Tel No.']; ?></td>
                    <td><?php echo $app['PCO Fax No.']; ?></td>
                </tr>   
            <?php endforeach; ?>

            <input type="hidden" value='<?php echo $approved; ?>' name='approved'/>
            <input type="hidden" value='<?php echo $process; ?>' name='process' />
            <input type="hidden" value='<?php echo $pending; ?>' name='pending' />
            <input type="hidden" value='<?php echo $disapprove; ?>' name='disapprove' />
            <input type="hidden" value='<?php echo $archive; ?>' name='archive' />
            <input type="hidden" value='<?php echo $total; ?>' name='total' />
        <?php endif; ?>
    </tbody>
</table>
</div>
<!-- /.content-wrapper -->
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#myTable thead tr').clone(true).appendTo( '#myTable thead' );
    $('#myTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#myTable').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        orderCellsTop: true,
        fixedHeader: true,
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        
    } );
} );

    //-------------
    //- BAR CHART -
    //-------------
    var areaChartData = {
      labels  : ['Approved - '+$("input[name=approved]").val(), 'In-process (EMB) - '+$("input[name=process]").val(), 'Pending (applicant) - '+$("input[name=pending]").val(), 'Disapproved - '+$("input[name=disapprove]").val(), 'Archived - '+$("input[name=archive]").val()],
      datasets: [
        {
          label               : 'Total: '+ $("input[name=total]").val(),
          backgroundColor: [
                'rgba(75, 192, 192, 0.2)', //green
                'rgba(54, 162, 235, 0.2)', //blue
                'rgba(255, 206, 86, 0.2)', //yellow
                'rgba(255, 99, 132, 0.2)', //red
                'rgba(232, 232, 232, 1)' //violet
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)', //green
                'rgba(54, 162, 235, 1)', //blue
                'rgba(255, 206, 86, 1)', //yellow
                'rgba(255,99,132,1)', //red
                'rgba(232, 232, 232, 2)' //violet
            ],
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [$("input[name=approved]").val(), $("input[name=process]").val(), $("input[name=pending]").val(), $("input[name=disapprove]").val(), $("input[name=archive]").val()]
        }
      ]
    }
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    barChartData.datasets[0] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })
</script>