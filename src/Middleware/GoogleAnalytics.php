<?php

// Namespace
namespace Elite\Middleware;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// GoogleAnalytics
class GoogleAnalytics extends \Elite\Middleware\Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        $gAnal = getenv('G_ANALYTICS');

        // Add Global
        $this->container->view->getEnvironment()->addGlobal(
            // Name
            "analytics",
            // Content
            "<script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', '" . $gAnal . "', 'auto');
            ga('send', 'pageview');
            </script>"
        );

        // Return
        $response = $next($request, $response);
        return $response;
    }
}
