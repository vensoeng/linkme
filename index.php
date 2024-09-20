<?php

require 'routes/index.php';

// Get the requested URI
$request = $_SERVER['REQUEST_URI'];

// Remove query string from URI (if any)
$requestPath = strtok($request, '?');

// Remove trailing slash from the request URI if it's not the root URL
if ($requestPath !== '/' && substr($requestPath, -1) === '/') {
    $requestPath = rtrim($requestPath, '/');
}

// Match routes with placeholders
$matchedRoute = null;
$params = [];

foreach ($routes as $route => $target) {
    // Convert route pattern to a regular expression
    $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([a-zA-Z0-9-_]+)', $route);
    $pattern = str_replace('/', '\/', $pattern);
    
    // Match the current request with the pattern
    if (preg_match('/^' . $pattern . '$/', $requestPath, $matches)) {
        $matchedRoute = $target;
        array_shift($matches); // Remove the full match
        $params = $matches;
        break;
    }
}

if ($matchedRoute) {
    // Manually assign the matched parameters to variables
    if (isset($params[0])) {
        $item = $params[0]; // Assign the first parameter to $item
    }

    // Include the target file
    require $matchedRoute;
} else {
    // If route doesn't exist, show 404 page
    http_response_code(404);
    echo 'Page Not Found 404';
}
