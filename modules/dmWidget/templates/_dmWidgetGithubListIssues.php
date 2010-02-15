<?php use_helper('Text');

/*
 * An $issue is an array containing: http://develop.github.com/p/issues.html#list_a_projects_issues
 */

echo _open('ul');

foreach($issues as $issue)
{
  echo _tag('li',

    // link to the user page on twitter
    _link('http://github.com/'.$user.'/'.$repo.'/'.$state.'#issue/'.$issue['number'])
    ->text($issue['title'])
    ->set('.issue_title').

    // render issue text
    _tag('p.issue_text', auto_link_text(escape($issue['body'])))
  
  );
}

echo _close('ul');