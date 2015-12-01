<?php


class Home extends Controller {

    function Home()
    {
        parent::Controller();
    }

    function index()
    {
        $this->load->model('Kevin');

        $data['items'] = $this->Kevin->grab_tweets();

        $this->load->view('home', $data);
    }
}