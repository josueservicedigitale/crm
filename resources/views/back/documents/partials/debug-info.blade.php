<!-- 
@php
    $config = [
        'devis' => ['icon' => 'fa-file-signature', 'color' => 'primary'],
        'facture' => ['icon' => 'fa-file-invoice-dollar', 'color' => 'success'],
        'rapport' => ['icon' => 'fa-chart-line', 'color' => 'warning'],
        'cahier_des_charges' => ['icon' => 'fa-book', 'color' => 'secondary'],
        'attestation_realisation' => ['icon' => 'fa-check-circle', 'color' => 'info'],
        'attestation_signataire' => ['icon' => 'fa-user-check', 'color' => 'dark'],
    ];

    $current = $config[$type] ?? ['icon' => 'fa-file', 'color' => 'info'];
@endphp

<div class="alert alert-{{ $current['color'] }} text-center">
    <i class="fa {{ $current['icon'] }} me-2"></i>
    {{ $messages[$type] ?? "Merci de saisir correctement les informations du document." }}
</div> -->


@php
    $typeLabels = [
        'devis' => 'Devis',
        'facture' => 'Facture',
        'cahier_des_charges' => 'Cahier des charges',
        'rapport' => 'Rapport',
        'attestation_realisation' => 'Attestation de réalisation',
        'attestation_signataire' => 'Attestation signataire',
    ];

    $typeKey = is_string($type ?? null) ? $type : null;
    $documentLabel = $typeLabels[$typeKey] ?? 'Document';
@endphp
<div class="alert alert-info text-center">
    <strong>{{ $documentLabel }}</strong><br>
    Merci de bien saisir toutes les informations de ce {{ strtolower($documentLabel) }}.
    Chaque donnée peut être liée à d'autres documents du dossier.
</div>