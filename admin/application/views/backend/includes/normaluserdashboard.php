<div class="row">
       <div class="col-md-5">
          <div class="well" style="text-align:center;">
              Most Searched Products
          </div>
           <div class="row">
                <div class="col-md-5">
                    <div class="well" style="text-align:center;">
                    <p>Most Searched Product Of Month</p>
                    </div>
                    <div class="row state-overview"  >
                        <table class="table table-striped table-hover border-top " id="sample_99" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <!--<th>Id</th>-->
                                    <th>Product Name</th>
                                    <th>Search Times</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($toptenproductsearchmonth as $row) { ?>
                                    <tr>
                                        <!--<td><?php echo $row->id; ?></td>-->
                                        <td><?php echo $row->productname; ?></td>
                                        <td><?php echo $row->count1; ?></td>
                                        <td><img class="img" height="100px" width="100px"src="http://www.lylaloves.co.uk/showimage?size=300&amp;image=<?php echo $row->image; ?>"></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5">
                    <div class="well" style="text-align:center;">
                    <p>Most Searched Product Of the Year</p>
                    </div>
                    <div class="row state-overview"  >
                        <table class="table table-striped table-hover border-top " id="sample_99" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <!--<th>Id</th>-->
                                    <th>Product Name</th>
                                    <th>Search Times</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($toptenproductsearchyear as $row) { ?>
                                    <tr>
                                        <!--<td><?php echo $row->id; ?></td>-->
                                        <td><?php echo $row->productname; ?></td>
                                        <td><?php echo $row->count1; ?></td>
                                        <td><img class="img" height="100px" width="100px"src="http://www.lylaloves.co.uk/showimage?size=300&amp;image=<?php echo $row->image; ?>"></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

       <div class="col-md-1">
        </div>
       <div class="col-md-5">
          <div class="well" style="text-align:center;">
              Most Viewed Products
          </div>
           <div class="row">
                <div class="col-md-5">
                    <div class="well" style="text-align:center;">
                    <p>Most viewed Product Of Month</p>
                    </div>
                    <div class="row state-overview"  >
                        <table class="table table-striped table-hover border-top " id="sample_99" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <!--<th>Id</th>-->
                                    <th>Product Name</th>
                                    <th>Search Times</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($toptenproductviewmonth as $row) { ?>
                                    <tr>
                                        <!--<td><?php echo $row->id; ?></td>-->
                                        <td><?php echo $row->productname; ?></td>
                                        <td><?php echo $row->count1; ?></td>
                                        <td><img class="img" height="100px" width="100px"src="http://www.lylaloves.co.uk/showimage?size=300&amp;image=<?php echo $row->image; ?>"></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5">
                    <div class="well" style="text-align:center;">
                    <p>Most Viewed Product Of the Year</p>
                    </div>
                    <div class="row state-overview"  >
                        <table class="table table-striped table-hover border-top " id="sample_99" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <!--<th>Id</th>-->
                                    <th>Product Name</th>
                                    <th>Search Times</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($toptenproductviewyear as $row) { ?>
                                    <tr>
                                        <!--<td><?php echo $row->id; ?></td>-->
                                        <td><?php echo $row->productname; ?></td>
                                        <td><?php echo $row->count1; ?></td>
                                        <td><img class="img" height="100px" width="100px"src="http://www.lylaloves.co.uk/showimage?size=300&amp;image=<?php echo $row->image; ?>"></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
       <div class="col-md-5">
          <div class="well" style="text-align:center;">
              Best Selling Products
          </div>
           <div class="row">
                <div class="col-md-5">
                    <div class="well" style="text-align:center;">
                    <p>Best Selling Products Of Month</p>
                    </div>
                    <div class="row state-overview"  >
                        <table class="table table-striped table-hover border-top " id="sample_99" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <!--<th>Id</th>-->
                                    <th>Product Name</th>
                                    <th>Times</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($toptenbestsellingproductmonth as $row) { ?>
                                    <tr>
                                        <!--<td><?php echo $row->id; ?></td>-->
                                        <td><?php echo $row->productname; ?></td>
                                        <td><?php echo $row->count1; ?></td>
                                        <td><img class="img" height="100px" width="100px"src="http://www.lylaloves.co.uk/showimage?size=300&amp;image=<?php echo $row->image; ?>"></td>
                                        
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5">
                    <div class="well" style="text-align:center;">
                    <p>Best Selling Product Of All Time</p>
                    </div>
                    <div class="row state-overview"  >
                        <table class="table table-striped table-hover border-top " id="sample_99" cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <!--<th>Id</th>-->
                                    <th>Product Name</th>
                                    <th>Times</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($toptenbestsellingproductalltime as $row) { ?>
                                    <tr>
                                        <!--<td><?php echo $row->id; ?></td>-->
                                        <td><?php echo $row->productname; ?></td>
                                        <td><?php echo $row->count1; ?></td>
                                        <td><img class="img" height="100px" width="100px"src="http://www.lylaloves.co.uk/showimage?size=300&amp;image=<?php echo $row->image; ?>"></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

       <div class="col-md-1">
        </div>
       <div class="col-md-5" style="display:none;">
        </div>
    </div>
<!--
	  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawStuff);
        
      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Months', 'Revenue'],
          ["Jan", <?php echo $monthrevenue[1];?>],
            ["Feb", <?php echo $monthrevenue[2];?>],
            ["March", <?php echo $monthrevenue[3];?>],
            ["April", <?php echo $monthrevenue[4];?>],
            ["May", <?php echo $monthrevenue[5];?>],
            ["June", <?php echo $monthrevenue[6];?>],
            ["July", <?php echo $monthrevenue[7];?>],
            ["Aug", <?php echo $monthrevenue[8];?>],
            ["Sept", <?php echo $monthrevenue[9];?>],
            ["Oct", <?php echo $monthrevenue[10];?>],
            ["Nov", <?php echo $monthrevenue[11];?>],
            ["Dec", <?php echo $monthrevenue[12];?>]

        ]);

        var options = {
          title: 'This Year Revenue Graph',
          width: 900,
          legend: { position: 'none' },
          chart: { title: 'This Year Revenue Graph',
                   subtitle: 'Revenue Per Month' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Revenue'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
    <div class="well" style="text-align:center;">
              Revenue Graph Of The Year
          </div>
	<div id="top_x_div" style="width: 900px; height: 500px;"></div>


-->

</main>
