<?php

use Otus\Dto\FilmOptionsDto;
use Otus\Entities\Film;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Services\PopularFilmsByPeriodService;
use PHPUnit\Framework\TestCase;

class PopularFilmsByPeriodServiceTest extends TestCase
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
            [1991, 2018, $this->getArrayFilms()],
            [2018, 1991, $this->getArrayFilms()],
        ];
    }

    /**
     * @dataProvider correctDataDataProvider
     */
    public function testShould_ReturnArray_When_CorrectData(int $fromYear, int $toYear, array $expected)
    {
        $this->filmRepository
            ->expects($this->once())
            ->method('getPopularFilmsByPeriod')
            ->with($this->equalTo(min($fromYear, $toYear)), $this->equalTo(max($fromYear, $toYear)))
            ->willReturn($this->getArrayFilms());

        $this->setArgumentsDto($fromYear, $toYear);
        $popularFilmsByPeriodService = new PopularFilmsByPeriodService();

        $result = $popularFilmsByPeriodService->getFilms($this->filmRepository, $this->optionsDto);

        $this->assertEquals($expected, $result);
    }

    public function negativeDataDataProvider()
    {
        return [
            [-1, 2018],
            [1991, -1],
            [-1, -1],
        ];
    }

    /**
     * @dataProvider negativeDataDataProvider
     * @expectedException \Otus\Exceptions\FilmsException
     */
    public function testShould_ReturnException_When_ArgumentNegative(int $fromYear, int $toYear)
    {
        $this->setArgumentsDto($fromYear, $toYear);
        $popularFilmsByPeriodService = new PopularFilmsByPeriodService();

        $popularFilmsByPeriodService->getFilms($this->filmRepository, $this->optionsDto);
    }

    private function setArgumentsDto(int $fromYear, int $toYear): void
    {
        $this->optionsDto->setFromYear($fromYear);
        $this->optionsDto->setToYear($toYear);
    }

    private function getArrayFilms(): array
    {
        return [
            new Film(self::ID, self::TITLE, self::REALISE_DATE)
        ];
    }
}