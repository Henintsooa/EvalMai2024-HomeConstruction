@extends('parent')
@section('main')
      <!--  Header End -->
      <div class="container-fluid">
        <h5 class="card-title fw-semibold">Bienvenue, {{ $user->name }}</h5>
      </div>
      <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-4">
            <div class="row">
              {{-- <div class="col-lg-12">
                <!-- Yearly Breakup -->
                
              </div> --}}
              <div class="col-lg-12">
                <!-- Monthly Earnings -->
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                        <h5 class="card-title mb-9 fw-semibold"> Montant Total des devis </h5>
                        <h4 class="fw-semibold mb-3">{{ number_format($prixTotal,2, ',', ' ') }} Ar</h4>
                        <div class="d-flex align-items-center pb-1">
                          
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-end">
                          <div
                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-currency-dollar fs-6"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                        <h5 class="card-title mb-9 fw-semibold"> Montant Total de paiement effectué </h5>
                        <h4 class="fw-semibold mb-3">{{ number_format($payer,2, ',', ' ') }} Ar</h4>
                        <div class="d-flex align-items-center pb-1">
                          
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-end">
                          <div
                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-currency-dollar fs-6"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Montant des devis par mois et année</h5>
                    </div>
                    <div>
                    <form method="POST" action="{{ route('histogramme') }}">
                      @csrf
                      <div class="d-flex align-items-center">
                      <select name="date" class="form-select me-2" id="yearSelector">
                        <option value="">Choisir année</option>
                        @foreach ($annees as $item)
                        <option value="{{ $item->annee }}">{{ $item->annee }}</option>
                        @endforeach
                      </select>
                      <button type="submit" class="btn btn-success">Valider</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
                <div id="chart"></div>
              </div>
            </div>
          </div>
          <form method="POST" action="{{ url('/reset-database') }}">
            @csrf
            <button type="submit" class="btn btn-danger ">Réinitialiser la base de données</button>
          </form>
        </div>
        
      </div>
    
  <script src="../assets/libs/apexcharts/dist/apexcharts.js"></script>
    
  <script>
    document.addEventListener('DOMContentLoaded', function () {

        var donneesHistogrammeData = @json($donneesHistogramme) ;
        var mois = donneesHistogrammeData.map(function(item) {
          // Convertir le chiffre de mois en nom de mois correspondant
          var moisString = '';
          switch (item.mois) {
              case 1:
                  moisString = 'Janvier';
                  break;
              case 2:
                  moisString = 'Février';
                  break;
              case 3:
                  moisString = 'Mars';
                  break;
              case 4:
                  moisString = 'Avril';
                  break;
              case 5:
                  moisString = 'Mai';
                  break;
              case 6:
                  moisString = 'Juin';
                  break;
              case 7:
                  moisString = 'Juillet';
                  break;
              case 8:
                  moisString = 'Août';
                  break;
              case 9:
                  moisString = 'Septembre';
                  break;
              case 10:
                  moisString = 'Octobre';
                  break;
              case 11:
                  moisString = 'Novembre';
                  break;
              case 12:
                  moisString = 'Décembre';
                  break;
              default:
                  moisString = ''; // Gérer le cas par défaut si nécessaire
          }
          return moisString;
        });   
        
        var devis = donneesHistogrammeData.map(function(item) {
          return parseInt(item.montantDevis);
        });
        // Initialiser les données de base
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Devis',
                data: devis // Données de vente initiales (vous pouvez les remplacer par des données réelles)
            }],
            xaxis: {
                categories: mois // Mois initiaux (vous pouvez les remplacer par des mois réels)
            }
        };
  
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
  
        // Mettre à jour les données lorsque l'utilisateur sélectionne un mois différent
        document.getElementById('monthSelector').addEventListener('change', function () {
            // Récupérer la valeur sélectionnée
            var selectedMonth = this.value;
            // Récupérer les données de vente pour le mois sélectionné à partir de votre backend (par exemple, via une requête AJAX)
  
            // Mettre à jour les données de vente et les libellés des mois
            // Supposons que les données de vente soient stockées dans un tableau appelé `salesData`
            var salesData = [/* Données de vente pour le mois sélectionné */];
            var monthsLabels = [/* Libellés des mois pour le mois sélectionné */];
  
            // Mettre à jour les données du graphique
            chart.updateSeries([{ data: salesData }]);
            chart.updateOptions({ xaxis: { categories: monthsLabels } });
        });
    });
  </script>
</body>

</html>
@endsection