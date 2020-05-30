<?php


namespace pomidorki;


trait Observable
{
    private $listeners = [];

    public function addListener($listener) {
        $this->listeners[] = $listener;
    }

    public function trigger($event, $data) {
        foreach ($this->listeners as $listener) {
            $listener($event, $data);
        }
    }
}