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

        <div class="d-flex justify-content-between align-items-center mt-4">
    <!-- <div class="text-muted small">
        Affichage de {{ $documents->firstItem() ?? 0 }} à {{ $documents->lastItem() ?? 0 }} 
        sur {{ $documents->total() }} documents
    </div> -->
    
    <div class="pagination-wrapper">
        {{ $documents->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
/* ✅ RÉDUIRE LA TAILLE DE LA PAGINATION */
.pagination-wrapper .pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin: 0;
    padding: 0;
}

.pagination-wrapper .page-item .page-link {
    padding: 0.35rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px !important;
    margin: 0 2px;
    color: #6c757d;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
    font-weight: 500;
}

.pagination-wrapper .page-item.disabled .page-link {
    background-color: #f8f9fa;
    color: #adb5bd;
    pointer-events: none;
}

/* ✅ FLÈCHES PLUS PETITES */
.pagination-wrapper .page-item:first-child .page-link,
.pagination-wrapper .page-item:last-child .page-link {
    padding: 0.35rem 0.9rem;
}

/* ✅ SURVOL */
.pagination-wrapper .page-item:not(.active):not(.disabled) .page-link:hover {
    background-color: #e9ecef;
    border-color: #ced4da;
    color: #0a58ca;
}
</style>
    </div>
</div>
<br><br><br><br><br>
@endsection
