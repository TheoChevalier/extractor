<?php
namespace Transvision;

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

    public function getHistory()
    {
        if (is_file($this->save_latest) && ! empty(file_get_contents($this->save_latest))) {
            $latest = file_get_contents($this->save_latest);
            $latest = preg_replace( "/\r|\n/", "", $latest);

            $temp = $this->getCommitsWithoutMergesSince($latest);

            // Remove the last processed revision
            array_pop($temp);

            // Get the oldest commit first
            $this->data = array_reverse($temp);
        } else {
            $this->data = array_reverse($this->getCommitsWithoutMerges());
        }
    }

    public function getCommitsWithoutMerges()
    {
        $log = $this->execute('hg log -r "(all() - merge()) or head()" --config ui.verbose=false');
        $this->repository_type = 'hg';

        return $this->parseLog($log);
    }

    public function getCommitsWithoutMergesSince($rev)
    {
        $log = $this->execute("hg log -r \"(tip:{$rev} - merge()) or head()\" --config ui.verbose=false");
        $this->repository_type = 'hg';
        return $this->parseLog($log);
    }
}
