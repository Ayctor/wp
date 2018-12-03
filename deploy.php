<?php
namespace Deployer;

require 'recipe/composer.php';

// Configuration
set('ssh_type', 'native');
set('repository', 'git@bitbucket.org:ayctor/cwpt.git');
set('shared_files', [
    '.env',
]);
set('shared_dirs', [
    'mu-plugins',
]);
set('writable_dirs', []);

// Servers
host('forge@qa.ayctor.io')
    ->stage('test')
    ->set('deploy_path', '/home/forge/deploy/');

// Tasks
set('bin/npm', function () {
    return run('which npm');
});

desc('Install npm packages');
task('npm:install', function () {
    run("cd {{release_path}} && {{bin/npm}} ci --no-audit");
});
after('deploy:update_code', 'npm:install');

desc('Build assets');
task('npm:build', function () {
    run("cd {{release_path}} && {{bin/npm}} run production");
});
after('npm:install', 'npm:build');

desc('Reload PHP');
task('php:reload', function(){
    run('sudo /usr/sbin/service php7.2-fpm reload');
})->onStage('test');
after('deploy:symlink', 'php:reload');

// set('bin/wp', function () {
//     return run('which wp');
// });
// task('reset:opcache', function () {
//     run('cd {{release_path}} && {{bin/wp}} reset opcache');
// });
// after('deploy', 'reset:opcache');
