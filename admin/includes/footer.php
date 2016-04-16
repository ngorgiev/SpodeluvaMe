  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="http://tinymce.cachefly.net/4.1/tinymce.min.js"></script>

    <script src="js/dropzone.js"></script>
    <script src="js/scripts.js"></script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

          var data = google.visualization.arrayToDataTable([
              ['Task', 'Hours per Day'],
              ['Прегледи',     <?php echo $session->count;?>],
              ['Коментари', <?php echo Comment::count_all();?>],
              ['Корисници',  <?php echo User::count_all();?>],
              ['Слики',      <?php echo Photo::count_all();?>]

          ]);

          var options = {
              legend:'none',
              pieSliceText:'label',
              title: 'Дневни Активности',
              backgroundColor:'transparent'
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));

          chart.draw(data, options);
      }
    </script>

</body>

</html>
