<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    } 
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';
?>
 
<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>">
        <div class="comment-author">
            <?php $comments->gravatar('40', ''); ?>
            <cite class="fn"><?php $comments->author(); ?></cite>
        </div>
        <div class="comment-meta">
            <span class="date"><?php $comments->date('M j, Y'); ?></span>
            <span class="comment-reply"><?php $comments->reply(); ?></span>
        </div>
        <?php $comments->content(); ?>
    </div>
<?php if ($comments->children) { ?>
    <div class="comment-children box">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</li>

<?php } ?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
        <div class="cancel-comment-reply">
        <?php $comments->cancelReply(); ?>
        </div>
    	<h4 class="article-post"><?php _e('添加新评论'); ?></h4>
    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" class="comment-form" role="form">
            <?php if($this->user->hasLogin()): ?>
    		<p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
            <?php else: ?>
    		<p>
                <label for="author" class="required"><?php _e('称呼'); ?></label>
    			<input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
    		</p>
    		<p>
                <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('Email'); ?></label>
    			<input type="text" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
    		</p>
    		<p>
                <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
    			<input type="text" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
    		</p>
            <?php endif; ?>
            <?php if ($this->options->TheVerification): ?>
            <p>
                <?php spam_protection_math();?>
            </p>
            <?php endif; ?>
    		<p>
                <label for="textarea" class="required"><?php _e('内容'); ?></label>
                <textarea rows="8" cols="50" name="text" id="comment" class="textarea" required ><?php $this->remember('text'); ?></textarea>
            </p>
    		<p>
                <button type="submit" id="submit" class="submit"><?php _e('提交评论'); ?></button>
                <button type="reset" id="submit" class="submit"><?php _e('清空内容'); ?></button>
            </p>
            <?php $security = $this->widget('Widget_Security'); ?>
            <input type="hidden" name="_" value="<?php echo $security->getToken($this->request->getReferer())?>">
    	</form>
    </div>
    <?php if ($comments->have()): ?>
	<h4 class="comments-title-article-post"><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h4>
    <a class="article-post"><?php $comments->listComments(); ?></a>
    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    <?php endif; ?>
    <?php else: ?>
    <div class="alert info">当前页面的评论已被关闭。</div>
    <?php endif; ?>
</div>