<?php

use Otus\Dto\FilmOptionsDto;
use Otus\Entities\Film;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Services\PopularFilmsByGenreService;
use PHPUnit\Framework\TestCase;

class PopularFilmsByGenreServiceTest extends TestCase
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
        return[
            ["Drama,Thriller,Comedy", $this->getArrayFilms()],
            ["Drama,Thriller", $this->getArrayFilms()],
            ["Drama", $this->getArrayFilms()],
        ];
    }

    /**
     * @dataProvider correctDataDataProvider
     */
    public function testShould_ReturnArray_When_CorrectData(string $genresList, array $expected)
    {
        $this->filmRepository
            ->expects($this->once())
            ->method("getPopularFilmsByGenre")
            ->with($this->equalTo(explode(',', $genresList)))
            ->willReturn($this->getArrayFilms());

        $this->setArgumentsDto($genresList);
        $popularFilmsByGenreServiceTest = new PopularFilmsByGenreService();

        $result = $popularFilmsByGenreServiceTest->getFilms($this->filmRepository, $this->optionsDto);

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \Otus\Exceptions\FilmsException
     */
    public function testShould_ReturnException_When_DataNull()
    {
        $genresList = null;
        $this->setArgumentsDto($genresList);
        $popularFilmsByGenreServiceTest = new PopularFilmsByGenreService();

        $popularFilmsByGenreServiceTest->getFilms($this->filmRepository, $this->optionsDto);
    }

    private function setArgumentsDto($genresList): void
    {
        $this->optionsDto->setGenresList($genresList);
    }

    private function getArrayFilms(): array
    {
        return [
            new Film(self::ID, self::TITLE, self::REALISE_DATE)
        ];
    }
}