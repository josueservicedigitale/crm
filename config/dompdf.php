<?php

return [
    // ====================================================
    // FORMAT DU PDF
    // ====================================================
    'default_paper_size' => 'A4',
    'default_paper_orientation' => 'portrait',
    'default_media_type' => 'screen',
    
    // ====================================================
    // POLICES - IMPORTANT POUR WINDOWS
    // ====================================================
    'default_font' => 'dejavu sans', // Police DejaVu (meilleur support UTF-8)
    // Alternatives si DejaVu pas disponible :
    // 'default_font' => 'arial',       // Standard Windows
    // 'default_font' => 'helvetica',   // Standard cross-platform
    // 'default_font' => 'times',       // Police Times
    
    'font_dir' => storage_path('fonts/'), // Chemin où chercher les polices .ttf
    'font_cache' => storage_path('fonts/'), // Cache des polices
    'enable_font_subsetting' => false, // Garder false pour Windows
    
    // ====================================================
    // QUALITÉ & RÉSOLUTION
    // ====================================================
    'dpi' => 96, // Standard Windows
    'font_height_ratio' => 1.1, // Ajustement pour Windows
    
    // ====================================================
    // FONCTIONNALITÉS
    // ====================================================
    'isRemoteEnabled' => true, // CORRECT: minuscule "R", majuscule "E"
    'isHtml5ParserEnabled' => true, // CORRECT
    'isPhpEnabled' => false, // Désactivé pour Windows (performance)
    'isJavascriptEnabled' => true,
    'isFontSubsettingEnabled' => false,
    
    // ====================================================
    // CSS & HTML
    // ====================================================
    'isCssFloatEnabled' => false, // Problèmes connus sur Windows
    'enable_css_float' => false, // Alias
    'enable_php' => false,
    'enable_javascript' => true,
    
    // ====================================================
    // CHEMIN & SÉCURITÉ
    // ====================================================
    'temp_dir' => sys_get_temp_dir(), // Dossier temp Windows
    'chroot' => realpath(base_path()), // Sécurité
    'log_output_file' => null, // Désactiver les logs HTML
    
    // ====================================================
    // BACKEND & PERFORMANCE
    // ====================================================
    'pdf_backend' => 'CPDF', // Backend par défaut
    'debug_keep_temp' => false,
    'debug_css' => false,
    'debug_layout' => false,
    'debug_layout_lines' => false,
    'debug_layout_blocks' => false,
    'debug_layout_inline' => false,
    'debug_layout_padding_box' => false,
    
    // ====================================================
    // PROTOCOLES AUTORISÉS
    // ====================================================
    'allowed_protocols' => [
        "file://" => ["rules" => []],
        "http://" => ["rules" => []],
        "https://" => ["rules" => []],
        "data://" => ["rules" => []]
    ],
    
    // ====================================================
    // OPTIMISATIONS SPÉCIFIQUES WINDOWS
    // ====================================================
    'show_warnings' => false, // Masquer les warnings en production
    'public_path' => null, // Laisser null pour auto-détection
    'enable_remote' => true, // Pour images externes
    
    // ====================================================
    // ENCODING
    // ====================================================
    'default_encoding' => 'UTF-8',
    
    // ====================================================
    // MEMORY LIMITS (WINDOWS)
    // ====================================================
    //'memory_limit' => '256M', // Optionnel: si problèmes de mémoire
];