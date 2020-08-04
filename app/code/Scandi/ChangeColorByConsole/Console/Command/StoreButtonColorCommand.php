<?php

namespace Scandi\ChangeColorByConsole\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StoreButtonColorCommand extends Command
{
    private $storeManager;

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('store:button-color:change')
            ->setDescription('Changes the buttons color based in store ID')
            ->setDefinition([
                new InputArgument(
                    'colorHex',
                    InputArgument::REQUIRED,
                    'The color for the buttons in hex format'
                ),
                new InputArgument(
                    'storeId',
                    InputArgument::REQUIRED,
                    'The store ID for the buttons to change'
                )
            ]);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $colorHex = $this->validateHex($input->getArgument('colorHex'));
        $storeId = $input->getArgument('storeId');

        try {
            $store = $this->storeManager->getStore($storeId);
            $storeDesign = $store->getConfig('design/head/includes');
        } catch (NoSuchEntityException $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        $output->writeln('Enabled test mode.');
    }

    /*
     * @todo
     */
    protected function validateHex($hex)
    {
        return $hex;
    }
}
