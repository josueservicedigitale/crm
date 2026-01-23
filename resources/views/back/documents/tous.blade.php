@extends('back.layouts.principal')

@section('title', 'Tous les documents')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-white rounded shadow-sm p-4">
        <h4 class="mb-4"><i class="fa fa-folder-open me-2 text-info"></i>Tous les documents</h4>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Activité</th>
                    <th>Société</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                    <tr>
                        <td>{{ $doc->id }}</td>
                        <td>{{ ucfirst($doc->activity) }}</td>
                        <td>{{ ucfirst($doc->society) }}</td>
                        <td>{{ ucfirst($doc->type) }}</td>
                        <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
