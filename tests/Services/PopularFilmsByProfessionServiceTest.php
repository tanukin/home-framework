<?php

use Otus\Dto\FilmOptionsDto;
use Otus\Entities\Film;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Services\PopularFilmsByProfessionService;
use PHPUnit\Framework\TestCase;

class PopularFilmsByProfessionServiceTest extends TestCase
{
    /**
     * @var FilmRepositoryInterface
     */
    private $filmRepository;

    /**
     * @var FilmOptionsDto
     */
    private $optionsDto;

    const ID = 1;
    const TITLE = "title";
    const REALISE_DATE = "2018-04-17";

    public function setUp()
    {
        $this->filmRepository = $this->createMock(FilmRepositoryInterface::class);
        $this->optionsDto = new FilmOptionsDto();
        parent::setUp();
    }

    public function correctDataDataProvider()
    {
        return [
            ["Engineer,Programmer,Marketing", $this->getArrayFilms()],
            ["Engineer,Programmer", $this->getArrayFilms()],
            ["Engineer", $this->getArrayFilms()],
        ];
    }

    /**
     * @dataProvider correctDataDataProvider
     */
    public function testShould_ReturnArrayFilms_When_CorrectData(string $professionsList, array $expected)
    {
        $this->filmRepository
            ->expects($this->once())
            ->method("getPopularFilmsByProfession")
            ->with($this->equalTo(explode(',', $professionsList)))
            ->willReturn($this->getArrayFilms());

        $this->setArgumentDto($professionsList);
        $popularFilmsByProfessionService = new PopularFilmsByProfessionService();

        $result = $popularFilmsByProfessionService->getFilms($this->filmRepository, $this->optionsDto);

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException  \Otus\Exceptions\FilmsException
     */
    public function testShould_ReturnException_When_DataNull()
    {
        $professionsList = null;
        $this->setArgumentDto($professionsList);
        $popularFilmsByProfessionService = new PopularFilmsByProfessionService();

        $popularFilmsByProfessionService->getFilms($this->filmRepository, $this->optionsDto);
    }

    private function getArrayFilms(): array
    {
        return [
            new Film(self::ID, self::TITLE, self::REALISE_DATE)
        ];
    }

    private function setArgumentDto($professionsList): void
    {
        $this->optionsDto->setProfessionsList($professionsList);
    }
}