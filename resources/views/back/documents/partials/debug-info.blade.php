<!-- {{-- Supprimer en production --}}
@if(env('APP_DEBUG'))
<div class="alert alert-info">
    <h5>Debug Info:</h5>
    <ul>
        <li>Type: {{ $type }}</li>
        <li>Activity: {{ $activity }}</li>
        <li>Society: {{ $society }}</li>
        <li>Document exists: {{ isset($document) ? 'Yes' : 'No' }}</li>
        <li>Parent exists: {{ isset($parent) ? 'Yes' : 'No' }}</li>
        <li>Route:
            @if(isset($document) && $document->id)
                {{ route('back.document.update', [$activity, $society, $type, $document->id]) }}
            @else
                {{ route('back.document.store', [$activity, $society, $type]) }}
            @endif
        </li>
    </ul>
</div>

<div class="alert alert-danger">
    <h5>Debug URL:</h5>
    <ul>
        <li>URL complète: {{ url()->full() }}</li>
        <li>Parent ID from URL: {{ request('parent_id') ?? 'Non fourni' }}</li>
        <li>Parent exists: {{ isset($parent) && $parent ? 'Oui (ID: ' . $parent->id . ')' : 'Non' }}</li>
        <li>Document exists: {{ isset($document) && $document->id ? 'Oui' : 'Non' }}</li>
    </ul>
</div>
@endif -->



<div class="alert alert-info text-center">jai vraiment grouiller</div>
