<?php use_helper('Text', 'Date');

/*
 * An $issue is an array containing: http://develop.github.com/p/issues.html#list_a_projects_issues
 */

echo _open('ul');

foreach($issues as $issue)
{
  // link to the issue page on github
  if($state == 'open')
  {
    $issueLink = _link('http://github.com/'.$user.'/'.$repo.'/issues#issue/'.$issue['number']);
  }
  else
  {
    $issueLink = _link('http://github.com/'.$user.'/'.$repo.'/issues/'.$state.'#issue/'.$issue['number']);
  }
  $issueLink->text($issue['title'])
    ->set('.issue_title');

  echo _tag('li',

    $issueLink.

    // render issue date
    format_date($issue['created_at'], 'd/MM H:mm').

    // link to the issue user on github
    _link('http://github.com/'.$issue['user'])->text(escape($issue['user'])).

    // render issue text
    _tag('p.issue_text', auto_link_text(escape($issue['body'])))
  
  );
}

echo _close('ul');
