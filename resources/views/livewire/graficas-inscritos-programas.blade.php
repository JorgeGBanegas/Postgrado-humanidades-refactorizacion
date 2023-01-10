<div class="row" style="height: auto;">
    <div class="d-flex col-5 shadow rounded p-4 border bg-white " style="margin: 5px ;height: 20rem;">
        <div class="bg-white">
            <livewire:livewire-pie-chart :pie-chart-model=" $pieChartModel1" />
        </div>
        <div class="bg-white" style="display: flex; justify-content: center; align-items: center;">
            <ul class="p-0 m-0">

                @for ($i = 0; $i < sizeof($modalidades); $i++) <li class="d-flex mb-4 pb-1">
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0" style="color: <?php echo $colores[$i]; ?>">{{$modalidades[$i]}} </h6>
                        </div>
                        <div class="user-progress">
                            <h6 class="mb-0" style="color: <?php echo $colores[$i]; ?>">{{$cantidadesPorModalidad[$i]}} </h6>
                        </div>
                    </div>
                    </li>
                    @endfor
            </ul>
        </div>
    </div>

    <div class="d-flex col-6 shadow rounded p-4 border bg-white " style="margin:5px; height: 20rem;">
        <div class="bg-white">
            <livewire:livewire-pie-chart :pie-chart-model=" $pieChartModel2" />
        </div>
        <div class="bg-white" style="display: flex; justify-content: center; align-items: center;">
            <ul class="p-0 m-0">

                @for ($i = 0; $i < sizeof($tipoPrograma); $i++) <li class="d-flex mb-4 pb-1">
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0" style="color: <?php echo $colores[$i]; ?>">{{$tipoPrograma[$i]}} </h6>
                        </div>
                        <div class="user-progress">
                            <h6 class="mb-0" style="color: <?php echo $colores[$i]; ?>">{{$cantidadesPorTipoPrograma[$i]}} </h6>
                        </div>
                    </div>
                    </li>
                    @endfor
            </ul>
        </div>
    </div>

    <div class="d-flex shadow rounded p-4 border bg-white col-11" style="margin:5px; height: 25rem;">
        <div class="bg-white col-11">
            <livewire:livewire-pie-chart :pie-chart-model=" $pieChartModel3" />
        </div>
    </div>

</div>