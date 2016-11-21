<?php
/**
 * queries for articles /
 */
class Article extends Model {

    /**
     * get whole list of news /
     * @param array $attr
     * @return mixed
     */
    public function getList($attr = array())
    {
        if (empty($attr)) {
            $sql = "SELECT * FROM news ";
            return $this->db->query($sql); 
        } else {

            $sql_select = array();
            $sql_where = "";
            
            // form dat for string for itch in
            foreach($attr as $group_name => $group_value ) {

                $count = count($attr[$group_name]);
                switch ($group_name) {

                    case 'Категория':
                        $sql_select['category.name'] = "";
                        for ($i = 0; $i < $count; $i++){
                            $sql_select['category.name'] .= (($i+1) < $count) ? "'".$attr[$group_name][$i]."'," : "'".$attr[$group_name][$i]."')";
                        }
                        break;
                    case 'Теги':
                        $sql_select['tag.name'] = "";
                        for ($i = 0; $i < $count; $i++){
                            $sql_select['tag.name'] .= (($i+1) < $count) ? "'".$attr[$group_name][$i]."'," : "'".$attr[$group_name][$i]."')";
                        }
                        break;
                    case 'Год':
                        $sql_select['YEAR(news.create_date_time)'] = "";
                        for ($i = 0; $i < $count; $i++){
                            $sql_select['YEAR(news.create_date_time)'].= (($i+1) < $count) ? "'".$attr[$group_name][$i]."'," : "'".$attr[$group_name][$i]."')";
                        }
                        break;
                    default:
                        break;
                }
            }
            
            $sql_select['category.name'] = (empty( $sql_select['category.name'])) ? "" : "(category.name IN ({$sql_select['category.name']} OR category.id IN (SELECT t2.id as lev2
                                            FROM category AS t1
                                              LEFT JOIN category AS t2 ON t2.id_parent = t1.id
                                              LEFT JOIN category AS t3 ON t3.id_parent = t2.id
                                            WHERE t1.name IN ({$sql_select['category.name']} ) ) AND ";
            $sql_select['tag.name'] = (empty($sql_select['tag.name'])) ? "" : "tag.name IN ({$sql_select['tag.name']} AND ";
            $sql_select['YEAR(news.create_date_time)'] = (empty($sql_select['YEAR(news.create_date_time)'])) ? "" : "YEAR(news.create_date_time) IN ({$sql_select['YEAR(news.create_date_time)']} AND ";

//            echo"<pre>";
//            print_r($sql_select);
//            die;
            // form 1 string for all where condition
//            foreach ($sql_select as $key => $value) {
//                //$sql_where .= (empty($key)) ? "" : $key . " IN (" . $value . " AND ";
//
//            }

            $sql_where = implode("",$sql_select);
            $sql_where .= "1";

//            echo"<pre>";
//            print_r($sql_select['tag.name']);
//            print_r($sql_where);
//            die;

            $sql = "
SELECT DISTINCT news.title, news.* FROM news
  LEFT JOIN news_category ON news.id = news_category.id_news
  LEFT JOIN category ON news_category.id_category = category.id
  LEFT JOIN news_tag ON news.id = news_tag.id_news
  LEFT JOIN tag ON news_tag.id_tag = tag.id
WHERE " . $sql_where;

            return $this->db->query($sql);
        }
    }

    /**
     * get one news by its id /
     * @param $id
     * @return null
     */
    public function getByID ($id)
    {
        $id = $this->db->escape($id);
        $sql = "
SELECT * 
  FROM news 
    WHERE id = '{$id}'
";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    /**
     * return latest article id /
     * @return null
     */
    public function getID ()
    {
        $sql = "
SELECT * 
  FROM news 
    ORDER BY id DESC
      LIMIT 1
";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0]['id'] : null;
    }

    /**
     * query for getting all tag for 1 article
     * @param $id
     * @return mixed
     */
    public function getArticleTags($id)
    {
        $id = $this->db->escape($id);
        $sql = "
SELECT * FROM news
  LEFT JOIN news_tag ON news.id = news_tag.id_news
  LEFT JOIN tag ON news_tag.id_tag = tag.id
    WHERE news.id = '{$id}'
      ORDER BY tag.name DESC
";
        $result = $this->db->query($sql);
        return $result;
    }

    /**
     * for save and edit articles /
     * @param $data
     * @param bool $id
     * @return mixed
     */
    public function save($data, $id = false)
    {
        $id = (int)$id; // id need if we want to edit 
        
        // shield the sql injections
        $title      = $this->db->escape($data['title']);
        $text       = $this->db->escape($data['text']);
        $analytical = isset($data['analytical']);

        if (!$id) { // add new record
            $sql = "
INSERT INTO news
  SET title      = '{$title}',
      text       = '{$text}',
      analytical = '{$analytical}'
";
        } else { // update existing record
            $sql = "
UPDATE news
  SET title      = '{$title}',
      text       = '{$text}',
      analytical = '{$analytical}'
    WHERE id = '{$id}'
";
        }

        return $this->db->query($sql);
    }

    /**
     * generate data for 2 advertising blocks /
     */
    public function getAdvertising()
    {
        $sql = "SELECT * FROM advertising";
        return $this->db->query($sql);
    }

    /**
     * select attributes values and names /
     * @return mixed
     */
    public function getAttributes()
    {

        $sql = "
SELECT category.name as value, 'Категория' AS id
  FROM category
    WHERE id_parent = 0
UNION

SELECT tag.name as value, 'Теги' AS id
  FROM tag
UNION

SELECT YEAR(news.create_date_time) AS value, 'Год' AS id
  FROM news
    GROUP BY YEAR(news.create_date_time)";

        return $this->db->query($sql);
    }

    /**
     * get all analitycal news
     * @return mixed
     */
    public function getAnalyticalList()
    {
        $sql = "
SELECT * 
  FROM news
    WHERE news.analytical=1
";
        return $this->db->query($sql);;
    }

    /**
     * All coments for 1 article /
     * @param $id_comment
     * @return
     */
    public function getArticleComments($id_comment) 
    {
        $id = $this->db->escape($id_comment);
        $sql = "
SELECT *
FROM user
  JOIN news ON user.id = news.id_user
  JOIN comment ON news.id = comment.id_news
WHERE news.id = '{$id}'
      AND comment.plus = (SELECT plus FROM comment WHERE id_news='{$id}' ORDER BY plus DESC LIMIT 1)
      AND comment.approved IS NOT NULL
UNION
SELECT *
FROM user
  JOIN news ON user.id = news.id_user
  JOIN comment ON news.id = comment.id_news
WHERE news.id = '{$id}'
      AND comment.plus <> (SELECT plus FROM comment WHERE id_news='{$id}' ORDER BY plus DESC LIMIT 1)
      AND comment.approved IS NOT NULL;
";

        return $this->db->query($sql);
    }

    public function saveComment( $id_news,$id_user,$id_parent,$id_text)
    {
        $news = $this->db->escape($id_news);
        $user = $this->db->escape($id_user);
        $parent = $this->db->escape($id_parent);
        $text = $this->db->escape($id_text);

        $sql_1 = "
        SELECT * FROM category 
JOIN news_category ON category.id = news_category.id_category
JOIN news ON news_category.id_news = news.id
WHERE category.id NOT IN (SELECT t2.id FROM category AS t1
                                              LEFT JOIN category AS t2 ON t2.id_parent = t1.id
                                              LEFT JOIN category AS t3 ON t3.id_parent = t2.id
                                            WHERE t1.name = 'Политика')
                                            AND category.name <> 'Политика'
                                            AND news.id = '$id_news';
                                            ";

        $approved = (empty($this->db->query($sql_1))) ? "" : 1;

        $sql = "
INSERT INTO comment (id_user,id_parent,text,id_news,approved) 
  VALUES ('$user','$parent','$text','$news','$approved')
";
        $this->db->query($sql);
    }

    public function getArticleUser($id_user)
    {
        $id = $this->db->escape($id_user);

        $sql = "
SELECT * 
  FROM user 
    WHERE user.id='{$id}'
      LIMIT 1
";
        return $this->db->query($sql);
    }
}
    





    













