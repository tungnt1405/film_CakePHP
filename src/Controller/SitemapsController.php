<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class SitemapsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // $this->Authentication->addUnauthenticatedActions(['index']);
    }
    
    public function index()
    {
        $this->viewBuilder()->setLayout('sitemap');
        $this->RequestHandler->respondAs('xml');
        //Articles Table
        $articleTbl = TableRegistry::getTableLocator()->get('categories');
        $articles = $articleTbl->find()->select(['slug','modified']);
        $this->set('articles', $articles);
        //Blogs Table
        $blogTbl = TableRegistry::getTableLocator()->get('movies');
        $blogs = $blogTbl->find()->select(['m_slug','modified']);
        $this->set('blogs', $blogs);
        //Projects Table
        $projectTbl = TableRegistry::getTableLocator()->get('countries');
        $projects = $projectTbl->find()->select(['country_slug','modified']);
        $this->set('projects', $projects);
        
        //debug($articles);
        //exit;

        //Get the base URL of your website
        $url = Router::url('/', true);
        $this->set('url', $url);

    }

}
?>
