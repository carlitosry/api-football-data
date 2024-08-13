<?php
namespace App\Command;

use App\Entity\Team;
use App\Entity\Season;
use App\Entity\Stadium;
use App\Entity\Competition;
use App\Entity\Player;
use App\Service\MatchGeneratorService;
use App\Service\SeasonGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'app:load:csv-data',
    description: 'Load data for Teams, Players, Competition, Season, Matches and Stadium entities.',
    aliases: ['app:load:csv', 'app:loa:csv'],
    hidden: false
)]
class LoadCsvDataCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly MatchGeneratorService $matchGenerator,
        private readonly SeasonGeneratorService $seasonGenerator,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Load data from a CSV file into the database.')
            ->addArgument('csv-file', InputArgument::REQUIRED, 'Path to the CSV file')
        ;
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $csvFile = $input->getArgument('csv-file');

        if (!file_exists($csvFile)) {
            $output->writeln('<error>File does not exist.</error>');
            return Command::FAILURE;
        }

        $reader = Reader::createFromPath($csvFile, 'r');
        $reader->setHeaderOffset(0); // Set the header offset
        $records = $reader->getRecords();

        $this->seasonGenerator->generateSeasons((int)(new \DateTime())->format('Y'), 3);

        foreach ($records as $record) {
            $team = $this->findOrCreateTeam($record);
            $this->findOrCreatePlayer($record, $team);
            $this->findOrCreateCompetition($record);
        }

        $this->entityManager->flush();
        $this->matchGenerator->generateMatches();

        $output->writeln('<info>Data loaded successfully.</info>');
        return Command::SUCCESS;
    }

    /**
     * @throws \Exception
     */
    private function findOrCreateTeam(array $record): Team
    {
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $team = $teamRepository->findOneBy(['name' => $record['team']]);

        if (!$team) {
            $team = new Team();
            $team->setName($record['team'])
                ->setShortname($record['team.shortname'])
                ->setFoundation(new \DateTime($record['team.foundation']))
                ->setShield($record['team.shield'])
                ->setPhoto($record['photo']);

            $stadium = $this->findOrCreateStadium($record);
            $team->setStadium($stadium);

            $this->entityManager->persist($team);
        }

        return $team;
    }

    private function findOrCreateStadium(array $record): ?Stadium
    {
        $stadiumRepository = $this->entityManager->getRepository(Stadium::class);
        $stadium = $stadiumRepository->findOneBy(['name' => $record['stadium']]);

        if (!$stadium) {
            $stadium = new Stadium();
            $stadium->setName($record['stadium'])
                ->setStadiumImage($record['stadium.image']);

            $this->entityManager->persist($stadium);
        }

        return $stadium;
    }

    private function findOrCreatePlayer(array $record, Team $team): void
    {
        $playerRepository = $this->entityManager->getRepository(Player::class);
        $player = $playerRepository->findOneBy(['slug' => $record['slug']]);

        if (!$player) {
            $player = new Player;
            $player
                ->setSlug($record['slug'])
                ->setSlug($record['slug'])
                ->setExternalId($record['id'])
                ->setExternalUrl($record['player.url'])
                ->setNickname($record['nickname'])
                ->setFirstname($record['firstname'])
                ->setLastname($record['lastname'])
                ->setGender($record['gender'])
                ->setDateOfBirth(new \DateTime($record['date_of_birth']))
                ->setPlaceOfBirth($record['place_of_birth'])
                ->setWeight((int) $record['weight'] ?: null)
                ->setHeight((int) $record['height'] ?: null)
                ->setInternational($record['international'] === 'TRUE')
                ->setTwitter($record['twitter'])
                ->setInstagram($record['instagram'])
                ->setCountry($record['country'])
                ->setShirtNumber((int)$record['shirt_number'] ?: null)
                ->setPosition($record['position'])
                ->setTeam($team);

            $this->entityManager->persist($player);
        }

    }

    /**
     * @throws \Exception
     */
    private function findOrCreateCompetition(array $record): void
    {
        $competitionRepository = $this->entityManager->getRepository(Competition::class);
        $competition = $competitionRepository->findOneBy(['name' => $record['competition']]);

        if (!$competition) {
            $competition = new Competition;
            $competition->setName($record['competition']);

            $currentYear = (int) (new \DateTime())->format('Y');
            $seasonName = $this->seasonGenerator->buildSeasonName($currentYear + 1, $currentYear +2);

            $seasonRepository = $this->entityManager->getRepository(Season::class);
            $season = $seasonRepository->findOneBy(['name' => $seasonName]);

            if($season){
                /** Since the file CSV does not contain season information, this entity will be created with the next hypothetical season. */
                $competition->setSeason($season);
            }

            $this->entityManager->persist($competition);
        }
        $this->entityManager->flush();

    }
}
