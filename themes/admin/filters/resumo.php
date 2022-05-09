<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-chart-pie"></i> Resumo</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
            <li class="breadcrumb-item active">Resumo</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid"><br>
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Filtrar por Período</h3>
        </div>
        <div class="card-body">
          <form action="<?= url("/resumo"); ?>" method="post">
            <div class="row"><input type="hidden" name="action" value="search" />
              <div class="col-4">
                <label>Data inicial:</label>
                <input type="text" class="form-control mask-date txt_data" value=<?= $inicial_date ?> id="inicial_date" name="inicial_date">
              </div>
              <div class="col-4">
                <label>Data final:</label>
                <input type="text" class="form-control mask-date txt_data" value=<?= $final_date ?> id="final_date" name="final_date">
              </div>
              <div class="col-md-4" style="margin-top:32px">
                <button class="btn btn-success">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </form>

        </div>
        <!-- /.card-body -->
      </div>
      <br>
      <div class="row">
        <div class="col-12" align="center">
          <h4><b>Retorno de Atendimentos</b></h4>
        </div>
      </div>
      <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Gráfico</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Tabela</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-three-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
              <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                </div>
              </div> <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
            </div>
            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
              <table class="table">
                <thead>
                  <tr>
                    <th>Atendimento</th>
                    <th>Quantidade</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $total_count_attendance = 0;
                  foreach ($attendance_returns as $i => $attendance_return) :
                    $count_attendance = 0;
                    foreach ($countAttendanceByReturn as $i => $each_countAttendanceByReturn) :
                      if ($each_countAttendanceByReturn->attendance_return_id == $attendance_return->id) :
                        $count_attendance = $each_countAttendanceByReturn->count_attendance;
                      endif;
                    endforeach;
                  ?>
                    <?php if ($count_attendance != 0) : ?>
                      <tr>
                        <td><?= $attendance_return->description ?></td>
                        <td><?= $count_attendance ?></td>
                      </tr>
                    <?php endif; ?>
                  <?php
                    $total_count_attendance = $total_count_attendance + $count_attendance;
                  endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td><b>Total</b></td>
                    <td><b><?= $total_count_attendance ?></b></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <br>
      <hr>
      <div class="row">
        <div class="col-12" align="center">
          <h4><b>Cliente Atendido Por Usuário</b></h4>
        </div>
      </div>
      <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-three-home-tab2" data-toggle="pill" href="#custom-tabs-three-home2" role="tab" aria-controls="custom-tabs-three-home2" aria-selected="true">Gráfico</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-three-profile-tab2" data-toggle="pill" href="#custom-tabs-three-profile2" role="tab" aria-controls="custom-tabs-three-profile2" aria-selected="false">Tabela</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-three-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-three-home2" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab2">
              <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <div class="tab-pane fade" id="custom-tabs-three-profile2" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab2">
              <table class="table">
                <thead>
                  <tr>
                    <th>Usuário</th>
                    <th>Quantidade de Atendimento</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $total_count_attendance = 0;
                  $count_attendance = 0;
                  foreach ($countAttendanceByUser as $i => $user) :
                    $count_attendance = 0;
                    $count_attendance = $user->count_attendance;
                  ?>
                    <?php if ($count_attendance != 0) : ?>
                      <tr>
                        <td><?= fullNameId($user->id) ?></td>
                        <td><?= $count_attendance ?></td>
                      </tr>
                    <?php endif; ?>
                  <?php
                    $total_count_attendance = $total_count_attendance + $count_attendance;
                  endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td><b>Total</b></td>
                    <td><b><?= $total_count_attendance ?></b></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <br>
      <hr>
      <div class="row">
        <div class="col-12" align="center">
          <h4><b>Atendimentos por Usuário</b></h4>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <select class="form-control select2bs4" style="width: 100%;" id="user" name="user">
            <option value="">--Selecione--</option>
            <?php if (!empty($users)) :
              foreach ($users as $user) : ?>
                <option value="<?= $user->id ?>"><?= $user->fullName() ?></option>
            <?php endforeach;
            endif; ?>
          </select>
        </div>
      </div><br>
      <div class="card card-primary card-outline card-tabs" id="div_chart" style="display:none">
        <div class="card-header p-0 pt-1 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-three-home-tab3" data-toggle="pill" href="#custom-tabs-three-home3" role="tab" aria-controls="custom-tabs-three-home3" aria-selected="true">Gráfico</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-three-profile-tab3" data-toggle="pill" href="#custom-tabs-three-profile3" role="tab" aria-controls="custom-tabs-three-profile3" aria-selected="false">Tabela</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-three-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-three-home3" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab3">
              <canvas id="donutChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <div class="tab-pane fade" id="custom-tabs-three-profile3" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab3">
              <div align="center" style="color:red"><h2>Em Breve</h2></div>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>


    </div><!-- /.container-fluid -->
  </section><br>
  <!-- /.content -->
