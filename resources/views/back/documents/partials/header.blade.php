<h4 class="fw-bold text-dark mb-4">
    <i class="fa fa-file-alt me-2"></i>
    {{ strtoupper($society) }} – {{ ucfirst($activity) }} – {{ strtoupper($type) }}
</h4>

@if(!isset($parent) && in_array($type, ['facture', 'attestation_realisation', 'attestation_signataire', 'cahier_des_charges']))
<div class="alert alert-warning mb-4">
    <h5>Attention !</h5>
    <p>Aucun devis n'a été sélectionné pour créer ce document.</p>
    <a href="{{ route('back.document.select-devis', [$activity, $society, $type]) }}" 
       class="btn btn-warning">
        Sélectionner un devis
    </a>
</div>
@endif