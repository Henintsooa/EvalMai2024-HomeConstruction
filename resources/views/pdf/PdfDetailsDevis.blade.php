<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Home Construction</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-xxl7Dwv5P6LsqZk9aRm+3v2Q3xVLgpimWnX+roTCqC5Rr/YNR3fdXtR+Qmfzp/1zIhP2IsYMDJxBS9K2aKJ8sA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
    }
  
    .container {
      margin: 20px;
    }
  
    .alert {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      margin-bottom: 20px;
    }
  
    .card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
  
    .card-title {
      font-size: 24px;
      margin-bottom: 20px;
    }
  
    .info-section {
      margin-bottom: 20px;
    }
  
    .info-item {
      margin-bottom: 10px;
    }
  
    .info-label {
      font-weight: bold;
    }
  
    .table-wrapper {
      overflow-x: auto;
    }
  
    .custom-table {
      width: 100%;
      border-collapse: collapse;
    }
  
    .custom-table thead {
      background-color: #f8f9fa;
    }
  
    .custom-table th,
    .custom-table td {
      padding: 10px;
      text-align: center; /* Added this line to center align the content */
    }
  
    .custom-table th {
      font-weight: bold;
    }
  
    .custom-table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  
    .custom-table tbody tr:hover {
      background-color: #e9ecef;
    }
  
    .custom-table tfoot td {
      font-weight: bold;
    }
    
    /* Ajoutez ces classes CSS personnalisées */
    .custom-table .pu-column {
      width: 120px; /* Ajustez la largeur selon vos besoins */
    }
    
    .custom-table .total-column {
      width: 120px; /* Ajustez la largeur selon vos besoins */
    }
  </style>
</head>
</head>

<body>

<div class="container">
  
  @if($errors->any())
  <div class="alert alert-danger" role="alert">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
  </div>
  @endif

  <div class="card">
    <div class="card-body">
      <h2 class="card-title">Informations</h2>
      <div class="info-section">
        <div class="info-item">
          <span class="info-label">Client :</span> {{ $listeDevis->numero }}
        </div>
        <div class="info-item">
          <span class="info-label">Maison :</span> {{ $listeDevis->idMaison }}
        </div>
        <div class="info-item">
          <span class="info-label">Date Debut :</span> {{ \Carbon\Carbon::parse($listeDevis->DateDebut)->isoFormat('D MMMM YYYY') }}
        </div>
        <div class="info-item">
          <span class="info-label">Date Fin :</span> {{ \Carbon\Carbon::parse($listeDevis->DateFin)->isoFormat('D MMMM YYYY') }}
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h2 class="card-title">Details Travaux</h2>
      <div class="table-wrapper">
        <table class="custom-table">
          <thead>
            <tr>
              <th>N°</th>
              <th>Designation</th>
              <th>U</th>
              <th>Q</th>
              <th class="pu-column">PU</th> <!-- Ajoutez la classe CSS personnalisée ici -->
              <th class="total-column">Total</th> <!-- Ajoutez la classe CSS personnalisée ici -->
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
                    echo '<td colspan="4"></td>';
                    echo '<td></td>';
                    echo '<td>' . number_format($sum, 2, ',', ' ') . ' Ar</td>';
                    echo '</tr>';
                  }
                  $currentHundred = $hundred;
                  $sum = 0;
                }
                $sum += $detail->prixTotal;
                $sumTotal += $detail->prixTotal;
              @endphp
              <tr>
                <td>{{ $detail->numero }}</td>
                <td>{{ $detail->designation }}</td>
                <td>{{ $detail->unite }}</td>
                <td>{{ $detail->quantite }}</td>
                <td>{{ number_format($detail->pu, 2, ',', ' ') }} Ar</td>
                <td>{{ number_format($detail->prixTotal, 2, ',', ' ') }} Ar</td>
              </tr>
            @endforeach
            @if ($currentHundred !== null)
              <tr>
                <td colspan="4"></td>
                <td></td>
                <td>{{ number_format($sum, 2, ',', ' ') }} Ar</td>
              </tr>
            @endif
            <tr>
              <td colspan="4"></td>
              <td>Total</td>
              <td>{{ number_format($sumTotal, 2, ',', ' ') }} Ar</td>
            </tr>
            <tr>
              <td colspan="4"></td>
              <td>Finition:</td>
              <td>{{ number_format($listeDevis->prixPourcentage, 2, ',', ' ') }} Ar</td>
            </tr>
            <tr>
              <td colspan="4"></td>
              <td>Somme Total:</td>
              <td>{{ number_format($sumTotal + $listeDevis->prixPourcentage, 2, ',', ' ') }} Ar</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

</body>

</html>
