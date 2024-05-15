@extends('parent')
@section('main')
<!--  Header End -->
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Paiement</h5>
                <div id="messageContainer"></div> 
                <form id="paiementForm" method="POST" action="{{ route('insertPaiement') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Date Paiement</label>
                        <input type="date" class="form-control" id="quantityInput" name="datePaiement" value="{{ old('datePaiement') }}">
                    </div>
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="quantityInput" name="montant" value="{{ old('montant') }}">
                        <input type="hidden" name="idDemandeDevis" value="{{ $idDemandeDevis }}">
                    </div>
                    <button type="button" id="submitBtn" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
        document.getElementById('submitBtn').addEventListener('click', function() {
        var form = document.getElementById('paiementForm');
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                var messageContainer = document.getElementById('messageContainer');
                if (xhr.status === 200) {
                    // Success response
                    messageContainer.innerHTML = '<div class="alert alert-success mt-3">Paiement enregistré avec succès.</div>';
                    // Clear the form
                    form.reset();
                } else if (xhr.status === 422) {
                    // Error response
                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;
                    var errorMessage = '<div class="alert alert-danger mt-3"><ul>';
                    for (var key in errors) {
                        errorMessage += '<li>' + errors[key][0] + '</li>';
                    }
                    errorMessage += '</ul></div>';
                    messageContainer.innerHTML = errorMessage;
                }
            }
        };
        xhr.send(formData);
    });

</script>
@endsection
