<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="form-group-create">
    <form action="<?= base_url('pcl'); ?>" method="post" accept-charset="utf-8">
        <div class="row">
        <div class="col-sm-12"><h1>PCL</h1></div>
        <div class="col-sm-3">Date Applied Range: </div>
        <div class="col-sm-6" style="padding-bottom: 1rem">
                <input type="date" name="from_date"></input>
                -
                <input type="date" name="to_date"></input>
        </div>
        <div class="col-sm-3"></div>

        <div class="col-sm-4" style="padding-bottom: 1rem">
            <button type="submit" class="btn btn-primary">Generate</button>
        </div>
        <div class="col-sm-8"></div>

        <div class="col-sm-12" style="text-align:center">
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
            <th>Certificate No.</th>
            <th>Company Name</th>
            <th>Applicant Category</th>
            <th>Application Type</th>
            <th>EMB Region</th>
            <th>Chemical Name</th>
            <th>CAS No.</th>
            <th>Quantity</th>
            <th>Quantity Unit</th>
            <th>Plant Address Full</th>
            <th>Plant Address City/Municipality</th>
            <th>Plant Address Province</th>
            <th>Date Started</th>
            <th>Date Approved</th>
            <th>Status</th>
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

        if (isset($pcl)) : ?>
            <?php foreach($pcl as $app) : ?>
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
                    <td><?php echo $app['Certificate No.']; ?></td>
                    <td><?php echo $app['Company Name']; ?></td>
                    <td><?php echo $app['Applicant Category']; ?></td>
                    <td><?php echo $app['Application Type']; ?></td>
                    <td><?php echo $app['EMB Region']; ?></td>
                    <td><?php echo $app['Chemical Name']; ?></td>
                    <td><?php echo $app['CAS No.']; ?></td>
                    <td><?php echo $app['Quantity']; ?></td>
                    <td><?php echo $app['Quantity Unit']; ?></td>
                    <td><?php echo $app['Plant Address Full']; ?></td>
                    <td><?php echo $app['Plant Address City/Municipality']; ?></td>
                    <td><?php echo $app['Plant Address Province']; ?></td>
                    <td><?php echo $app['Date Started']; ?></td>
                    <td><?php echo $app['Date Approved']; ?></td>
                    <td><?php echo $app['Status']; ?></td>
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