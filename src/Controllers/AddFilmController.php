<?php

namespace Otus\Controllers;

use Otus\Core\ControllerWorkerFactory;
use Otus\Core\ResponseBuilder;
use Otus\Dto\Error;
use Otus\Entities\Film;
use Otus\Exceptions\InvalidMethodException;
use Otus\Exceptions\RabbitException;
use Otus\Interfaces\AddFilmServiceInterface;
use Otus\Interfaces\ControllerInterface;
use Otus\Interfaces\RequestInterface;
use Otus\Interfaces\ResponseInterface;

class AddFilmController implements ControllerInterface
{
    /**
     * @var ControllerWorkerFactory
     */
    private $senderFactory;

    /**
     * @var AddFilmServiceInterface
     */
    private $service;

    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    /**
     * AddFilmController constructor.
     *
     * @param ControllerWorkerFactory $senderFactory
     * @param AddFilmServiceInterface $service
     * @param ResponseBuilder $responseBuilder
     */
    public function __construct(
        ControllerWorkerFactory $senderFactory,
        AddFilmServiceInterface $service,
        ResponseBuilder $responseBuilder
    )
    {
        $this->senderFactory = $senderFactory;
        $this->service = $service;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(RequestInterface $request): ResponseInterface
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] != "POST")
                throw new InvalidMethodException("Only allowed the request method POST");

            $film = new Film(0, $request->getParam("title"), $request->getParam("realiseDate"));
            $data = $this->service->add($this->senderFactory->getSender(), $film);

        } catch (InvalidMethodException $e) {
            $data[] = $this->responseBuilder->createError(Error::BAD_REQUEST, $e->getMessage());
        } catch (RabbitException $e) {
            $data[] = $this->responseBuilder->createError(Error::SERVER_ERROR, $e->getMessage());
        } finally {
            return $this->responseBuilder->getResponse($data);
        }
    }
}