<?php

namespace Deployer;

require_once __DIR__. '/vendor/autoload.php';
require_once __DIR__. '/vendor/deployer/deployer/recipe/composer.php';

host('95.167.118.190')
    ->user('memorex')
    ->port(22)
    ->set('deploy_path','/var/www/test')
    ->set('branch','code-review-deploy')
    ->stage('production')
    ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/test_rsa');

set('repository', 'git@github.com:tanukin/home-framework.git');

set('env_vars', '/usr/bin/env');
set('keep_releses', 5);
set('shared_dirs', ['web/app/uploads']);
set('shared_file', ['.env']);

?>