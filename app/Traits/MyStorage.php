<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait MyStorage
{
    /**
     * 在 Storage 找出符合樣式的目錄
     *
     * @param  string $disk
     * @param  string $path
     * @param  string $dirPattern
     * @return array
     */
    public function myStorageFindDirs(string $disk, string $path, string $dirPattern)
    {
        $matchDirs = [];
        $dirs = Storage::disk($disk)->directories($path);
        $pPath = path_to_pattern($path);

        foreach ($dirs as $dir)
        {
            // example, $dir = abc/xyz
            if ( preg_match('/^' . $pPath . '\/' . $dirPattern . '$/u', $dir, $matches) )
            {
                $matchDirs[] = [
                    'dirPath' => $dir,             // abc/xyz
                    'dirPrefix' => $path,          // abc
                    'dirValue' => end($matches)    // return {xyz} depends on the $dirPattern
                ];
            }
        }

        return $matchDirs;
    }

    /**
     * 在 Storage 找出符合樣式的檔案
     *
     * @param  string $disk
     * @param  array  $dirs
     * @param  string $filePattern
     * @return array
     */
    public function myStorageFindFiles(string $disk, array $dirs, string $filePattern)
    {
        $matchFiles = [];

        foreach ($dirs as $dir)
        {
            $files = Storage::disk($disk)->files($dir['dirPath']);
            $pPath = path_to_pattern($dir['dirPath']);

            foreach ($files as $file)
            {
                // example, $file = abc/xyz/file.txt
                if ( preg_match('/^' . $pPath . '\/' . $filePattern . '$/u', $file, $matches) )
                {
                    $matchFiles[] = [
                        'filePath' => $file,             // abc/xyz/file.txt
                        'filePrefix' => $dir['dirPath'], // abc/xyz
                        'fileValue' => end($matches)     // return {files.txt} depends on the $filePattern
                    ];
                }
            }
        }

        return $matchFiles;
    }

    /**
     * 在 Storage 移動目錄
     *
     * @param  string  $disk
     * @param  string  $from
     * @param  string  $to
     * @param  boolean $overwrite
     * @return boolean
     */
    public function myStorageMoveDir(string $disk, string $from, string $to, $overwrite = false)
    {
        if (Storage::disk($disk)->exists($to))
        {
            if ($overwrite)
            {
                if (! Storage::disk($disk)->deleteDirectory($to))
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        return Storage::disk($disk)->move($from, $to) === true;
    }

    /**
     * 在 Storage 移動檔案
     *
     * @param  string  $disk
     * @param  string  $from
     * @param  string  $to
     * @param  boolean $overwrite
     * @return boolean
     */
    public function myStorageMoveFile(string $disk, string $from, string $to, $overwrite = false)
    {
        if (Storage::disk($disk)->exists($to))
        {
            if ($overwrite)
            {
                if (! Storage::disk($disk)->delete($to))
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        return Storage::disk($disk)->move($from, $to) === true;
    }

    /**
     * 在 Storage 如果目錄存在便刪除
     *
     * @param  string $disk
     * @param  string $dir
     * @return boolean
     */
    public function myStorageDeleteDirIfExist(string $disk, string $dir)
    {
        if (Storage::disk($disk)->exists($dir))
        {
            if (! Storage::disk($disk)->deleteDirectory($dir) )
            {
                return false;
            }
        }

        return true;
    }
}
