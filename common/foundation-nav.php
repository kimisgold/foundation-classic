<?php

/* Based on https://github.com/fabiopaiva/zf2-navigation-bootstrap3 */

/* @var $container Zend\Navigation\Navigation */
$container = $this->container;
?>
<div class="title-bar" data-responsive-toggle="top-nav" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle aria-label="Menu"></button>
  <button type="button" class="search-toggle button" aria-label="<?php echo __('Search'); ?>"><i class="fas fa-search"></i></button>
</div>
<ul id="top-nav" class="vertical menu" data-responsive-menu="accordion medium-dropdown">
    <?php foreach ($container as $page): ?>
        <?php if (!$this->navigation()->accept($page)) continue; ?>
        <?php /* @var $page Zend\Navigation\Page\Mvc */ ?>
        <?php $hasChildren = $page->hasPages() ?>
        <?php if (!$hasChildren): ?>
            <li<?php if ($page->isActive()) echo ' class="active"' ?>>
                <a 
                    class="nav-header" 
                    href="<?php echo $page->getHref() ?>"
                    <?php if ($page->getTarget() != ""): ?>
                        target="<?php echo $page->getTarget(); ?>"
                    <?php endif; ?>
                    >
                        <?php if ($page->get("icon") !== ""): ?>
                        <span class="<?php echo $page->get("icon"); ?>"></span>
                    <?php endif; ?>
                    <?php echo html_escape($this->translate($page->getLabel())); ?>
                </a>
            </li>
        <?php else: ?>
            <?php
            //check if access is allowed at least one item
            $access = false;
            foreach ($page->getPages() as $child) {
                if ($this->navigation()->accept($child) && $child->get("separator") !== true) {
                    $access = true;
                }
            }
            if ($access) :
                ?>
                <li class="dropdown<?php if ($page->isActive(true)) echo ' active' ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo html_escape($this->translate($page->getLabel())); ?>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown menu">
                        <?php foreach ($page->getPages() as $child): ?>
                            <?php if (!$this->navigation()->accept($child)) continue; ?>
                            <?php if ($child->get("separator") === true): ?>
                                <li class="divider"></li>
                                    <?php
                                    continue;
                                endif;
                                ?>
                            <li<?php if ($child->isActive()) echo ' class="active"' ?>>
                                <a 
                                    href="<?php echo $child->getHref() ?>"
                                    <?php if ($child->getTarget() != ""): ?>
                                        target="<?php echo $child->getTarget(); ?>"
                                    <?php endif; ?> >
                                        <?php if ($child->get("icon") !== ""): ?>
                                        <span class="<?php echo $child->get("icon"); ?>"></span>
                                    <?php endif; ?>
                                    <?php echo html_escape($this->translate($child->getLabel())); ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </li>   
            <?php endif; ?>
        <?php endif ?>
    <?php endforeach ?>
</ul>
