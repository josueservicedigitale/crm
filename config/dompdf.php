<?php

return [

    // Taille du papier
    'default_paper_size' => 'a4',
    'default_paper_orientation' => 'portrait',

    // Police par défaut (UTF-8 OK)
    'default_font' => 'dejavu sans',

    // Dossiers polices
    'font_dir' => storage_path('fonts/'),
    'font_cache' => storage_path('fonts/'),

    // Qualité
    'dpi' => 96,
    'font_height_ratio' => 1.1,

    // Options importantes
    'isRemoteEnabled' => true,          // Images externes / public_path
    'isHtml5ParserEnabled' => true,     // HTML5
    'isPhpEnabled' => false,            // Sécurité
    'isJavascriptEnabled' => false,     // JS inutile en PDF
    'isFontSubsettingEnabled' => false,

    // Chemins système
    'temp_dir' => sys_get_temp_dir(),
    'chroot' => realpath(base_path()),

    // Backend PDF
    'pdf_backend' => 'CPDF',

    // Debug désactivé
    'debug_css' => false,
    'debug_layout' => false,
    'debug_layout_lines' => false,
    'debug_layout_blocks' => false,
    'debug_layout_inline' => false,
    'debug_layout_padding_box' => false,

    // Protocoles autorisés
    'allowed_protocols' => [
        "file://" => ["rules" => []],
        "http://" => ["rules" => []],
        "https://" => ["rules" => []],
        "data://" => ["rules" => []]
    ],

    // Encodage
    'default_encoding' => 'UTF-8',

];
