var gulp = require("gulp");
var phpspec = require("gulp-phpspec");
var notify = require("gulp-notify");

gulp.task("test", function() {
    var options = { clear: true, formatter: "pretty", verbose: "v", notify: true };
    gulp.src("spec/**/*.php")
        .pipe(phpspec("", options))
        .on("error", notify.onError({
            title: "Error",
            message: "Your tests failed!"
        }))
        .pipe(notify({
            title: "Success",
            message: "All tests passed!"
        }));
});

gulp.task("watch", function() {
    gulp.watch(["spec/**/*.php", "src/**/*.php"], ["test"]);
});

gulp.task("default", ["test", "watch"]);
