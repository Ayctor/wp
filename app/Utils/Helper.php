<?php

namespace Ayctor\Utils;

/**
 * Class Helper contains all the utils methods
 */
class Helper
{
    /**
     * Helper function to get file path with version
     *
     * @param string $file File to get the path
     *
     * @return string
     */
    public static function mix(string $file): string
    {
        $path = '';
        $mix_manifest = file_get_contents(__DIR__ . '/../../build/mix-manifest.json');
        $manifest = json_decode($mix_manifest);
        $file = '/' . ltrim($file, '/');
        if (isset($manifest->{$file})) {
            $version = $manifest->{$file};
            $path = get_template_directory_uri() . '/build' . $version;
        }
        return $path;
    }
}
