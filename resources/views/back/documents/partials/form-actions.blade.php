<div class="mb-4 d-flex justify-content-between">
    <a href="{{ route('back.document.choose-action', [$activity, $society, $type]) }}" 
       class="btn btn-secondary btn-lg">
        <i class="fa fa-arrow-left me-2"></i> Retour
    </a>
    
    <div>
        @if(isset($document) && $document->id)
            <!-- Pour un document existant -->
            @if($document->file_path && Storage::exists(str_replace('storage/', 'public/', $document->file_path)))
                <a href="{{ route('back.document.download-pdf', [$activity, $society, $type, $document->id]) }}" 
                   target="_blank" 
                   class="btn btn-success btn-lg me-2">
                    <i class="fa fa-download me-2"></i> Télécharger PDF
                </a>
            @else
                <button type="button" 
                        id="generatePdfBtn"
                        data-url="{{ route('back.document.generate_pdf', [$activity, $society, $type, $document->id]) }}"
                        class="btn btn-warning btn-lg me-2">
                    <i class="fa fa-file-pdf me-2"></i> Générer PDF
                </button>
            @endif
            
            <button type="submit" name="action" value="update" class="btn btn-primary btn-lg">
                <i class="fa fa-save me-2"></i> Mettre à jour
            </button>
        @else
            <!-- Pour un nouveau document : bouton avec téléchargement automatique -->
            <button type="submit" name="action" value="create_and_download" class="btn btn-success btn-lg me-2">
                <i class="fa fa-download me-2"></i> Créer et Télécharger PDF
            </button>
            
            <button type="submit" name="action" value="create_only" class="btn btn-primary btn-lg">
                <i class="fa fa-save me-2"></i> Créer seulement
            </button>
        @endif
    </div>
</div>