<?php

namespace Concrete\Core\Foundation\Queue;

use Bernard\BernardEvents;
use Bernard\Event\EnvelopeEvent;
use Bernard\Event\RejectEnvelopeEvent;
use Concrete\Core\Logging\Channels;
use Concrete\Core\Logging\LoggerAwareInterface;
use Concrete\Core\Logging\LoggerAwareTrait;
use Concrete\Core\System\Mutex\MutexInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BernardSubscriber implements EventSubscriberInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;

    public function getLoggerChannel()
    {
        return Channels::CHANNEL_QUEUE;
    }

    public static function getSubscribedEvents()
    {
        return array(
            BernardEvents::REJECT => array(
                array('onReject')
            )
        );
    }

    public function onReject(RejectEnvelopeEvent $event)
    {
        $this->logger->error(t('Error processing queue item: %s – %s',
            $event->getEnvelope()->getMessage()->getName(),
            $event->getException()->getMessage()
        ));
    }
}