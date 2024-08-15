<?php
namespace App\Command;

use App\Entity\ApiToken;

use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'app:tokens:available',
    description: 'After run this command you coudl se the tokens avalable to use in the X-AUTH-TOKEN header when you make a request to the Api rest.',
    aliases: ['app:tok:ava'],
    hidden: false
)]
class TokesAvailableCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $apiTokenRepository = $this->entityManager->getRepository(ApiToken::class);
        $tokens = $apiTokenRepository->findAll();

        if(empty($tokens)){
            $output->writeln('<info>There is not any token available to login</info>');
            return Command::SUCCESS;
        }

        $tokensToPrint = [];
        foreach ($tokens as $token){
            if($token->isValid()){
                $userEmail = $token->getOwnedBy()?->getEmail();
                if ($userEmail && !isset($tokensToPrint[$userEmail])) {
                    $tokensToPrint[$userEmail] = [];
                }
                $tokensToPrint[$userEmail][] = $token->getToken();
            }
        }

        $users = array_keys($tokensToPrint);
        $output->writeln('<info>Tokens Avaialble By User.</info>');
        foreach ($users as $userEmail){
            $output->writeln("<bg=yellow;options=bold>User Identifier: $userEmail</>");
            $output->writeln("<fg=black;bg=cyan>| N | Token                                                                |</>");
            foreach ($tokensToPrint[$userEmail] as $index => $token) {
                $key = $index+1;
                $output->writeln("<fg=black;bg=cyan>| $key | $token |</>");

            }
            $output->writeln('<bg=yellow;options=bold>=========================</>');
        }
        return Command::SUCCESS;

    }
}
