module.exports = {
    proxy: "127.0.0.1:8001", // La URL de tu proyecto Laravel
    files: [
        "./resources/views/**/*.blade.php", // Archivos a observar
        "./public/css/**/*.css",
        "./public/js/**/*.js",
        "./app/**/*.php", // Si quieres recargar con cambios en el código PHP
        "./routes/**/*.php" // Si quieres recargar con cambios en las rutas
    ]
};