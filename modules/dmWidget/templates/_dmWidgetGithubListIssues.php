<?php use_helper('Text', 'Date');

/*
 * An $issue is an array containing: http://develop.github.com/p/issues.html#list_a_projects_issues
 */

echo _open('ul');

foreach($issues as $issue)
{
  echo _tag('li',

    // link to the issue page on github
    _link('http://github.com/'.$user.'/'.$repo.'/'.$state.'#issue/'.$issue['number'])
    ->text($issue['title'])
    ->set('.issue_title').

    // render issue date
    format_date($issue['created_at'], 'd/MM H:mm').

    // link to the issue user on github
    _link('http://github.com/'.$user)->text(escape($issue['user'])).

    // render issue text
    _tag('p.issue_text', auto_link_text(escape($issue['body'])))
  
  );
}

echo _close('ul');