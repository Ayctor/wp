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
host('rec.es1')
    ->stage('recette')
    ->set('deploy_path', '/home/websites/deployer/');

// Tasks
set('bin/npm', function () {
    return run('which npm');
});

desc('Install npm packages');
task('npm:install', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run("cd {{release_path}} && {{bin/npm}} install");
});
after('deploy:update_code', 'npm:install');

desc('Build assets');
task('npm:build', function () {
    run("cd {{release_path}} && {{bin/npm}} run production");
});
after('npm:install', 'npm:build');

// set('bin/wp', function () {
//     return run('which wp');
// });
// task('reset:opcache', function () {
//     run('cd {{release_path}} && {{bin/wp}} reset opcache');
// });
// after('deploy', 'reset:opcache');
