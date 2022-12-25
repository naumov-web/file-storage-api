<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Документация по File Storage API</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Source+Code+Pro:300,600|Titillium+Web:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/swagger/swagger-ui.css" >
    <style>
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }
        body
        {
            margin:0;
            background: #fafafa;
        }
    </style>
</head>
<body>
<div id="swagger-ui"></div>

<script src="/js/swagger/swagger-ui-bundle.js"> </script>
<script src="/js/swagger/swagger-ui-standalone-preset.js"> </script>
<script>
    window.onload = function() {
        // Build a system
        const port = window.location.port;
        const ui = SwaggerUIBundle({
            url: url = window.location.protocol + "//" + window.location.hostname + (port ? (":" + port) : '') + "/docs/swagger-file",
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "StandaloneLayout"
        });
        window.ui = ui;
    }
</script>
</body>
</html>
