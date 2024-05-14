@extends('parent')
@section('main')
      <!--  Header End -->
      <div class="" style="margin-top: 100px; margin-right: 100px" >
        
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        
        <div class="col-lg-12 d-flex align-items-stretch">
          <div class="card ">
            <div class="card-body p-6">
              <h5 class="card-title fw-semibold mb-4">Liste Devis du client {{ $listeDevis[0]->numero }}</h5>
              
              <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            
                          <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Maison</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'dateVente', 'order' => $nextOrder]) }}">Date</a> --}}
                          </th>
                        
                        
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Finition</h6>
                                {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'nomUser', 'order' => $nextOrder]) }}">Nom User</a> --}}
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Date Debut</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'nomPack', 'order' => $nextOrder]) }}">Nom Pack</a> --}}
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Date Fin</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'montantPack', 'order' => $nextOrder]) }}">Type Pack</a> --}}
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Total Ar</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'prixTotal', 'order' => $nextOrder]) }}">Prix total</a> --}}
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Payé</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'payer', 'order' => $nextOrder]) }}">Montant payé</a> --}}
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Reste</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'resteAPayer', 'order' => $nextOrder]) }}">Reste</a> --}}
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Etat</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'payer', 'order' => $nextOrder]) }}">Payer</a> --}}
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Détails</h6>
                              {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'quantite', 'order' => $nextOrder]) }}">Quantité</a> --}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listeDevis as $devis)
                        <tr>

                            
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">Maison {{ $devis->idMaison }}</p>
                              {{-- <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($devis->dateVente)->isoFormat('D MMMM YYYY') }}</p> --}}
                            </td>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">{{ $devis->nomFinition }}</p>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($devis->DateDebut)->isoFormat('D MMMM YYYY')  }}</p>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($devis->DateFin)->isoFormat('D MMMM YYYY')  }} </p>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">{{ number_format($devis->prixTotal,2, ',', ' ') }} Ar</p>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">{{ number_format($devis->payer,2, ',', ' ') }} Ar</p>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">{{ number_format($devis->resteAPayer,2, ',', ' ') }} Ar</p>
                      
                            </td>
                            <td class="border-bottom-0 ">
                              <p class="badge bg-danger mb-0 fw-normal">{{ $devis->etatPaiement }}</p>
                            </td>
                            <td class="border-bottom-0">
                              <a href="{{route('detailsDevis')}}?idDevis={{ $devis->idDevis }}&idDemandeDevis={{ $devis->idDemandeDevis }}" class="btn btn-primary btn-sm">Détails</a>
                            </td>
                            <td class="border-bottom-0">
                              <a href="{{route('paiement', ['idDemandeDevis' => $devis->idDemandeDevis]) }}" class="btn btn-success btn-sm">Payer</a>
                            </td>
                            <td class="border-bottom-0">
                              <a href="{{ route('pdfDevis')}}?idDevis={{ $devis->idDevis }}&idDemandeDevis={{ $devis->idDemandeDevis }}" class="fw-semibold mb-0 sort-link">Export Pdf</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
              
              </div>
            </div>
          </div>
        </div>
        
  </div>

</body>

</html>
@endsection
