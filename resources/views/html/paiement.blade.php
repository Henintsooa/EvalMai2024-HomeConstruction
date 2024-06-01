@extends('parent')
@section('main')
<!--  Header End -->
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Paiement</h5>
                <div id="messageContainer"></div> 
                <form id="paiementForm">
                    @csrf
                    <div class="mb-3">
                        <label for="quantityInput" class="form-label">Date Paiement</label>
                        <input type="date" class="form-control" id="quantityInput" value="{{ old('datePaiement') }}">
                    </div>
                    <div class="mb-3">
                        <label for="montantInput" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montantInput" value="{{ old('montant') }}">
                        <input type="hidden" id="idDemandeDevisInput" value="{{ $idDemandeDevis }}">
                    </div>
                    <button type="button" id="submitBtn" class="btn btn-primary">Valider</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script>
        // When the user clicks on the submit button, the form is sent to the server using XMLHttpRequest
        document.getElementById('submitBtn').addEventListener('click', function() {
    var formData = new FormData();

    // Ajouter les champs requis dans le FormData
    formData.append('datePaiement', document.getElementById('quantityInput').value);
    formData.append('montant', document.getElementById('montantInput').value);
    formData.append('idDemandeDevis', document.getElementById('idDemandeDevisInput').value);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("insertPaiement") }}', true);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) { // 4 = la réponse est reçue entièrement
            var messageContainer = document.getElementById('messageContainer');
            if (xhr.status === 200) { // 200 = la requête a été traitée avec succès
                // Success response
                messageContainer.innerHTML = '<div class="alert alert-success mt-3">Paiement enregistré avec succès.</div>';
                // Clear the form
                document.getElementById('quantityInput').value = '';
                document.getElementById('montantInput').value = '';
            } else if (xhr.status === 422) { // 422 = erreur de validation
                // Error response
                var response = JSON.parse(xhr.responseText);
                var errors = response.errors;
                // Display the errors
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
{{-- if (errors.hasOwnProperty('montant')) {
    var errorMessage = '<div class="alert alert-danger mt-3"><ul>';
    errorMessage += '<li>' + errors['montant'][0] + '</li>';
    errorMessage += '</ul></div>';
    messageContainer.innerHTML = errorMessage;
} else {
    messageContainer.innerHTML = ''; // Clear previous errors
} --}}