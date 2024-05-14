@extends('parent')
@section('main')
<!--  Header End -->
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4" >Paiement</h5>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('insertPaiement') }}"> 
                    @csrf
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Date Paiement</label>
                        <input type="date" class="form-control" id="quantityInput" name="datePaiement" value="{{ old('datePaiement') }}">
                        {{-- @error('dateDebut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror --}}
                    </div>    
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="quantityInput" name="montant" value="{{ old('montant') }}">
                        <input type="hidden" name="idDemandeDevis" value="{{ $idDemandeDevis }}">

                    </div>                
                    <button type="submit" id="submitBtn" class="btn btn-primary">Valider</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
