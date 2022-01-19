<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<main>
    <div class="container">
        <article>
            <header class="article-header">
                <div class="thumb">
                    <div>
                        <h1><?php $this->title() ?></h1>
                        <div class="post-meta">
                            <div>
                            <a>By <?php $this->author(); ?></a> | 
                            <time><?php $this->date('M j, Y'); ?></time>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </article>
        <div class="article-post">
            <?php $this->content(); ?>
        </div>
        <?php if ($this->options->TheComments): ?>
        <div class="container">
            <?php $this->need('comments.php'); ?>
        </div>
        <?php else: ?>
        <div class="container">
            <div class="alert info">已关闭全局评论。</div>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php $this->need('footer.php'); ?>