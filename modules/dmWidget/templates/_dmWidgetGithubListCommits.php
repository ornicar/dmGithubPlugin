<?php use_helper('Text');

/*
 * A $commit is an array containing: http://develop.github.com/p/commits.html#listing_commits_on_a_branch
 */

echo _open('ul');

foreach($commits as $commit)
{
  echo _tag('li',

    // link to the user page on twitter
    _link($commit['url'])
    ->text(auto_link_text(escape($commit['message'])))
    ->set('.commit_title').

    // render commit user name
    _tag('p.commit_user_name', escape($commit['author']['name']))
  
  );
}

echo _close('ul');