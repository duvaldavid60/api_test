<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Stopwatch\Stopwatch;

class BeginRequestListener
{
    public function __construct(Stopwatch $stopwatch)
    {
        $this->stopwatch = $stopwatch;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->stopwatch->start('request');
    }
}
