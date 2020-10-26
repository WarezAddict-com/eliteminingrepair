<?php

// Routes With GoogleAnalytics
$app->group('', function () {
    $this->get('/', 'HomeController:index')->setName('home');
    $this->post('/contact-us', 'ContactController:post')->setName('contact.post');
    $this->get('/contact-us', 'ContactController:get')->setName('contact.get');
})->add(new \Elite\Middleware\GoogleAnalytics($container));
