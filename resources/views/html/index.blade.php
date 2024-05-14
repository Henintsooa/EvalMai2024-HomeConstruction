@extends('parent')
@section('main')
<!--  Header End -->
<div class="container-fluid">
    @php
    $client = session('client');
    @endphp
    <h5 class="card-title fw-semibold">Welcome, {{ $client->numero }}</h5>
</div>
<div class="container-fluid">
    <!--  Row 1 -->
    <div class="row justify-content-center"> <!-- Ajout de la classe justify-content-center pour aligner horizontalement -->
        @foreach($prixMaisons as $prixMaison)
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="card-header text-center" style="background-color: #343333">
                    <h5 class="card-title mb-3 fw-semibold" style="color: white">{{$prixMaison->nomMaison}}</h5>
                </div>
                <div class="card-body text-center">
                  <h4 class="fw-semibold mb-3">{{ number_format($prixMaison->prixDevisTotal,4, ',', ' ') }} Ar</h4>

                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action d-flex justify-content-start align-items-center">
                            <a href="#" class="btn btn-success rounded-circle p-2 text-white d-inline-flex me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="">
                                <i class="ti ti-check fs-4"></i>
                            </a>
                            <span class="fw-semibold"> {{$prixMaison->nbrChambre}} Chambres</span>
                        </li>
                        <li class="list-group-item list-group-item-action d-flex justify-content-start align-items-center">
                            <a href="#" class="btn btn-success rounded-circle p-2 text-white d-inline-flex me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="">
                                <i class="ti ti-check fs-4"></i>
                            </a>
                            <span class="fw-semibold"> {{$prixMaison->nbrSalon}}  Salon</span>
                        </li>
                        <li class="list-group-item list-group-item-action d-flex justify-content-start align-items-center">
                            <a href="#" class="btn btn-success rounded-circle p-2 text-white d-inline-flex me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="">
                                <i class="ti ti-check fs-4"></i>
                            </a>
                            <span class="fw-semibold"> {{$prixMaison->nbrCuisine}} Cuisine </span>
                        </li>
                        <li class="list-group-item list-group-item-action d-flex justify-content-start align-items-center">
                          <a href="#" class="btn btn-success rounded-circle p-2 text-white d-inline-flex me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="">
                              <i class="ti ti-check fs-4"></i>
                          </a>
                          <span class="fw-semibold"> {{$prixMaison->nbrToilette}} Toilettes </span>
                      </li>
                    </ul>
                    <form action="{{route('finition') }}" method="get">
                    <div>
                        <input  class="form-check-input" type="radio" name="idMaison" value="{{$prixMaison->idMaison}}" id="{{$prixMaison->idMaison}}" class="me-2" style="transform: scale(1.5); margin-top: 10px;">
                    </div>

                </div>  
            </div>
        </div>
        @endforeach
        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-3" style="width: 300px;">Select</button> 
        </div>
                    </form>


    </div>
</div>
</div>
</div>
</div>
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="../assets/libs/simplebar/dist/simplebar.js"></script>
<script src="../assets/js/dashboard.js"></script>
</body>

</html>
@endsection
