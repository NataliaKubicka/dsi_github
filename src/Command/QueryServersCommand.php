<?php


namespace App\Command;


use App\Entity\Servers;
use App\Repository\ServersRepository;
use Doctrine\ORM\EntityManagerInterface;
use JJG\Ping;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueryServersCommand extends Command
{
    protected static $defaultName = 'app:query-server';

    /**
     * @var $entityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct(self::$defaultName);

    }

    protected function configure()
    {
        $this
            ->setDescription('Query to server IP to check status')
            ->setHelp('This command allows to check server status')
            ->addArgument('host', InputArgument::OPTIONAL, 'Set Host');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Ping Server',
            '============',
            '',
        ]);

        $this->pingIp($output);
    }

    public function pingIp(OutputInterface $output)
    {
        $servers = $this->entityManager->getRepository(Servers::class)->findAll();

        $hosts = [];
        foreach ($servers as $key=>$server){
            $server->setStatus(3);
            $this->entityManager->persist($server);
            $this->entityManager->flush();
            $hosts[] = $server->getIp();

            $ping = exec('ping -c 1 -s 1 '.$hosts[$key].' | grep "100% packet loss"');

            if ($ping != '') {
                $output->writeln($hosts[$key]." - no ok");
                $server->setStatus(0);

                $this->entityManager->persist($server);
                $this->entityManager->flush();
            } else {
                $output->writeln($hosts[$key]." - ok");
                $server->setStatus(1);
                $this->entityManager->persist($server);
                $this->entityManager->flush();
            }

        }

    }
}