@extends('parent')
@section('main')
  <!--  Header End -->
  <div class="container-fluid">
    
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
      <div class="card w-100">
        <div class="card-body p-6">
          <h5 class="card-title fw-semibold mb-4">Informations</h5>
          <div><strong>Client :</strong> {{ $listeDevis->numero }}</div>
          <div><strong>Maison :</strong> {{ $listeDevis->nomMaison }}</div>
          <div><strong>Lieu :</strong> {{ $listeDevis->lieu }}</div>
          <div><strong>Finition :</strong> {{ $listeDevis->nomFinition }} , {{ $listeDevis->pourcentage }} %</div>
          <div><strong>Date Debut :</strong> {{ \Carbon\Carbon::parse($listeDevis->DateDebut)->isoFormat('D MMMM YYYY') }}</div>
          <div><strong>Date Fin :</strong> {{ \Carbon\Carbon::parse($listeDevis->DateFin)->isoFormat('D MMMM YYYY') }}</div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
    <div class="card-body p-6">
      <h5 class="card-title fw-semibold mb-4">Details Travaux</h5>
      
      <div class="table-responsive">
        <table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4">
        <tr>
            
          <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">N°</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'dateVente', 'order' => $nextOrder]) }}">Date</a> --}}
          </th>
        
        
            <th class="border-bottom-0">
            <h6 class="fw-semibold mb-0">Designation</h6>
            {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'nomUser', 'order' => $nextOrder]) }}">Nom User</a> --}}
            </th>
            <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">U</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'nomPack', 'order' => $nextOrder]) }}">Nom Pack</a> --}}
            </th>
            <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">Q</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'montantPack', 'order' => $nextOrder]) }}">Type Pack</a> --}}
            </th>
            <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">PU</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'prixTotal', 'order' => $nextOrder]) }}">Prix total</a> --}}
            </th>
            <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">Total</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'payer', 'order' => $nextOrder]) }}">Montant payé</a> --}}
            </th>
            
        </tr>
        </thead>
        <tbody>
        @php
            $currentHundred = null;
            $sum = 0;
            $sumTotal = 0;
        @endphp
        @foreach($detailsDevis as $detail)
            @php
            $hundred = floor($detail->numero / 100) * 100;
            if ($currentHundred !== $hundred) {
            if ($currentHundred !== null) {
                echo '<tr>';
                echo '<td colspan="4" class="border-bottom-0"></td>';
                echo '<td class="border-bottom-0 text-end"><p class="mb-0 fw-normal"></p></td>';
                echo '<td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">' . number_format($sum, 2, ',', ' ') . ' Ar</p></td>';
                echo '</tr>';
            }
            $currentHundred = $hundred;
            $sum = 0;
            }
            $sum += $detail->prixTotal;
            $sumTotal += $detail->prixTotal;
            @endphp

            <tr>
            <td class="border-bottom-0">
              <p class="mb-0 fw-normal"> {{ $detail->numero }}</p>
              {{-- <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($detail->dateVente)->isoFormat('D MMMM YYYY') }}</p> --}}
            </td>
            <td class="border-bottom-0">
              <p class="mb-0 fw-normal">{{ $detail->designation }}</p>
            </td>
            <td class="border-bottom-0">
              <p class="mb-0 fw-normal">{{ $detail->unite  }}</p>
            </td>
            <td class="border-bottom-0">
              <p class="mb-0 fw-normal">{{ $detail->quantite  }} </p>
            </td>
            <td class="border-bottom-0 text-end">
              <p class="mb-0 fw-normal">{{ number_format($detail->pu,2, ',', ' ') }} Ar</p>
            </td>
            <td class="border-bottom-0 text-end">
              <p class="mb-0 fw-normal">{{ number_format($detail->prixTotal,2, ',', ' ') }} Ar</p>
            </td>
            </tr>
        @endforeach

        @if ($currentHundred !== null)
            <!-- Create a row for the last hundred and display the sum -->
            <tr>
            <td colspan="4" class="border-bottom-0"></td>
            <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal"></p></td>
            <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">{{ number_format($sum, 2, ',', ' ') }} Ar</p></td>
            </tr>
        @endif
        <tr>
          <td colspan="4" class="border-bottom-0"></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">Total</p></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">{{ number_format($sumTotal, 2, ',', ' ') }} Ar</p></td>
        </tr>
        <tr>
          <td colspan="4" class="border-bottom-0"></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">Finition:</p></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">{{ number_format($listeDevis->prixPourcentage,2, ',', ' ') }} Ar</p></td>
        </tr>
        <tr>
          <td colspan="4" class="border-bottom-0"></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">Somme Total:</p></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">{{ number_format($sumTotal+$listeDevis->prixPourcentage, 2, ',', ' ') }} Ar</p></td>
        </tr>
        </tbody>
        </table>

      
      </div>


      <div class="table-responsive">
        <table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4">
        <tr>
            
          <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">Date Paiement</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'dateVente', 'order' => $nextOrder]) }}">Date</a> --}}
          </th>
        
        
            <th class="border-bottom-0">
            <h6 class="fw-semibold mb-0">Payé</h6>
            {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'nomUser', 'order' => $nextOrder]) }}">Nom User</a> --}}
            </th>
            <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">refDevis</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'nomPack', 'order' => $nextOrder]) }}">Nom Pack</a> --}}
            </th>
            <th class="border-bottom-0">
          <h6 class="fw-semibold mb-0">refPaiement</h6>
          {{-- <a class="fw-semibold mb-0 sort-link" href="{{ route('vente.tri', ['sort' => 'montantPack', 'order' => $nextOrder]) }}">Type Pack</a> --}}
            </th>
        </tr>
        </thead>
        <tbody>
        @php
            $sumTotal = 0;
        @endphp
        @foreach($histoPaiement as $histo)
            @php
            $sumTotal += $histo->payer;
            @endphp

            <tr>
            <td class="border-bottom-0">
          <div> {{ \Carbon\Carbon::parse($histo->datePaiement)->isoFormat('D MMMM YYYY') }}</div>
              {{-- <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($histo->dateVente)->isoFormat('D MMMM YYYY') }}</p> --}}
            </td>
            <td class="border-bottom-0">
              <p class="mb-0 fw-normal">{{ $histo->payer  }}</p>
            </td>
            <td class="border-bottom-0">
              <p class="mb-0 fw-normal">{{ $histo->refDevis  }}</p>
            </td>
            <td class="border-bottom-0">
              <p class="mb-0 fw-normal">{{ $histo->refPaiement  }} </p>
            </td>
            
            </tr>
        @endforeach

        
        <tr>
          <td colspan="4" class="border-bottom-0"></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">Total</p></td>
          <td class="border-bottom-0 text-end"><p class="mb-0 fw-normal">{{ number_format($sumTotal, 2, ',', ' ') }} Ar</p></td>
        </tr>
       
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