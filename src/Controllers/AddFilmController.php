<?php

namespace Otus\Controllers;

use Otus\Core\ResponseBuilder;
use Otus\Dto\Error;
use Otus\Entities\Film;
use Otus\Exceptions\InvalidMethodException;
use Otus\Interfaces\AddFilmServiceInterface;
use Otus\Interfaces\ControllerInterface;
use Otus\Interfaces\RequestInterface;
use Otus\Interfaces\ResponseInterface;
use Otus\Interfaces\WorkerSenderInterface;

class AddFilmController implements ControllerInterface
{
    /**
     * @var WorkerSenderInterface
     */
    private $sender;

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
     * @param WorkerSenderInterface $sender
     * @param AddFilmServiceInterface $service
     * @param ResponseBuilder $responseBuilder
     */
    public function __construct(
        WorkerSenderInterface $sender,
        AddFilmServiceInterface $service,
        ResponseBuilder $responseBuilder
    )
    {
        $this->sender = $sender;
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

            $film = new Film(null, $request->getParam("title"), $request->getParam("realiseDate"));
            $data = $this->service->add($this->sender, $film);

        } catch (InvalidMethodException $e) {
            $data[] = $this->responseBuilder->createError(Error::BAD_REQUEST, $e->getMessage());
        } catch (\Exception $e) {
            $data[] = $this->responseBuilder->createError(Error::SERVER_ERROR, $e->getMessage());
        }finally{
            return $this->responseBuilder->getResponse($data);
        }
    }
}