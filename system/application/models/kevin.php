<?php                                                


class Kevin extends Model
{
    function Kevin()
    {
        parent::Model();
    }

    function sync_tweets()
    {        
        if ($sxe = @simplexml_load_file(TWITTER_URL))
        {
            for ($i=0; $i<count($sxe); $i++)
            {
                $query = $this->db->get_where('tweets', array('id' => $sxe->status[$i]->id), 1, 0);

                if($query->num_rows() == 0)
                {
                    $tweet = array(
                        'message' => (string)$sxe->status[$i]->text,
                        'timestamp' => strtotime($sxe->status[$i]->created_at),
                        'id' => $sxe->status[$i]->id
                    );

                    $this->db->insert('tweets', $tweet);
                }
            }
        }
        
        return 0;
    }

    function grab_tweets()
    {
        $this->sync_tweets();
        $this->db->order_by('timestamp', 'desc');
        $query = $this->db->get('tweets', 5, 0);
        
        $results = array();
        
        foreach ($query->result() as $row)
        {
            $this->db->order_by('timestamp', 'asc');
            $commentquery = $this->db->get_where('comments', array('id'=>$row->id));
            
            $item = array(
                'id' => $row->id,
                'message' => $row->message,
                'timestamp' => $row->timestamp,
                'comments' => $commentquery->result_array()
            );
            
            array_push($results, $item);
            
        }
        
        return $results;
    }
    
    function grab_more($offset)
    {
        $this->db->order_by('timestamp', 'desc');
        $query = $this->db->get('tweets', 5, $offset);
        
        $results = array();
        
        foreach ($query->result() as $row)
        {
            $this->db->order_by('timestamp', 'desc');
            $commentquery = $this->db->get_where('comments', array('id'=>$row->id));
            
            $item = array(
                'id' => $row->id,
                'message' => $row->message,
                'timestamp' => $row->timestamp,
                'comments' => $commentquery->result_array()
            );
            
            array_push($results, $item);
            
        }
        
        return $results;
        
    }
}