<?php

namespace App\Lib;

use DirectoryIterator;

/**
 * Filesystem helper
 */
class FileSystem {
    
    /**
     * Check if the folder is empty
     *
     * @param string $path
     * @return boolean
     */
    public static function isDirEmpty($path)
    {
        if (count(\scandir($path)) == 2){
            return true;
        }

        return false;
    }


    /**
     * Delete all files from a directory
     *
     * @param string $path
     * @return void
     */
    public static function deleteAll($path)
    {
        return array_map('unlink', glob($path));
    }

    /**
     * Get all files exists in a directory
     *
     * @param string $directory
     * @return mixed
     */
    public static function getDirectory($directory)
    {
        $fileArray = array();

        foreach (new DirectoryIterator($directory) as $file) {

            if ($file->isFile()) {
                array_push($fileArray, $file->getFilename());
            }
        }

        if (empty($fileArray)){

            return false;

        }

        return $fileArray;
    }

}
