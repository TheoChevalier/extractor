<?php
namespace Transvision;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @package Transvision
 */
class HgRepo extends \VCS\Mercurial
{
    public $save_latest;
    public $origin;
    public $short_name;
    public $web_link;
    public $repo_dirs;
    public $rev;
    public $data;

    public function __construct($path)
    {
        parent::__construct($path);
        
    }
    
    function getHistory() {
    if (is_file($this->save_latest) && ! empty(file_get_contents($this->save_latest))) {
        $latest = file_get_contents($this->save_latest);

        $this->data = $this->getCommitsSince($latest);

        // Remove the last processed revision
        array_pop($this->data);
    } else {
        $this->data = $this->getCommits();
    }
}

}
