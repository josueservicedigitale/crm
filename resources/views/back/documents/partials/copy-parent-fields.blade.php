@if(isset($parent))
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
    
    {{-- Copie silencieuse des champs du parent --}}
    @foreach($parent->getAttributes() as $key => $value)
        @if(!in_array($key, [
            'id', 'reference', 'type', 'parent_id', 
            'created_at', 'updated_at', 'file_path'
        ]))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
@endif