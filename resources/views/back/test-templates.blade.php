@extends('back.layouts.app')

@section('content')
<div class="container">
    <h2>Vérification des Templates PDF</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>Clé</th>
                <th>Activité</th>
                <th>Société</th>
                <th>Type</th>
                <th>Template</th>
                <th>Existe</th>
                <th>Chemin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr class="{{ $result['exists'] ? 'table-success' : 'table-danger' }}">
                <td>{{ $result['key'] }}</td>
                <td>{{ $result['activity'] }}</td>
                <td>{{ $result['society'] }}</td>
                <td>{{ $result['type'] }}</td>
                <td><code>{{ $result['template'] }}</code></td>
                <td>
                    @if($result['exists'])
                    <span class="badge bg-success">✓</span>
                    @else
                    <span class="badge bg-danger">✗</span>
                    @endif
                </td>
                <td><small>{{ $result['path'] }}</small></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection