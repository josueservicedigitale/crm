{{-- Copie silencieuse de tous les attributs du parent sauf ceux exclus --}}
@foreach($parent->getAttributes() as $key => $value)
    @if(!in_array($key, [
        'id',
        'reference',
        'type',
        'parent_id',
        'created_at',
        'updated_at',
        'file_path'
    ]))
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endif
@endforeach
