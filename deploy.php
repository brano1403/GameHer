<?php
namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'test');
set('repository', 'git@github.com:brano1403/GameHer.git');
set('allow_anonymous_stats', false);
set('git_tty', false);
set('default_timeout', 600);

add('shared_files', []);
add('shared_dirs', ['public/uploads']);
add('writable_dirs', ['public/uploads']);

task('build', function () {
    run('cd {{release_path}} && build');
});

task('deploy:npm:install', 'npm install')->desc('Installing node modules');
task('deploy:npm:build', 'npm run build')->desc('Running webpack');

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'database:migrate');
before('deploy:cache:clear', 'deploy:npm:install');
before('deploy:cache:clear', 'deploy:npm:build');

//Setup host
host('178.40.32.182')
    ->user('gameher')
    ->multiplexing(false)
    ->forwardAgent(true)
    ->set('deploy_path', '~/{{application}}');
