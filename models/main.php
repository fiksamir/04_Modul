<?php
/**
 * data for home page /
 * data for home controller /
 * here will be no actions for admin or user or moderator /
 */
class Main extends Model {

    /**
     * select titles of 4 latest news and images for them /
     * @return mixed
     */
    public function getCarouselData()
    {
        $sql = "
SELECT id, title
  FROM news 
    ORDER BY create_date_time DESC 
      LIMIT 4
";
        return $this->db->query($sql);
    }

    /**
     * action for selection top 5 users with the biggest amount of comments /
     * @return mixed
     */
    public function getUsersLogins()
    {
 
    }

    /**
     * get top 3 topics with biggest amount of comment for this month /
     * @return mixed
     */
    public function getTopThreeTopics()
    {

    }

    /**
     * generate array for categories tree /
     * @return array
     */
    public function getCategoryTree()
    {
        $sql = "
SELECT * 
  FROM category
 ";
        $result = $this->db->query($sql);
        $return = array();
        foreach($result as $val) {
            $return[$val['id_parent']][] = $val;
        }
        return $return;
    }

    /**
     * query for news sorted by categories /
     * @return mixed
     */
    public function getNewsByCategory()
    {
        $sql_categories = "SELECT * FROM category"; // select all categories
        $categories = $this->db->query($sql_categories);
        $return = array();

        /*
         * for each category select latest 5 news
         */
        foreach ($categories as $category) {
            $sql = "
SELECT title,create_date_time,news.id AS id,category.id AS id_category 
  FROM news
    LEFT JOIN news_category ON news.id = news_category.id_news
    LEFT JOIN category ON news_category.id_category = category.id
  WHERE category.id = " . $category['id'] . "
  ORDER BY news.create_date_time DESC
  LIMIT 5
";
            $return = array_merge($return,$this->db->query($sql));
        }
        return $return;
    }
}