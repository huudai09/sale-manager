if (!window.jsFiles) {
    window.jsFiles = [
        //libs
        "lib/jquery-1.9.0.js",
        "lib/module.js",
        //app
        "app/app.js",
        "app/app.async.js"
    ];
    for (var i = 0; i < jsFiles.length; i++) {
        document.write("<script src='" + ASSET + '/js/' + jsFiles[i] + "'></script>");
    }
}