<?php
/**
 * ImageHandler.php - Manejo de operaciones con imágenes
 */

require_once __DIR__ . '/config.php';

class ImageHandler {
    /**
     * Valida un archivo de imagen según configuración
     */
    public static function validate($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error en la subida del archivo: " . $file['error']);
        }

        if ($file['size'] > PROFILE_IMG_MAX_SIZE) {
            throw new Exception("El archivo excede el tamaño máximo permitido");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        if (!array_key_exists($mime, $allowedMimes)) {
            throw new Exception("Tipo de archivo no permitido");
        }

        return $allowedMimes[$mime];
    }

    /**
     * Guarda una imagen y crea versiones redimensionadas
     */
    public static function saveProfileImage($file, $modoTest = false) {
        try {
            $extension = self::validate($file);
            self::ensureDirectoryExists();

            $filename = uniqid('profile_') . '.' . $extension;
            $fullPath = PROFILE_IMG_DIR . $filename;

            if ($modoTest || php_sapi_name() === 'cli') {
                if (!copy($file['tmp_name'], $fullPath)) {
                    throw new Exception("No se pudo copiar el archivo en modo test");
                }
            } else {
                if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
                    throw new Exception("No se pudo mover el archivo subido");
                }
            }

            $versions = self::createResizedVersions($fullPath, $filename);
            return [
                'original' => $filename,
                'versions' => $versions,
                'urls' => self::generateUrls($filename, $versions)
            ];
        } catch (Exception $e) {
            error_log("ImageHandler Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una imagen y sus versiones
     */
    public static function deleteProfileImage($filename) {
        if (empty($filename)) return true;

        try {
            $files = self::getImageFiles($filename);
            $allDeleted = true;

            foreach ($files as $file) {
                if (file_exists($file) && !unlink($file)) {
                    $allDeleted = false;
                }
            }

            return $allDeleted;
        } catch (Exception $e) {
            error_log("Error deleting image: " . $e->getMessage());
            return false;
        }
    }

    private static function ensureDirectoryExists() {
        if (!file_exists(PROFILE_IMG_DIR)) {
            mkdir(PROFILE_IMG_DIR, 0755, true);
        }
    }

    private static function createResizedVersions($sourcePath, $filename) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $versions = [];

        try {
            $image = self::createImageFromSource($sourcePath, $extension);
            if (!$image) return [];

            foreach (PROFILE_IMG_SIZES as $sizeName => $dimensions) {
                $versionFilename = self::generateVersionFilename($filename, $sizeName);
                $versionPath = PROFILE_IMG_DIR . $versionFilename;

                $resized = imagescale($image, $dimensions['width'], $dimensions['height']);
                if ($resized && self::saveImage($resized, $versionPath, $extension)) {
                    $versions[$sizeName] = $versionFilename;
                }
                imagedestroy($resized);
            }

            imagedestroy($image);
            return $versions;
        } catch (Exception $e) {
            error_log("Error creating resized versions: " . $e->getMessage());
            return [];
        }
    }

    private static function createImageFromSource($path, $extension) {
        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg': return imagecreatefromjpeg($path);
            case 'png': return imagecreatefrompng($path);
            case 'gif': return imagecreatefromgif($path);
            default: return false;
        }
    }

    private static function saveImage($image, $path, $extension) {
        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg': return imagejpeg($image, $path, PROFILE_IMG_QUALITY);
            case 'png': return imagepng($image, $path);
            case 'gif': return imagegif($image, $path);
            default: return false;
        }
    }

    private static function generateVersionFilename($filename, $sizeName) {
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        return $basename . '_' . $sizeName . '.' . $extension;
    }

    private static function getImageFiles($filename) {
        $files = [PROFILE_IMG_DIR . $filename];
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        foreach (array_keys(PROFILE_IMG_SIZES) as $sizeName) {
            $files[] = PROFILE_IMG_DIR . $basename . '_' . $sizeName . '.' . $extension;
        }

        return $files;
    }

    private static function generateUrls($filename, $versions) {
        $urls = ['original' => UPLOADS_URL . $filename];
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        foreach ($versions as $size => $version) {
            $urls[$size] = UPLOADS_URL . $version;
        }

        return $urls;
    }

    public static function validateAndPrepare($file) {
    $extension = self::validate($file);
    return [
        'extension' => $extension,
        'tmp_name' => $file['tmp_name']
        ];
    }

    public static function createTempCopy($filename) {
        $source = PROFILE_IMG_DIR . $filename;
        if (!file_exists($source)) return null;

        $tempFile = tempnam(sys_get_temp_dir(), 'profile_backup_');
        $files = self::getImageFiles($filename);

        foreach ($files as $file) {
            if (file_exists($file)) {
                copy($file, $tempFile . '_' . basename($file));
            }
        }

        return $tempFile;
    }

    public static function restoreFromBackup($backupFile, $originalFilename) {
        $pattern = $backupFile . '_*';
        $backups = glob($pattern);
        $allRestored = true;

        foreach ($backups as $backup) {
            $filename = str_replace($backupFile . '_', '', basename($backup));
            $dest = PROFILE_IMG_DIR . $filename;

            if (!copy($backup, $dest)) {
                $allRestored = false;
            }
            unlink($backup);
        }

        return $allRestored;
    }
}
?>