/*
 Можно брать от сюда actions
class News extends Model {

    /**
     * @param bool $analytical /
     * @internal param $only_analytical /
     * if parameter is true then return all analytical articles* if parameter is true then return all analytical articles /
     * and return result of sql query work /
     * @return null /
     
    public function getList($analytical = false)
    {
        $sql = "
SELECT * 
  FROM news";
        if ($analytical) {
            $sql .= "WHERE analytical = 1";
        }
        return $this->db->query($sql);
    }

    public function getArticleById($id)
    {
        // we need escape for sql injections
        $id = $this->db->escape($id);
        $sql = "
SELECT * 
  FROM news 
    WHERE id = '{$id}' 
      LIMIT 1";
        return $this->runSqlQuery($sql);
    }

    public function getNewsByCategoryId($category_id)
    {
        $category_id = $this->db->escape($category_id);
        $sql = "
SELECT categories.id, categories.name, news.title
	FROM categories 
    	LEFT JOIN news_category 
        	ON categories.id = news_category.id_category
        LEFT JOIN news 
        	ON news_category.id_news = news.id
			WHERE categories.id = '{$category_id}'";
        return $this->runSqlQuery($sql);
    }

    public function getNewsByTagId($tag_id)
    {
        $tag_id = $this->db->escpe($tag_id);
        $sql = "
SELECT tag.id, tag.name, news.title
	FROM tag 
    	LEFT JOIN news_tag 
        	ON tag.id = news_tag.id_tag
        LEFT JOIN news 
        	ON news_tag.id_news = news.id
			WHERE tag.id = '{$tag_id}'";
        return $this->runSqlQuery($sql);
    }

    public function getNewsByTagName($tag_name)
    {
        $tag_name = $this->db->escpe($tag_name);
        $sql = "
SELECT tag.id, tag.name, news.title
	FROM tag 
    	LEFT JOIN news_tag 
        	ON tag.id = news_tag.id_tag
        LEFT JOIN news 
        	ON news_tag.id_news = news.id
			WHERE tag.name = '{$tag_name}'";
        return $this->runSqlQuery($sql);
    }

    private function runSqlQuery($sql)
    {
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }
}*/