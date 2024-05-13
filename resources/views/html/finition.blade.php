@extends('parent')
@section('main')
<!--  Header End -->
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Finition et Date début</h5>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('insertDemandeDevis') }}"> 
                    @csrf
                    <div class="mb-3">
                        <label for="ingredientSelect" class="form-label">Finition</label>
                        @foreach($finitions as $finition)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="idFinition" id="finition{{ $finition->idFinition }}" value="{{ $finition->idFinition }}">
                                <label class="form-check-label" for="finition{{ $finition->idFinition }}">
                                    {{ $finition->nomFinition }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Date début</label>
                        <input type="date" class="form-control" id="quantityInput" name="dateDebut">
                        {{-- @error('dateDebut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror --}}
                        <input type="hidden" name="idMaison" value="{{$idMaison}}">
                    </div>                    
                    <button type="submit" id="submitBtn" class="btn btn-primary">Valider</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
