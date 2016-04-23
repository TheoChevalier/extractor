<?php
namespace Transvision;

use Bit3\GitPhp\GitException;
use Bit3\GitPhp\GitRepository;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @package Transvision
 */
class DataManager extends \VCS\Git
{
    private $name;
    private $username;
    private $token;
    private $remote_url;

    public function __construct($path, $name)
    {
        parent::__construct($path);

        $this->username   = urlencode(GITHUB_USER);
        $this->token      = urlencode(GITHUB_TOKEN);
        $this->name       = $name;
        $this->remote_url = "https://{$this->username}:{$this->token}@github.com/{$this->username}/{$this->name}.git";

        // We use the Monolog library to log our events
        $this->logger = new Logger('DataManager');
        $this->logger->pushHandler(new StreamHandler(INSTALL_ROOT . 'logs/repo-errors.log'));
        // Also log to error console in Debug mode
        if (DEBUG) {
            $this->logger->pushHandler(new ErrorLogHandler());
        }

        try {
            $this->git = new GitRepository($this->repository_path);
            $this->git->init()->execute();
        } catch (GitException $e) {
            $this->logger->error('Failed to initialize Git repository. Error: '
                                 . $e->getMessage());
        }
    }

    public function commit($commit_msg, $author, $date)
    {
        try {
            // Add files to git index then commit
            $this->git->add()->all()->execute();
            $this->git->commit()->message($commit_msg)->author($author)->date($date)->execute();
        } catch (GitException $e) {
            $this->logger->error('Failed to commit to Git repository. Error: '
                                 . $e->getMessage());
        }
    }

    public function tag($tag)
    {
        try {
            $this->git->tag()->execute($tag);
        } catch (GitException $e) {
            $this->logger->error('Failed tagging Git repository. Error: '
                                 . $e->getMessage());
        }
    }

    public function push()
    {
        try {
            $this->git->push()->followTags()->execute($this->remote_url, 'master');
        } catch (GitException $e) {
            $this->logger->error('Failed to push to Git repository. Error: '
                                 . $e->getMessage());
        }
    }

    public function status()
    {
        try {
            return $this->execute('git status --short');
        } catch (GitException $e) {
            $this->logger->error('Failed to check status in Git repository. Error: '
                                 . $e->getMessage());
        }
    }
}
