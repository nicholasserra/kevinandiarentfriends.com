<?php                                                


class More extends Controller {

    function More()
    {
        parent::Controller();    
    }
    
    function index()
    {
        if($this->input->post('offset'))
        {
            
            $this->load->model('Kevin');

            $data['items'] = $this->Kevin->grab_more($this->input->post('offset'));
            
            if (count($data['items']) > 0)
            {
                $this->load->view('more', $data);
            }
        }
    }
}