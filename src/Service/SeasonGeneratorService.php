<?php
namespace App\Service;

use App\Entity\Season;
use Doctrine\ORM\EntityManagerInterface;

class SeasonGeneratorService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Generates football league seasons.
     *
     * @param int $startYear The starting year of the first season.
     * @param int $numberOfSeasons The number of seasons to generate.
     * @return void
     */
    public function generateSeasons(int $startYear, int $numberOfSeasons): void
    {

        for ($i = 0; $i < $numberOfSeasons; $i++) {

            $seasonStartYear = $startYear + $i;
            $seasonEndYear = $seasonStartYear + 1;
            $seasonName = $this->buildSeasonName($seasonStartYear, $seasonEndYear);
            $seasonRepository = $this->entityManager->getRepository(Season::class);
            $season = $seasonRepository->findOneBy(['name' => $seasonName]);

            if ($season) {
                continue;
            }

            $season = new Season();
            $season->setName($seasonName);

            // Assuming seasons start in August and end in May of the next year
            $startDate = new \DateTime("{$seasonStartYear}-08-01");
            $endDate = new \DateTime("{$seasonEndYear}-05-31");

            $season->setStartDate($startDate);
            $season->setEndDate($endDate);

            // Persist each season to the database
            $this->entityManager->persist($season);
        }

        // Flush once after all seasons have been persisted
        $this->entityManager->flush();
    }

    public function buildSeasonName(int $startYear, int $endYear): string
    {
        return "$startYear/$endYear";
    }
}
