<?php

namespace App\Service;

use App\Entity\Competition;
use App\Entity\Matches;
use App\Entity\Stadium;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;

class MatchGeneratorService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateMatches(): void
    {
        $competitions = $this->entityManager->getRepository(Competition::class)->findAll();
        $stadiums = $this->entityManager->getRepository(Stadium::class)->findAll();

        foreach ($competitions as $competition) {
            $seasons = $competition->getSeasons();
            if ($seasons->count() === 0) {
                continue; // Skip if no season is associated
            }

            $this->createMatchesForCompetition($competition, $stadiums);
        }
    }

    private function createMatchesForCompetition(Competition $competition, array $stadiums): void
    {
        $teams = $this->entityManager->getRepository(Team::class)->findAll();
        shuffle($teams); // Shuffle the array to randomize the team order

        $numTeams = count($teams);

        foreach ($teams as $i => $iValue) {
            for ($j = $i + 1; $j < $numTeams; $j++) {
                $teamA = $iValue;
                $teamB = $teams[$j];

                $match = new Matches();
                $match->setTeamA($teamA);
                $match->setTeamB($teamB);
                $match->setDate((new \DateTime())->add(new \DateInterval('P3'.$i.'D'))); // Or generate a specific date
                $match->setStadium($stadiums[array_rand($stadiums)]); // Random stadium

                // Assign a competition to the match
                $match->setCompetition($competition);

                $this->entityManager->persist($match);
            }
        }
    }
}