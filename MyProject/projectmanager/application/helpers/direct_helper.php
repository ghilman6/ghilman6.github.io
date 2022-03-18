<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if ($this->uri->segment(1) != null) {
    $url = $this->uri->segment(1);
    $url = $url.' '.$this->uri->segment(2);
    $url = $url.' '.$this->uri->segment(3);
    redirect('welcome/relogin/?url='.$url.'', 'refresh');
} else {
    redirect('welcome/relogin', 'refresh');
}
