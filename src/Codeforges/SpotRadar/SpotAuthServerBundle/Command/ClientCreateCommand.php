<?php

namespace Codeforges\SpotRadar\SpotAuthServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;

class ClientCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('oauth:client:create')
            ->setDescription('Create OAuth Client')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Client Name?'
            )
            ->addArgument(
                'redirectUri',
                InputArgument::REQUIRED,
                'Redirect URI?'
            )
            ->addArgument(
                'grantType',
                InputArgument::REQUIRED,
                'Grant Type?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $oauthServer = $container->get('fos_oauth_server.server');

        $name = $input->getArgument('name');
        $redirectUri = $input->getArgument('redirectUri');
        $grantType = $input->getArgument('grantType');

        $clientManager = $container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setName($name);
        $client->setRedirectUris([$redirectUri]);
        $client->setAllowedGrantTypes([$grantType]);
        $clientManager->updateClient($client);

        $output->writeln(sprintf("<info>The client <comment>%s</comment> was created with <comment>%s</comment> as public id and <comment>%s</comment> as secret</info>",
            $client->getName(),
            $client->getPublicId(),
            $client->getSecret()));
        
        //TODO: Add check for db driver type
        $customers = $container->get('doctrine_mongodb')->getRepository('SpotApiBundle:Document\User')->findAll();

        foreach ($customers as $customer) {
            $queryData = [];
            $queryData['client_id'] = $client->getPublicId();
            $queryData['redirect_uri'] = $client->getRedirectUris()[0];
            $queryData['response_type'] = 'code';
            $authRequest = new Request($queryData);

            $oauthServer->finishClientAuthorization(true, $customer, $authRequest, $grantType);

            $output->writeln(sprintf("<info>User <comment>%s</comment> linked to client <comment>%s</comment></info>",
                $customer->getId(),
                $client->getName()));
        }
    }
}