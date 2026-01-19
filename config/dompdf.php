<?php

return [
    'default_paper_size' => 'A4',
    'default_font' => 'sans-serif',
    'dpi' => 96,
    'enable_php' => false,
    'enable_javascript' => true,
    'enable_remote' => true, // CRITIQUE : permet de charger CSS/images
    'enable_css_float' => false,
    'enable_html5_parser' => true,
    'font_dir' => storage_path('fonts/'),
    'font_cache' => storage_path('fonts/'),
    'temp_dir' => sys_get_temp_dir(),
    'chroot' => realpath(base_path()),
    'log_output_file' => storage_path('logs/dompdf.html'),
    'default_media_type' => 'screen',
    'is_remote_enabled' => true,
    'is_html5_parser_enabled' => true,
];