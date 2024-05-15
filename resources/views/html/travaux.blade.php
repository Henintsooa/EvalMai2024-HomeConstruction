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
                <h5 class="card-title fw-semibold mb-4">Travaux</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle table-styling">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th style="max-width: 50px;">
                                    <h6 class="fw-semibold mb-0">N°</h6>
                                </th>
                                <th style="max-width: 150px;">
                                    <h6 class="fw-semibold mb-0">Designation</h6>
                                </th>
                                <th style="max-width: 50px;">
                                    <h6 class="fw-semibold mb-0">U</h6>
                                </th>
                                <th style="max-width: 100px;">
                                    <h6 class="fw-semibold mb-0">PU</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($travaux as $detail)
                            <tr>
                                <td style="max-width: 50px;">
                                    <p class="mb-0 fw-normal"> {{ $detail->numero }}</p>
                                </td>
                                <td style="max-width: 50px;">
                                    <p class="mb-0 fw-normal">{{ $detail->designation }}</p>
                                </td>
                                <td style="max-width: 50px;">
                                    <p class="mb-0 fw-normal">{{ $detail->unite }}</p>
                                </td>
                                <td class="text-end" style="max-width: 50px;">
                                    <p class="mb-0 fw-normal">{{ number_format($detail->pu,2, ',', ' ') }} Ar</p>
                                </td>
                                <td class="border-bottom-0" style="max-width: 50px;">
                                  <a href="{{route('updateTravaux', $detail->idTravaux) }}" class="btn btn-success btn-sm">Modifier</a>
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
