<?php


namespace App\Console\Commands;

use App\Models\Corbeille;
use Illuminate\Console\Command;

class NettoyerCorbeille extends Command
{
    /**
     * Le nom et la signature de la commande.
     *
     * @var string
     */
    protected $signature = 'corbeille:nettoyer 
                            {--jours=30 : Nombre de jours avant expiration} 
                            {--force : Forcer le nettoyage sans confirmation}';
    
    /**
     * Description de la commande.
     *
     * @var string
     */
    protected $description = 'Nettoyer automatiquement la corbeille des éléments expirés';
    
    /**
     * Exécuter la commande.
     *
     * @return int
     */
    public function handle()
    {
        $jours = (int) $this->option('jours');
        $force = $this->option('force');
        $dateLimite = now()->subDays($jours);
        
        // Compter les éléments à supprimer
        $nombreElements = Corbeille::where('supprime_le', '<', $dateLimite)->count();
        
        if ($nombreElements === 0) {
            $this->info("Aucun élément à nettoyer dans la corbeille.");
            return Command::SUCCESS;
        }
        
        // Demander confirmation si pas en mode force
        if (!$force && !$this->confirm("Voulez-vous nettoyer {$nombreElements} éléments de la corbeille (supprimés avant le {$dateLimite->format('d/m/Y')}) ?")) {
            $this->info("Nettoyage annulé.");
            return Command::SUCCESS;
        }
        
        $this->info("Début du nettoyage de la corbeille...");
        $this->info("Date limite : {$dateLimite->format('d/m/Y H:i:s')}");
        $this->info("Nombre d'éléments à nettoyer : {$nombreElements}");
        
        $bar = $this->output->createProgressBar($nombreElements);
        $bar->start();
        
        $elementsSupprimes = 0;
        $erreurs = 0;
        
        Corbeille::where('supprime_le', '<', $dateLimite)
            ->chunkById(100, function ($elements) use (&$elementsSupprimes, &$erreurs, $bar) {
                foreach ($elements as $element) {
                    try {
                        $classeModele = $element->type_element;
                        
                        // Essayer de supprimer définitivement le modèle
                        if (class_exists($classeModele)) {
                            try {
                                $modele = $classeModele::withTrashed()->find($element->element_id);
                                
                                if ($modele) {
                                    $modele->forceDelete();
                                }
                            } catch (\Exception $e) {
                                // Si le modèle n'existe plus, continuer
                            }
                        }
                        
                        // Supprimer l'entrée de la corbeille
                        $element->delete();
                        $elementsSupprimes++;
                        
                        // Journaliser si nécessaire
                        if (class_exists('\Illuminate\Support\Facades\Log')) {
                            \Illuminate\Support\Facades\Log::info("Élément nettoyé de la corbeille", [
                                'type' => $element->type_element,
                                'id' => $element->element_id,
                                'date_suppression' => $element->supprime_le,
                            ]);
                        }
                        
                    } catch (\Exception $e) {
                        $erreurs++;
                        $this->error("Erreur avec l'élément ID {$element->id} : " . $e->getMessage());
                        
                        if (class_exists('\Illuminate\Support\Facades\Log')) {
                            \Illuminate\Support\Facades\Log::error("Erreur lors du nettoyage de la corbeille", [
                                'element_id' => $element->id,
                                'erreur' => $e->getMessage(),
                            ]);
                        }
                    }
                    
                    $bar->advance();
                }
            });
        
        $bar->finish();
        $this->newLine(2);
        
        // Résumé
        $this->info("=== RÉSUMÉ DU NETTOYAGE ===");
        $this->info("Éléments supprimés avec succès : {$elementsSupprimes}");
        $this->info("Erreurs rencontrées : {$erreurs}");
        
        if ($erreurs > 0) {
            $this->warn("Certains éléments n'ont pas pu être nettoyés. Consultez les logs pour plus de détails.");
        } else {
            $this->info("Nettoyage terminé avec succès !");
        }
        
        return Command::SUCCESS;
    }
}