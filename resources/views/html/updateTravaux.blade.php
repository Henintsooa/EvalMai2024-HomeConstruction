@extends('parent')
@section('main')
<!-- Header End -->
<div class="container-fluid">
    <div class="col-lg-8 d-flex align-items-stretch">
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-6">
                <h5 class="card-title fw-semibold mb-4">Travaux</h5>
                <div class="table-responsive">
                    <form method="POST" action="{{ route('editTravaux') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idPack" id="packId" value="">

                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" value="{{ $travaux->designation }}">
                            @error('designation')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="numero" class="form-label">Numero</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="{{ $travaux->numero }}">
                            @error('numero')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pu" class="form-label">Prix unitaire</label>
                            <input type="text" class="form-control" id="pu" name="pu" value="{{ $travaux->pu }}">
                            @error('pu')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="unite" class="form-label">Unite</label>
                            <input type="text" class="form-control" id="unite" name="unite" value="{{ $travaux->unite }}">
                            @error('unite')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="idTravaux" value="{{ $travaux->idTravaux }}">

                        <button type="submit" id="submitBtn" class="btn btn-primary">Valider</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
