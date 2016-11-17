<?php
/**
 * for home page /
 */
class HomeController extends Controller {

    /**
     * MainController constructor /
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Main();
    }

    /**
     * function for buildung treee with categories and news for them /
     * this function similar for all ROLES /
     * @param $id_parent
     * @param $level
     */
    public function build_tree($id_parent, $level){
        if (isset($this->data['cat'][$id_parent])) { // if categories with such id_parent exists
            foreach ($this->data['cat'][$id_parent] as $value) { // check it

                /*
                 * write categories
                 * $level * 25 = margin, $level contains current level(0,1,2...)
                 */
                switch (App::getRouter()->getMethodPrefix()) {
                    case 'admin_':
                        $this->data['tree'] .= "<div style='margin-left:".($level*25)."px;'><h3>
                                            <a href='/admin/categories/view/". $value['id'] . "'>" . $value['name'] . "</a></h3></div>" . PHP_EOL;
                        break;
                    case 'user_':
                        $this->data['tree'] .= "<div style='margin-left:".($level*25)."px;'><h3>
                                            <a href='/user/categories/view/". $value['id'] . "'>" . $value['name'] . "</a></h3></div>" . PHP_EOL;
                        break;
                    case '':
                        $this->data['tree'] .= "<div style='margin-left:".($level*25)."px;'><h3>
                                            <a href='/categories/view/". $value['id'] . "'>" . $value['name'] . "</a></h3></div>" . PHP_EOL;
                        break;
                    default:
                        break;
                }

                /*
                 * write one news with link type /news/view/id
                 */
                switch (App::getRouter()->getMethodPrefix()) {
                    case 'admin_':
                        foreach ($this->data['tree_news'] as $one_news) { // looking for news in this categories
                            if($one_news['id_category'] == $value['id']) {
                                $this->data['tree'] .= "<div style='margin-left:".($level*25)."px;'>
                                                    <a href='/admin/news/view/" . $one_news['id'] . "'>" . $one_news['title'] . "</a></div>";
                            }
                        }
                        break;
                    case 'user_':
                        foreach ($this->data['tree_news'] as $one_news) { // looking for news in this categories
                            if($one_news['id_category'] == $value['id']) {
                                $this->data['tree'] .= "<div style='margin-left:".($level*25)."px;'>
                                                    <a href='/user/news/view/" . $one_news['id'] . "'>" . $one_news['title'] . "</a></div>";
                            }
                        }
                        break;
                    case '':
                        foreach ($this->data['tree_news'] as $one_news) { // looking for news in this categories
                            if($one_news['id_category'] == $value['id']) {
                                $this->data['tree'] .= "<div style='margin-left:".($level*25)."px;'>
                                                    <a href='/news/view/" . $one_news['id'] . "'>" . $one_news['title'] . "</a></div>";
                            }
                        }
                        break;
                    default:
                        break;
                }

                $level++;
                $this->build_tree($value['id'],$level);
                $level--;
            }
        }
    }


    // actions for all visitors ====================
    // index TODONE

    /**
     * default action for home controller and for home page /
     */
    public function index()
    {
        // data for OwlCarousel
        $this->data['carousel'] = $this->model->getCarouselData();

        // data for top 5 user with biggest amount of comments
        $this->data['users'] = $this->model->getUsersLogins();

        // data for top 3 topics with the most comments for previous day
        $this->data['topics'] = $this->model->getTopThreeTopics();

        // data for building categories tree TODONE fill data
        $this->data['cat'] = $this->model->getCategoryTree();
        $this->data['tree_news'] = $this->model->getNewsByCategory();
        $this->data['tree'] = "";
        $this->build_tree(0,0);

        // data news titles for categories tree TODO fill data
        $this->data['news'] = $this->model->getNewsByCategory();
    }


    // actions for administrators ====================
    // index TODONE

    /**
     * home page for administrator /
     * same as for everyone /
     */
    public function admin_index()
    {

    }


    // actions for login users ====================
    //index TODONE

    /**
     * home page for user /
     * same as for everyone /
     */
    public function user_index()
    {

    }


    // actions for moderators ====================
    // index TODO

    /**
     * home page for moderator /
     * same as for everyone /
     */
    public function moderator_index()
    {

    }
}