<?php
$options = array();
$to_day = date('Y/m/d');

for($i=1; $i<=12; $i++){
   $options[$i] = $i;
}
?>
<div class="col-md-9 col-lg-10 main">
   <!--toggle sidebar button
      <p class="hidden-md-up">
          <button type="button" class="btn btn-primary-outline btn-sm" data-toggle="offcanvas"><i class="fa fa-chevron-left"></i> Menu</button>
      </p>-->
   <h1 class="display-2 hidden-xs-down">
      Thống kê các bảng
   </h1>
   <p class="lead hidden-xs-down">Tổng số các bảng</p>
   <div class="row mb-3">
      <div class="col-xl-3 col-lg-6">
         <div class="card card-inverse card-success">
            <div class="card-block bg-success">
               <div class="rotate">
                  <i class="fa fa-user fa-4x"></i>
               </div>
               <h6 class="text-uppercase">Người dùng:</h6>
               <h1 class="display-1"><?= $count_users?></h1>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-lg-6">
         <div class="card card-inverse card-danger">
            <div class="card-block bg-danger">
               <div class="rotate">
                  <i class="fa fa-film fa-4x" aria-hidden="true"></i>
               </div>
               <h6 class="text-uppercase">Tổng phim chiếu:</h6>
               <h1 class="display-1"><?= $count_movies?></h1>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-lg-6">
         <div class="card card-inverse card-info">
            <div class="card-block bg-info">
               <div class="rotate">
                  <i class="fa fa-list fa-4x"></i>
               </div>
               <h6 class="text-uppercase">Danh mục: </h6>
               <h1 class="display-1"><?= $count_categories?></h1>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-lg-6">
         <div class="card card-inverse card-warning">
            <div class="card-block bg-warning">
               <div class="rotate">
                  <i class="fa fa-list fa-4x"></i>
               </div>
               <h6 class="text-uppercase">Thể loại:</h6>
               <h1 class="display-1"><?= $count_genres?></h1>
            </div>
         </div>
      </div>
   </div>
   <!--/row-->
   <hr>
   <div class="row">
      <div class="col-xl-12 col-lg-6">
         <p class="lead hidden-xs-down"></p>
         <?php echo $this->Form->control('chartjs', [
            'label' => 'Thống kê số lượng phim theo tháng: ',
            'options'=> $options,
            'id' => 'selectChart',
            'style'=> 'margin-left: 5px; width:50px'
         ]); ?>
         <canvas id="chartData" style="width:100%; height: 300px;"></canvas>
      </div>
   </div>
</div>
<!--/main col-->
<script>
   $(function(){
      var ctx = document.getElementById('chartData').getContext('2d');
      var chartData;
      let month_current = parseInt(`<?php echo date("m", strtotime($to_day)) ?>`);
      let year_month = parseInt(`<?php echo date("Y", strtotime($to_day))?>`);
      $.ajax({
        url : '<?php echo $this->Url->build(['_name'=>'admin_graph'])?>',
        type: 'post',
        dataType:'json',
        data:{
            _csrfToken: $("meta[name=csrfToken]").attr('content'),
           month: month_current,
           year:  year_month
        },
        success: function(response){
            const labels = response.count_value_month.value;
            const data = {
               labels: labels,
               datasets: [{
                  label: 'Tổng số phim',
                  data: response.count_value_month.count,
                  fill: false,
                  borderColor: 'rgb(75, 192, 192)',
                  tension: 0.1
               }]
            };
            const config = {
               type: 'line',
               data: data,
            };
            chartData = new Chart($('#chartData'), config);
        },
         error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
         }
      });
      $('#selectChart').val(month_current);
      
      $('#selectChart').on('change', function(){
         //ajax(Chưa viết gì hết)
         $.ajax({
         url : '<?php echo $this->Url->build(['_name'=>'admin_graph'])?>',
         type: 'post',
         dataType:'json',
         data:{
            _csrfToken: $("meta[name=csrfToken]").attr('content'),
            month: $(this).val(),
            year:  year_month
         },
         success: function(response){            
            chartData.data.labels = response.count_value_month.value;
            chartData.data.datasets.forEach((dataset) => {
               dataset.data = response.count_value_month.count;
            });
            chartData.update();
         },
         error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
         }
         });
      })
   })

   // const ctx = document.getElementById('chartData').getContext('2d');
   // const labels = <?php //echo json_encode($month)?>;
   // const data = {
   //    labels: labels,
   //    datasets: [{
   //       label: 'Tổng số phim: ',
   //       data: <?php //echo json_encode($count_value_month)?>,
   //       fill: false,
   //       borderColor: 'rgb(75, 192, 192)',
   //       tension: 0.1
   //    }]
   // };
   // const config = {
   //    type: 'line',
   //    data: data,
   // };
   // const chartData = new Chart(ctx, config);
</script>