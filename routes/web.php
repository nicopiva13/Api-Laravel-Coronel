<?php

//use Illuminate\Support\Facades\File;

// Ruta del directorio de rutas
//$routesDirectory = base_path('routes');

// Obtener todos los archivos PHP del directorio
//$files = File::allFiles($routesDirectory);

// Incluir solo archivos que no sean 'web.php', 'api.php', 'channels.php', etc.
//foreach ($files as $file) {
//    $fileName = $file->getFilename();
    // Filtrar archivos que no sean las rutas estándar de Laravel
//    if (!in_array($fileName, ['web.php', 'api.php', 'channels.php', 'console.php'])) {
//        $relativePath = 'routes/' . $fileName;  // Ruta relativa desde el directorio de rutas
//        require base_path($relativePath);
//    }
//}
