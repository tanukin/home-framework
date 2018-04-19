<?php

use Otus\Dto\FilmOptionsDto;
use Otus\Entities\Film;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Services\PopularFilmsByAgeRangeService;
use PHPUnit\Framework\TestCase;

class PopularFilmsByAgeRangeServiceTest extends TestCase
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
            [18, 35, $this->getArrayFilms()],
            [35, 18, $this->getArrayFilms()],
        ];
    }

    /**
     * @dataProvider correctDataDataProvider
     */
    public function testShould_ReturnArray_When_CorrectData(int $fromAge, int $toAge, array $expected)
    {
        $this->filmRepository
            ->expects($this->once())
            ->method('getPopularFilmsByAgeRange')
            ->with($this->equalTo(min($fromAge, $toAge)), $this->equalTo(max($fromAge, $toAge)))
            ->willReturn($this->getArrayFilms());

        $this->setArgumentsDto($fromAge, $toAge);
        $popularFilmsByAgeRangeService = new PopularFilmsByAgeRangeService();

        $result = $popularFilmsByAgeRangeService->getFilms($this->filmRepository, $this->optionsDto);

        $this->assertEquals($expected, $result);
    }

    public function negativeDataDataProvider()
    {
        return [
            [-1, 35],
            [18, -1],
            [-1, -1],
        ];
    }

    /**
     * @dataProvider negativeDataDataProvider
     * @expectedException \Otus\Exceptions\FilmsException
     */
    public function testShould_ReturnException_When_ArgumentNegative(int $fromAge, int $toAge)
    {
        $this->setArgumentsDto($fromAge, $toAge);
        $popularFilmsByAgeRangeService = new PopularFilmsByAgeRangeService();

        $popularFilmsByAgeRangeService->getFilms($this->filmRepository, $this->optionsDto);
    }

    private function setArgumentsDto(int $fromAge, int $toAge): void
    {
        $this->optionsDto->setFromAge($fromAge);
        $this->optionsDto->setToAge($toAge);
    }

    private function getArrayFilms(): array
    {
        return [
            new Film(self::ID, self::TITLE, self::REALISE_DATE)
        ];
    }
}