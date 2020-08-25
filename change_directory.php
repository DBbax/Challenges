<?php
namespace Everli\Path;
use Exception;

class Path {

    protected $root_path = '/';
    protected $path_separator = '/';
    protected $parent_dir = '..';

    public $currentPath;

    public function __construct($path = '/') {
        $this->check_path($path); // if not valid an Exception will be thrown
        $this->currentPath = $path;
    }

    protected function check_path($path, $for_change_dir = false)
    {
        // match if string starts with slash (root path), if is slash separated and if contains only english letters (uppercase or lowercase)
        // when instantiating the Path class the root path is mandatory
        $regex_init = '/^((\/){1}([A-Za-z]+)?)(?:(\/){0,1}(([A-Za-z]+)?))+$/';

        // match if string is slash separated and if contains only two dots or english letters (uppercase or lowercase)
        // used when change directory (cd function) is called
        $regex_change = '/^((\/){1}|([A-Za-z]+)?|(\.{2}))(?:(\/){0,1}(([A-Za-z]+)?|(\.{2})))+$/';

        $regex = $for_change_dir ? $regex_change : $regex_init;
        
        if(!preg_match($regex, $path))
            throw new Exception('The path provided "'.$path.'" is not valid.');

    }


    public function cd($new_path)
    {
        $this->check_path($new_path, true); // if not valid an Exception will be thrown

        // explode current & new path to work with arrays
        $exp_current = explode($this->path_separator, $this->currentPath);
        $exp_new = explode($this->path_separator, $new_path);

        foreach($exp_new as $index => $dir_name)
        {
            switch($dir_name)
            {
                // if $dir_name is parent directory '..' remove the last item of current exploded path
                case $this->parent_dir:
                    if(count($exp_current) > 1)     // can't remove the first empty element
                        array_pop($exp_current);
                    break;

                // if $index is 0 reset current exploded path because the $new_path starts with root_path '/'
                // else the path is something like "a/b///c" so do nothing
                case '':
                    if($index === 0)
                        $exp_current = [''];
                    break;

                // just push the directory
                default:
                    $exp_current[] = $dir_name;
                    break;
            }
        }
        
        $current_path = implode($this->path_separator, $exp_current);

        // if $current_path is empty it means you are in the root folder
        $this->currentPath = $current_path ? $current_path : $this->root_path;
    }
    
}


try {
    $path = new Path('/a/b/c/d');
    $path->cd('../x');
    // $path->cd('/a/zx');
    // $path->cd('../../../../../../../../ftp');
    echo $path->currentPath;
}
catch(Exception $e)
{
    echo $e->getMessage();
}

echo "\n"; // just for convenience of reading in the terminal

// to see the output run in terminal: "php change_directory.php"
