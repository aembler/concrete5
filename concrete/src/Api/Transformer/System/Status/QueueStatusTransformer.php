<?php
namespace Concrete\Core\Api\Transformer\System\Status;

use Concrete\Core\System\Status\QueueStatus;
use League\Fractal\TransformerAbstract;

class QueueStatusTransformer extends TransformerAbstract
{

    public function transform(QueueStatus $status)
    {
        return [
            'queues' => $status->getQueues(),
        ];
    }

}
