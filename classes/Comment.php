<?php
class Comment
{
    private $m_iID;
    private $m_sComment;
    private $m_iUserId;
    private $m_iPostId;


    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty) {
        case 'id':
            $this->m_iID = $p_vValue;
            break;

        case 'comment':
            $this->m_sComment = $p_vValue;
            break;

        case 'user_id':
            $this->m_iUserId = $p_vValue;
            break;

        case 'post_id':
            $this->m_iPostId = $p_vValue;
            break;

    }
    }

    public function __get($p_sProperty)
    {
      switch ($p_sProperty) {
      case 'id':
          return $this->m_iID;
          break;

      case 'comment':
          return $this->m_sComment;
          break;

      case 'user_id':
          return $this->m_iUserId;
          break;

      case 'post_id':
          return $this->m_iPostId;
          break;

  }
    }

    public function saveComment()
    {
        try {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO `comments`(`comment`, `user_id`,  `post_id` ) VALUES (:comment, :user_id, :post_id );");
            $statement->bindValue(":comment", $this->m_sComment);
            $statement->bindValue(":user_id", $_SESSION['userid']);
            $statement->bindValue(":post_id", $this->m_iPostId);
            $statement->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
    }

    public function loadComment()
    {
      try{
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM comments where post_id = 37");
      //  $statement->bindValue(":post_id", $this->m_iPostId);
        $statement->execute();
        $comments = $statement->fetchall(PDO::FETCH_ASSOC);
        foreach ($comments as $r ) {
          $this->m_sComment=$r['comment'];
          echo "<br>";
          echo $r['comment'];
          echo "<br>";
        }

      // print_r($res);
        return $comments;
      }
      catch(PDOException $e)
      {
        $error->$e->getMessage();
      }
    }





}

 ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  




                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
