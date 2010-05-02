<?php

class dmWidgetGithubListIssuesView extends dmWidgetPluginView
{
  
  public function configure()
  {
    parent::configure();
    
    $this->addRequiredVar(array('user', 'repo', 'state', 'nb_issues', 'life_time'));
  }

  protected function filterViewVars(array $vars = array())
  {
    $vars = parent::filterViewVars($vars);

    $vars['issues'] = $this->listIssues($vars['user'], $vars['repo'], $vars['state'], $vars['nb_issues'], $vars['life_time']);
    
    return $vars;
  }
  
  protected function doRenderForIndex()
  {
    $vars   = $this->filterViewVars($this->compiledVars);
    $issues = array();
    
    foreach($vars['issues'] as $issue)
    {
      $issues[] = $issue['title'].' '.$issue['user'].' '.$issue['body'];
    }
    
    return $vars['user'].' '.$vars['repo'].' '.implode(', ', $issues);
  }

  protected function listIssues($user, $repo, $state, $nb, $lifeTime)
  {
    $cache = $this->getService('cache_manager')->getCache('dm_github_list_issues');
    $cacheKey = md5($user.$repo.$state.$nb);

    if ($cache->has($cacheKey))
    {
      $issues = $cache->get($cacheKey);
    }
    else
    {
      $github = new phpGitHubApi();

      $issues = array_slice($github->getIssueApi()->getList($user, $repo, $state), 0, $nb);

      $issues = $this->context->getEventDispatcher()->filter(
        new sfEvent($this, 'dm.widget_github.list_issues', array(
          'user' => $user,
          'repo' => $repo,
          'state' => $state
        )),
        $issues
      )->getReturnValue();
      
      $cache->set($cacheKey, $issues, $lifeTime);
    }

    return $issues;
  }
  
}