<?php

declare(strict_types=1);

namespace Common\Log\Writer;

use Gelf;
use Common\Exception\CriticalException;
use Laminas\Log\Writer\AbstractWriter;

class Graylog extends AbstractWriter
{
    public const TRANSPORT_TCP = 'TCP';
    public const TRANSPORT_UDP = 'UDP';

    protected Gelf\Transport\TransportInterface $transport;

    /**
     * Gelf constructor.
     * @param $transportType
     * @param $address
     * @param $port
     */
    public function __construct($transportType, $address, $port)
    {
        $this->transport = $this->transportFactory($transportType, $address, $port);
    }

    protected function transportFactory($transportType, $address, $port): Gelf\Transport\AbstractTransport
    {
        switch ($transportType) {
            case self::TRANSPORT_TCP:
                $transport = new Gelf\Transport\TcpTransport($address, $port);
                break;
            case self::TRANSPORT_UDP:
                $transport = new Gelf\Transport\UdpTransport($address, $port);
                break;
            default:
                throw CriticalException::unknownGraylogTransport(
                    'Not registered transport type for graylog',
                    ['transport' => $transportType]
                );
        }

        return $transport;
    }

    protected function doWrite(array $event)
    {
        $publisher = new Gelf\Publisher();
        $publisher->addTransport($this->transport);

        $message = new Gelf\Message();
        $message->setShortMessage($event['message'])
            ->setLevel($event['priority'])
            ->setFullMessage(json_encode($event['extra']))
            ->setFacility($_ENV['SERVICE_NAME'])
            ->setTimestamp($event['timestamp'])
            ->setAdditional('service_name', $_ENV['SERVICE_NAME'])
            ->setAdditional('x-request-id', $_SERVER['HTTP_X_REQUEST_ID'] ?? 'undefined')
            ->setAdditional('http_referrer', $_SERVER['HTTP_REFERRER'] ?? '/')
            ->setAdditional('remote_addr', $_SERVER['REMOTE_ADDR'])
            ->setAdditional('service_referrer', $_SERVER['HTTP_X_SERVICE_REFERRER'] ?? 'unknown')
            ->setAdditional('log_id', $_ENV['LOG_ID'] ?? 'undefined')
            ->setAdditional('exception_code', $event['extra']['status'] ?? 0);

        $publisher->publish($message);
    }
}
