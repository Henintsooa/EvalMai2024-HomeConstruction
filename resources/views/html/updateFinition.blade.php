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
                <h5 class="card-title fw-semibold mb-4">Finition</h5>
                <div class="table-responsive">
                    <form method="POST" action="{{ route('editFinition') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idPack" id="packId" value="">

                        <div class="mb-3">
                            <label for="nomFinition" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nomFinition" name="nomFinition" value="{{ $finition->nomFinition }}">
                            @error('nomFinition')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pourcentage" class="form-label">Pourcentage</label>
                            <input type="text" class="form-control" id="pourcentage" name="pourcentage" value="{{ $finition->pourcentage }}">
                            @error('pourcentage')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <input type="hidden" name="idFinition" value="{{ $finition->idFinition }}">

                        <button type="submit" id="submitBtn" class="btn btn-primary">Valider</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