</div><!-- /.content-wrapper-->

<?php $v->start("scripts"); ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
<script>
  $(document).ready(function() {
    var ctx = $("#chart-line");
    var myLineChart = new Chart(ctx, {
      type: 'horizontalBar',
      data: {
        labels: [
          <?php
          foreach ($attendance_returns as $i => $attendance_return) :
            echo json_encode($attendance_return->description, JSON_NUMERIC_CHECK) . ",";
          endforeach;
          ?>
        ],
        datasets: [{
          data: [
            <?php
            foreach ($countAttendanceByReturn as $i => $each_countAttendanceByReturn) :
              echo json_encode($each_countAttendanceByReturn->count_attendance, JSON_NUMERIC_CHECK) . ",";
            endforeach;
            ?>
          ],
          label: "",
          borderColor: "#458af7",
          backgroundColor: '#458af7',
          fill: false
        }, ]
      },
      options: {
        title: {
          display: true,
          text: ''
        }
      }
    });
  });
</script>

<script>
  $(function() {

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData = {

      labels: [
        <?php
        foreach ($countAttendanceByUser as $i => $user) :
          echo json_encode(fullNameId($user->id), JSON_NUMERIC_CHECK) . ",";
        endforeach;
        ?>
      ],
      datasets: [{
        data: [
          <?php
          foreach ($countAttendanceByUser as $i => $each_attendance) :
            echo json_encode($each_attendance->count_attendance, JSON_NUMERIC_CHECK) . ",";
          endforeach;
          ?>

        ],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#A9A9A9', '#0000FF', '#7FFFD4', '#CD853F', '#BA55D3', '#FFB6C1', '#FA8072', '#CD5C5C', '#FFFF00'],
      }]
    }
    var donutOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    $("#user").change(function() {
      if ($("#user").val() != "") {
        $("#div_chart").show();
        var numeros = [];
        var attendance_id = [];
        $.getJSON(path + '/resume/attendance/user/<?= date_fmt_back($inicial_date) ?>/<?= date_fmt_back($final_date) ?>/' + $("#user").val(), function(data) {
          $.each(data.resume, function(i, obj) {
            attendance_id[i] = obj.description
            numeros[i] = parseInt(obj.count_attendance)
          })

          const retornoMap = numeros.map((numerosAtual) => {
            return numerosAtual;
          })

          const retornoMap2 = attendance_id.map((attendanceAtual) => {
            return attendanceAtual;
          })

          var donutChartCanvas = $('#donutChart2').get(0).getContext('2d')
          var donutData = {

            labels: retornoMap2,
            datasets: [{
              data: retornoMap,
              backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#A9A9A9', '#0000FF', '#7FFFD4', '#CD853F', '#BA55D3', '#FFB6C1', '#FA8072', '#CD5C5C', '#FFFF00'],
            }]
          }

          var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
          }
          //Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          var donutChart = new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
          })
        })
      } else {
        $("#div_chart").hide();
      }
    })

  });
</script>
<?php $v->end(); ?>