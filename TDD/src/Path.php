<?php

class Path {

    protected $root_path = '/';
    protected $path_separator = '/';
    protected $parent_dir = '..';

    public $currentPath;

    public function __construct($path = '/') {
        $this->check_path($path);
        $this->currentPath = $path;
    }

    protected function check_path($path, $for_change_dir = false)
    {
        $regex_init = '/^((\/){1}([A-Za-z]+)?)?(?:(\/){1}(([A-Za-z]+)?))+$/';

        $regex_change = '/^((\/){1}|([A-Za-z]+)?|(\.{2}))(?:(\/){1}(([A-Za-z]+)?|(\.{2}))?){0,}$/';

        $regex = $for_change_dir ? $regex_change : $regex_init;
        
        if(!preg_match($regex, $path))
            throw new Exception('The path provided "'.$path.'" is not valid.');

    }


    public function cd($new_path)
    {
        $this->check_path($new_path, true);

        $exp_current = explode($this->path_separator, $this->currentPath);
        $exp_new = explode($this->path_separator, $new_path);

        foreach($exp_new as $index => $dir_name)
        {
            switch($dir_name)
            {
                case $this->parent_dir:
                    if(count($exp_current) > 1)     // can't remove the first empty element
                        array_pop($exp_current);
                    break;

                case '':
                    if($index === 0)
                        $exp_current = [''];
                    break;

                default:
                    $exp_current[] = $dir_name;
                    break;
            }
        }
        
        $current_path = implode($this->path_separator, $exp_current);
        $this->currentPath = $current_path ? $current_path : $this->root_path;
    }
    
}
