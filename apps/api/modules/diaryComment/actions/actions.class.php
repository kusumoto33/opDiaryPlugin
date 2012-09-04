<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * diary api actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Shunsuke Watanabe <watanabe@craftgear.net>
 */
class diaryCommentActions extends opJsonApiActions
{
  public function preExecute()
  {
    parent::preExecute();
    $this->member = $this->getUser()->getMember();
  }

  public function executePost(sfWebRequest $request)
  {
    $this->forward400If('' === (string)$request['diary_id'], 'diary_id parameter is not specified.');
    $this->forward400If('' === (string)$request['body'], 'body parameter is not specified.');

    $diaryComment = new DiaryComment();
    $diaryComment->setMemberId($this->member->getId());
    $diaryComment->setDiaryId($request['diary_id']);
    $diaryComment->setBody($request['body']);
    $diaryComment->save();

    $this->comment = $diaryComment;
  }

  public function executeDelete(sfWebRequest $request)
  {
  }

}
