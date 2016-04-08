<?php
namespace Transvision;

use Bit3\GitPhp\GitException;
use Bit3\GitPhp\GitRepository;
use Github\Client;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


/**
 * @package Transvision
 */
class DataMan extends \VCS\Git {

    public function authenticate($login, $password) {
        return true;
    }

    public function initRepo() {
        // We use the Monolog library to log our events
        $this->logger = new Logger('DataManager');
        $this->logger->pushHandler(new StreamHandler(INSTALL_ROOT . 'logs/repo-errors.log'));
        // Also log to error console in Debug mode
        if (DEBUG) {
            $this->logger->pushHandler(new ErrorLogHandler());
        }

        try {
            $this->git = new GitRepository($this->repository_path);
        } catch (GitException $e) {
            $this->logger->error('Failed to initialize Git repository. Error: '
                                 . $e->getMessage());
        }
    }
    public function commit($commit_msg)
    {
        try {
            // Add files to git index then commit
            $this->git->add()->all()->execute();
            $this->git->commit()->message($commit_msg)->execute();

        } catch (GitException $e) {
            $this->logger->error('Failed to commit to Git repository. Error: '
                                 . $e->getMessage());
        }
    }
}
