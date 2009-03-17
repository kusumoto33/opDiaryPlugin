<?php op_mobile_page_title(__('Diary of %1%', array('%1%' => $member->getName())), $diary->getTitle()) ?>
<?php use_helper('opDiary') ?>

<?php echo op_within_page_link() ?>
<?php echo op_format_date($diary->getCreatedAt(), 'XDateTime') ?>
<?php if ($diary->getMemberId() === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Edit'), 'diary_edit', $diary) ?>][<?php echo link_to(__('Delete'), 'diary_delete_confirm', $diary) ?>]
<?php endif; ?><br>

<?php echo nl2br($diary->getBody()) ?><br>

<?php foreach ($diary->getDiaryImages() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->getFile(), array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>

(<?php echo $diary->getPublicFlagLabel() ?>)<br>

<?php if ($diary->getPrevious($sf_user->getMemberId()) || $diary->getNext($sf_user->getMemberId())): ?>
<hr>
<center>
<?php if ($diary->getPrevious($sf_user->getMemberId())): ?> <?php echo link_to(__('Previous Diary'), 'diary_show', $diary->getPrevious($sf_user->getMemberId())) ?><?php endif; ?>
<?php if ($diary->getNext($sf_user->getMemberId())): ?> <?php echo link_to(__('Next Diary'), 'diary_show', $diary->getNext($sf_user->getMemberId())) ?><?php endif; ?>
</center>
<?php endif; ?>

<?php include_component('diaryComment', 'list', array('diary' => $diary)) ?>

<hr>
<?php echo op_within_page_link('') ?>
<?php
$options['title'] = __('Post a diary comment');
$options['url'] = url_for('diary_comment_create', $diary);
$options['button'] = __('Save');
$options['isMultipart'] = true;
op_include_form('formDiaryComment', $form, $options);
?>

<hr>
<?php echo link_to(__('Diaries of %1%', array('%1%' => $member->getName())), 'diary_list_member', $member) ?><br>
<?php if ($diary->getMemberId() !== $sf_user->getMemberId()): ?>
<?php echo link_to(__('Profile of %1%', array('%1%' => $member->getName())), 'member/profile?id='.$member->getId()) ?><br>
<?php endif; ?>
