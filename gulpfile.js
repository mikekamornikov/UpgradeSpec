var gulp = require("gulp"),
    phpspec = require("gulp-phpspec"),
    notify = require("gulp-notify"),
    _ = require('lodash');

gulp.task("test", function() {
    var options = {
        clear: true,
        formatter: "pretty",
        verbose: "v",
        notify: true,
        noInteraction: true
    };
    gulp.src("phpspec.yml")
        .pipe(phpspec("", options))
        .on("error", notify.onError(testNotification("fail", "phpspec")))
        .pipe(notify(testNotification('pass', 'phpspec')));;
});

gulp.task("watch", function() {
    gulp.watch(["spec/**/*.php", "src/**/*.php"], ["test"]);
});

gulp.task("default", ["test", "watch"]);

function testNotification(status, pluginName, override) {
    return _.merge({
        title:   ( status == 'pass' ) ? 'Tests Passed' : 'Tests Failed',
        message: ( status == 'pass' ) ? '\n\nAll tests have passed!\n\n' : '\n\nOne or more tests failed...\n\n',
        icon:    __dirname + '/node_modules/gulp-' + pluginName +'/assets/test-' + status + '.png'
    }, override);;
}
