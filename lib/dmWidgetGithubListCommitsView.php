<?php

class dmWidgetGithubListCommitsView extends dmWidgetPluginView
{
  
  public function configure()
  {
    parent::configure();
    
    $this->addRequiredVar(array('user', 'repo', 'branch', 'nb_commits', 'life_time'));
  }

  protected function filterViewVars(array $vars = array())
  {
    $vars = parent::filterViewVars($vars);

    $vars['commits'] = $this->listIssues($vars['user'], $vars['repo'], $vars['branch'], $vars['nb_commits'], $vars['life_time']);
    
    return $vars;
  }
  
  protected function doRenderForIndex()
  {
    $commits = array();
    
    foreach($this->compiledVars['commits'] as $commit)
    {
      $commits[] = $commit['message'].' '.$commit['author']['name'];
    }
    
    return $vars['user'].' '.$vars['repo'].' '.$vars['branch'].' '.implode(', ', $commits);
  }

  protected function listIssues($user, $repo, $branch, $nb, $lifeTime)
  {
    $cache = $this->getService('cache_manager')->getCache('dm_github_list_commits');
    $cacheKey = md5($user.$repo.$branch.$nb);

    if ($cache->has($cacheKey))
    {
      $commits = $cache->get($cacheKey);
    }
    else
    {
      $api = new phpGitHubApi();

      $commits = array_slice($api->listBranchCommits($user, $repo, $branch), 0, $nb);

      $commits = $this->context->getEventDispatcher()->filter(
        new sfEvent($this, 'dm.widget_github.list_commits', array(
          'user' => $user,
          'repo' => $repo,
          'branch' => $branch
        )),
        $commits
      )->getReturnValue();
      
      $cache->set($cacheKey, $commits, $lifeTime);
    }

    return $commits;
  }
  
}