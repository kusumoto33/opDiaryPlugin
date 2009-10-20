<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('sns1@example.com', 'password');
$test->setCulture('en');

$test->get('/diary')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'index')
  ->end()

  ->with('response')->begin()
    ->checkElement('h3', 'Recently Posted Diaries')
  ->end()
;

$countPublicSNS = Doctrine::getTable('Diary')->createQuery()
  ->andWhereIn('public_flag', array(PluginDiaryTable::PUBLIC_FLAG_OPEN, PluginDiaryTable::PUBLIC_FLAG_SNS))
  ->count();

$test->info('Pager Test: diary/list')
  ->get('/diary/list')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of '.$countPublicSNS)
    ->checkElement('.pagerRelative .prev', false)
    ->checkElement('.pagerRelative .next', true)
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'list')
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '21 - 40 of '.$countPublicSNS)
    ->checkElement('.pagerRelative .prev', true)
    ->checkElement('.pagerRelative .next', true)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'list')
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'list')
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'list')
    ->isParameter('page', 1)
  ->end()
;

$test->info('Pager Test: diary/listFriend')
  ->get('/diary/listFriend')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 21')
    ->checkElement('.pagerRelative .prev', false)
    ->checkElement('.pagerRelative .next', true)
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listFriend')
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '21 - 21 of 21')
    ->checkElement('.pagerRelative .prev', true)
    ->checkElement('.pagerRelative .next', false)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listFriend')
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listFriend')
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listFriend')
    ->isParameter('page', 1)
  ->end()
;

$test->info('Pager Test: diary/listMember')
  ->get('/diary/listMember/3')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 20')
    ->checkElement('.pagerRelative .prev', false)
    ->checkElement('.pagerRelative .next', false)
  ->end()

  ->get('/diary/listMember/4')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 31')
    ->checkElement('.pagerRelative .prev', false)
    ->checkElement('.pagerRelative .next', true)
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '21 - 31 of 31')
    ->checkElement('.pagerRelative .prev', true)
    ->checkElement('.pagerRelative .next', false)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('page', 1)
  ->end()

  ->get('/diary/listMember/4/2009/4')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 26')
    ->checkElement('.pagerRelative .prev', false)
    ->checkElement('.pagerRelative .next', true)
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '21 - 26 of 26')
    ->checkElement('.pagerRelative .prev', true)
    ->checkElement('.pagerRelative .next', false)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('page', 1)
  ->end()

  ->get('/diary/listMember/4/2009/4/1')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 21')
    ->checkElement('.pagerRelative .prev', false)
    ->checkElement('.pagerRelative .next', true)
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('day', 1)
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '21 - 21 of 21')
    ->checkElement('.pagerRelative .prev', true)
    ->checkElement('.pagerRelative .next', false)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('day', 1)
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('day', 1)
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('year', 2009)
    ->isParameter('month', 4)
    ->isParameter('day', 1)
    ->isParameter('page', 1)
  ->end()

  ->get('/diary/listMember/4/2009/6')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', false)
  ->end()
;
