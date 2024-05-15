@extends('parent')
@section('main')
<!-- Header End -->
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
    <div class="col-lg-10 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-6">
                <h5 class="card-title fw-semibold mb-4">Finitions</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle table-styling">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th style="max-width: 50px;">
                                    <h6 class="fw-semibold mb-0">Nom</h6>
                                </th>
                                <th style="max-width: 150px;">
                                    <h6 class="fw-semibold mb-0">Pourcentage</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finitions as $finition)
                            <tr>
                                <td style="max-width: 50px;">
                                    <p class="mb-0 fw-normal"> {{ $finition->nomFinition }}</p>
                                </td>
                                <td style="max-width: 50px;">
                                    <p class="mb-0 fw-normal">{{ $finition->pourcentage  }}</p>
                                </td>
                               
                                <td class="border-bottom-0" style="max-width: 50px;">
                                  <a href="{{route('updateFinition', $finition->idFinition) }}" class="btn btn-primary btn-sm">Modifier</a>
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
@endsection
