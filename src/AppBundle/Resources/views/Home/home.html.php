<?php $view->extend('::base.html.twig') ?>

<?php $view['slots']->set('title', 'AppBundle:Home:home') ?>

<?php $view['slots']->start('body') ?>
    <h1>Welcome to the Home:home page</h1>
<?php $view['slots']->stop() ?>
