<?php
/**
 * Created by PhpStorm.
 * User: Lizheng
 * Date: 2017/1/30
 * Time: 10:40
 */

namespace AppBundle\Entity;


use Symfony\Component\Finder\Finder;

class FileManager
{
    const FILE = "FILE";
    const DIR  = "DIR";

    private $currentPath = "";

    /**
     * @return string
     */
    public function getCurrentPath()
    {
        return $this->currentPath;
    }

    private $directories = [];

    private $files = [];

    private $uploads;

    public function setUploads( $files ){
        $this->uploads = $files;
        return $this;
    }

    public function getUploads(){
        return $this->uploads;
    }

    public function __construct($currentPath = "")
    {
        $this->currentPath .= $currentPath;
    }

    protected function setResources(Finder $finder){
        foreach ( $finder as $path ){
            if(!stripos($path->getRelativePathname(), '\\')){
                if($path->isDir()){
                    $this->directories[] = $path;
                    sort($this->directories);
                }
                if($path->isFile()){
                    $path->assetPath = $this->currentPath ."/". $path->getRelativePathname();
                    $this->files[] = $path;
                    sort($this->files);
                }
            }

        }
        return $this;
    }
    public function currentDirectories(Finder $finder){
        return $this->setResources($finder);
    }

    /**
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    public function currentDirectoryFiles(Finder $finder){
        return $this->setResources($finder);
    }

    public function getFiles(){
        return $this->files;
    }
}