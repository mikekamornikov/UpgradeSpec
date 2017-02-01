var gulp = require('gulp'),
    phpspec = require('gulp-phpspec'),
    behat = require('gulp-behat'),
    notify = require('gulp-notify'),
    path = require('path'),
    _ = require('lodash');

gulp.task('phpspec', function() {
    var options = {
        clear: true,
        formatter: 'dot',
        verbose: 'v',
        notify: true,
        noInteraction: true
    };
    gulp.src('phpspec.yml')
        .pipe(phpspec('', options))
        .on('error', notify.onError(testNotification('fail', 'phpspec')))
        .pipe(notify(testNotification('pass', 'phpspec')));;
});

gulp.task('behat', function() {
    var options = {
        format: 'progress',
        notify: true
    };
    gulp.src('behat.yml')
        .pipe(behat('', options))
        .on('error', notify.onError(testNotification('fail', 'behat')))
        .pipe(notify(testNotification('pass', 'behat')));
});

gulp.task('watch', function() {
    gulp.watch(['src/**/*.php', 'spec/**/*.php', 'features/**/*.feature'], ['test']);
});

gulp.task('test', ['phpspec', 'behat']);
gulp.task('default', ['test', 'watch']);

function testNotification(status, pluginName, override) {
    return _.merge({
        title:   ( status == 'pass' ) ? 'Tests Passed' : 'Tests Failed',
        message: ( status == 'pass' ) ? '\n\nAll tests have passed!\n\n' : '\n\nOne or more tests failed...\n\n',
        icon:    path.join(__dirname, 'node_modules/gulp-' + pluginName, 'assets/test-' + status + '.png')
    }, override);;
}
